<?php

namespace App\Handlers\Events;

use App\Events\ContactFormValid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailContactForm
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ContactFormValid  $event
     * @return void
     */
    public function handle(ContactFormValid $event)
    {
        \Mail::send('emails.contact',
            $event->data,
            function($message) {
                $message->from('wj@test.com');
                $message->to('dfs@test.com', 'Admin')->subject('Feedback');
            }
        );
    }
}
