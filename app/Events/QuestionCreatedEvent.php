<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;

class QuestionCreatedEvent extends Event implements ShouldBroadcast
{

    use SerializesModels;

    public $question;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->question = $data;
    }

    public function broadcastOn()
    {
        return ['QuestionChannel'];
    }


}
