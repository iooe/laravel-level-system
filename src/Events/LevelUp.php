<?php

namespace tizis\LevelSystem\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LevelUp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Model $user;
    public int $oldLevel;

    public function __construct(int $oldLevel, Model $user)
    {
        $this->user = $user;
        $this->oldLevel = $oldLevel;
    }
}
