<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Models\User;
use App\Notifications\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

// Aqui estamos marcando nuestro listener SholdQueue que le dice a Laravel que nuestro detector debe ejectutarse en una cola 
class SendPostCreatedNotifications implements ShouldQueue
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
    public function handle(PostCreated $event)

    // Aqui estamos configurando nuestro listener para que avise a todos los usuarios cuando se cree un post
    {
        foreach(User::whereNot('id', $event->post->user_id)->cursor() as $user)
        {
            $user->notify(new NewPost($event->post));
        }
    }
}
