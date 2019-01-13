<?php

namespace LaravelEnso\Core\app\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use LaravelEnso\Core\app\Http\Resources\IO;
use Illuminate\Foundation\Events\Dispatchable;
use LaravelEnso\Core\app\Contracts\IOOperation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IOEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $operation;
    private $event;

    public function __construct(IOOperation $operation, $event)
    {
        $this->operation = $operation;
        $this->event = $event;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('operations.'.$this->operation->created_by);
    }

    public function broadcastWith()
    {
        return ['operation' => (new IO($this->operation))->resolve()];
    }

    public function broadcastAs()
    {
        return $this->event;
    }
}
