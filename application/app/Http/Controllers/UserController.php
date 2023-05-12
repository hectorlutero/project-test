<?php

namespace App\Http\Controllers;

use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function readNotification(Request $request)
    {
        $user = Auth::user();
        if (isset($request->readAll) && $request->readAll == true) {
            Flasher::addPreset("all_notifications_read");
            $user->unreadNotifications()->update(['read_at' => now()]);
            return Redirect::back();
        }

        $user->unreadNotifications()->where('id', $request->id)->update(['read_at' => now()]);
        Flasher::addPreset("notification_read");
        return Redirect::back();

    }
}
