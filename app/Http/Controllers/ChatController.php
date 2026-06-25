<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Postulacion;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $usrId = session('usr_id');
        $user = User::find($usrId);

        $conversations = $this->getUserConversations($usrId);
        $unreadCounts = $this->buildUnreadCounts($conversations);

        return view('shared.chat.index', compact('conversations', 'unreadCounts', 'user'));
    }

    public function show(Conversation $conversation): View
    {
        $usrId = session('usr_id');

        if (! $conversation->users()->where('user_id', $usrId)->exists()) {
            abort(403);
        }

        $messages = $conversation->messages()
            ->with('sender')
            ->orderBy('created_at')
            ->paginate(50);

        $conversation->messages()
            ->where('sender_id', '!=', $usrId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $user = User::find($usrId);

        $conversations = $this->getUserConversations($usrId);
        $unreadCounts = $this->buildUnreadCounts($conversations);

        return view('shared.chat.index', compact('conversations', 'messages', 'conversation', 'unreadCounts', 'user'));
    }

    public function store(Request $request)
    {
        $usrId = session('usr_id');
        $user = User::find($usrId);

        $validated = $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
        ]);

        $proyecto = Proyecto::findOrFail($validated['proyecto_id']);

        // Security: verify user is authorized for this project
        if ($user->rol_id === User::ROL_APRENDIZ) {
            $aprendiz = \App\Models\Aprendiz::where('usuario_id', $usrId)->first();
            $accepted = $aprendiz && Postulacion::where('aprendiz_id', $aprendiz->id)
                ->where('proyecto_id', $proyecto->id)
                ->where('estado', 'aceptada')
                ->exists();
            if (!$accepted) {
                abort(403);
            }
        } elseif ($user->rol_id === User::ROL_INSTRUCTOR) {
            if ((int) $proyecto->instructor_usuario_id !== $usrId) {
                abort(403);
            }
        } elseif ($user->rol_id === User::ROL_EMPRESA) {
            if ($proyecto->empresa?->usuario_id !== $usrId) {
                abort(403);
            }
        }

        $existing = Conversation::where('proyecto_id', $proyecto->id)->first();

        if ($existing) {
            if (!$existing->users()->where('user_id', $usrId)->exists()) {
                $existing->users()->syncWithoutDetaching([$usrId]);
            }
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create(['proyecto_id' => $proyecto->id]);

        $participantIds = [];

        $instructorUser = $proyecto->instructor?->usuario;

        if ($instructorUser) {
            $participantIds[] = $instructorUser->id;
        }

        $acceptedApprentices = Postulacion::where('proyecto_id', $proyecto->id)
            ->where('estado', 'aceptada')
            ->with('aprendiz.usuario')
            ->get();

        foreach ($acceptedApprentices as $postulacion) {
            if ($postulacion->aprendiz?->usuario) {
                $participantIds[] = $postulacion->aprendiz->usuario->id;
            }
        }

        $participantIds = array_unique($participantIds);

        if (!in_array($usrId, $participantIds)) {
            $participantIds[] = $usrId;
        }

        $conversation->users()->attach($participantIds);

        return redirect()->route('chat.show', $conversation->id);
    }

    public function send(Request $request, Conversation $conversation)
    {
        $usrId = session('usr_id');

        if (! $conversation->users()->where('user_id', $usrId)->exists()) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $user = User::find($usrId);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $usrId,
            'message' => $validated['message'],
        ]);

        $conversation->touch();

        broadcast(new MessageSent($conversation, $message, $user))->toOthers();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $message->id,
                'message' => $message->message,
                'created_at' => $message->created_at->format('H:i'),
                'created_at_iso' => $message->created_at->toISOString(),
                'sender' => ['id' => $user->id, 'name' => $user->nombre, 'rol' => $user->nombre_rol],
                'conversation_id' => $conversation->id,
            ]);
        }

        return redirect()->back();
    }

    public function poll(Request $request, Conversation $conversation)
    {
        $usrId = session('usr_id');

        if (! $conversation->users()->where('user_id', $usrId)->exists()) {
            abort(403);
        }

        $afterId = (int) $request->input('after_id', 0);

        $messages = $conversation->messages()
            ->with('sender')
            ->where('id', '>', $afterId)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages->map(function ($msg) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender' => [
                    'id' => $msg->sender->id,
                    'name' => $msg->sender->nombre,
                    'rol' => $msg->sender->nombre_rol,
                ],
                'created_at' => $msg->created_at->format('H:i'),
                'created_at_iso' => $msg->created_at->toISOString(),
                'conversation_id' => $msg->conversation_id,
            ];
        }));
    }

    public function markRead(Conversation $conversation)
    {
        $usrId = session('usr_id');

        if (! $conversation->users()->where('user_id', $usrId)->exists()) {
            abort(403);
        }

        $count = $conversation->messages()
            ->where('sender_id', '!=', $usrId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['marked_read' => $count]);
    }

    public function unreadCount()
    {
        $usrId = session('usr_id');

        $total = Conversation::whereHas('users', function ($q) use ($usrId) {
            $q->where('user_id', $usrId);
        })->withCount(['messages as unread_count' => function ($q) use ($usrId) {
            $q->where('sender_id', '!=', $usrId)->whereNull('read_at');
        }])->get()->sum('unread_count');

        return response()->json(['unread' => $total]);
    }

    private function getUserConversations(int $usrId)
    {
        return Conversation::whereHas('users', function ($q) use ($usrId) {
            $q->where('user_id', $usrId);
        })
            ->with(['proyecto', 'users', 'lastMessage'])
            ->withCount(['messages as unread_count' => function ($q) use ($usrId) {
                $q->where('sender_id', '!=', $usrId)->whereNull('read_at');
            }])
            ->orderByDesc(function ($q) {
                $q->select('created_at')->from('messages')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();
    }

    private function buildUnreadCounts($conversations): array
    {
        $unreadCounts = [];
        foreach ($conversations as $conv) {
            if ($conv->unread_count > 0) {
                $unreadCounts[$conv->id] = $conv->unread_count;
            }
        }
        return $unreadCounts;
    }
}
