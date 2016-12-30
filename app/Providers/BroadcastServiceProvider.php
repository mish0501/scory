<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use App\TestRoom;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('App.User.*', function ($user, $userId) {
            return (int) $user->id === (int) $userId;
        });

        Broadcast::channel('testroom.*', function ($user, $code) {
            return (int) $user->id === (int) TestRoom::where('code', $code)->get()[0]->teacher_id;
        });

        Broadcast::channel('MailChannel', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
