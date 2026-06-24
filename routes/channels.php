<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// ── Role-based channels ───────────────────────────────────────
Broadcast::channel('role.admin', function ($user) {
    return $user->rol_id === User::ROL_ADMIN
        ? ['id' => $user->id, 'nombre' => $user->nombre, 'rol' => 'admin']
        : false;
});

Broadcast::channel('role.aprendiz', function ($user) {
    return $user->rol_id === User::ROL_APRENDIZ
        ? ['id' => $user->id, 'nombre' => $user->nombre, 'rol' => 'aprendiz']
        : false;
});

Broadcast::channel('role.instructor', function ($user) {
    return $user->rol_id === User::ROL_INSTRUCTOR
        ? ['id' => $user->id, 'nombre' => $user->nombre, 'rol' => 'instructor']
        : false;
});

Broadcast::channel('role.empresa', function ($user) {
    return $user->rol_id === User::ROL_EMPRESA
        ? ['id' => $user->id, 'nombre' => $user->nombre, 'rol' => 'empresa']
        : false;
});

// ── Chat channels ─────────────────────────────────────────
Broadcast::channel('conversation.{id}', function ($user, $id) {
    $conversation = App\Models\Conversation::find($id);
    if (! $conversation) return false;

    return $conversation->users()->where('user_id', $user->id)->exists()
        ? ['id' => $user->id, 'nombre' => $user->nombre]
        : false;
});
