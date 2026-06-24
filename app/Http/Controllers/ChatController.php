<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
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

        $conversations = Conversation::whereHas('users', function ($q) use ($usrId) {
            $q->where('user_id', $usrId);
        })
            ->with(['proyecto', 'users', 'lastMessage'])
            ->orderByDesc(function ($q) {
                $q->select('created_at')->from('messages')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();

        $unreadCounts = [];
        foreach ($conversations as $conv) {
            $count = $conv->unreadMessagesCount($usrId);
            if ($count > 0) {
                $unreadCounts[$conv->id] = $count;
            }
        }

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

        $conversations = Conversation::whereHas('users', function ($q) use ($usrId) {
            $q->where('user_id', $usrId);
        })
            ->with(['proyecto', 'users', 'lastMessage'])
            ->orderByDesc(function ($q) {
                $q->select('created_at')->from('messages')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();

        $unreadCounts = [];
        foreach ($conversations as $conv) {
            $count = $conv->unreadMessagesCount($usrId);
            if ($count > 0) {
                $unreadCounts[$conv->id] = $count;
            }
        }

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

        $existing = Conversation::where('proyecto_id', $proyecto->id)
            ->whereHas('users', function ($q) use ($usrId) {
                $q->where('user_id', $usrId);
            })
            ->first();

        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }

        $conversation = Conversation::create(['proyecto_id' => $proyecto->id]);

        $empresaUser = $proyecto->empresa?->usuario;
        $instructorUser = $proyecto->instructor?->usuario;

        if ($empresaUser) {
            $conversation->users()->attach($empresaUser->id);
        }
        if ($instructorUser) {
            $conversation->users()->attach($instructorUser->id);
        }

        if ($user->rol_id === User::ROL_EMPRESA && $instructorUser) {
            $conversation->users()->syncWithoutDetaching([$usrId]);
        } elseif ($user->rol_id === User::ROL_INSTRUCTOR && $empresaUser) {
            $conversation->users()->syncWithoutDetaching([$usrId]);
        }

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
        })->get()->sum(function ($conv) use ($usrId) {
            return $conv->unreadMessagesCount($usrId);
        });

        return response()->json(['unread' => $total]);
    }
}
