<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi user yang sedang login.
     */
    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(10);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function read(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Notifikasi ditandai sudah dibaca.'
            );
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
     */
    public function readAll()
    {
        Notification::where(
            'user_id',
            auth()->id()
        )
        ->where(
            'is_read',
            false
        )
        ->update([
            'is_read' => true,
        ]);

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Semua notifikasi sudah dibaca.'
            );
    }
}
