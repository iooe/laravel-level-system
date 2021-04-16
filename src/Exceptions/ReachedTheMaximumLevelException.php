<?php

namespace tizis\LevelSystem\Exceptions;

class ReachedTheMaximumLevelException extends \DomainException
{
    protected $message = 'Reached the maximum level exception';
}
