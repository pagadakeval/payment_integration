<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Facades\Mail;
class MailFired
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendMail $event): void
    {
        $user = User::find($event->user_id)->toArray();
        Mail::send('SendEmail',$user,function($message) use($user){
            $message->to($user['email']);
            $message->subject('Event LIstener');
        });
    }
}
