<?php

namespace tizis\LevelSystem\Exceptions;

class ZeroOrNegativeExperienceIsNotAccepted extends \DomainException
{
    protected $message = 'ZeroOrNegativeExperienceIsNotAccepted';
}
