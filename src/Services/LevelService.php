<?php

namespace tizis\LevelSystem\Services;

use Illuminate\Database\Eloquent\Model;
use tizis\LevelSystem\Events\LevelUp;
use tizis\LevelSystem\Exceptions\ReachedTheMaximumLevelException;
use tizis\LevelSystem\Exceptions\ZeroOrNegativeExperienceIsNotAccepted;

class LevelService
{
    protected Model $user;
    protected array $levels;

    public function __construct(Model $user)
    {
        $this->user = $user;
        $this->levels = config('user-levels.levels');
    }

    public function addProgress(int $experience): void
    {
        $oldLevel = $this->user->level;

        if ($experience <= 0) {
            throw new ZeroOrNegativeExperienceIsNotAccepted();
        }

        if ($oldLevel > 0 && !isset($this->levels[$oldLevel])) {
            throw new ReachedTheMaximumLevelException();
        }

        $resultOfCalculation = $this->calculate($experience + $this->user->experience, $oldLevel);

        $this->updateAttributes($resultOfCalculation['level'], $resultOfCalculation['experience_remainder']);

        if ($oldLevel !== $resultOfCalculation['level']) {
            $this->emitEvent();
        }
    }

    private function calculate(int $experience, int $oldLevel): array
    {
        $experienceRemainder = 0;
        $maxLevel = count($this->levels);

        for ($newLevel = $oldLevel + 1; $newLevel <= $maxLevel; $newLevel++) {

            $requiredExperience = $this->levels[$newLevel];

            if ($experience === $requiredExperience) {
                $experienceRemainder = 0;
                break;
            }

            if ($experience < $requiredExperience) {
                $experienceRemainder = $experience;
                $newLevel--;
                break;
            }
            
            $experience = $experience - $requiredExperience;

            if ($newLevel + 1 > $maxLevel) {
                $experienceRemainder = $experience;
                break;
            }
        }

        return [
            'level' => $newLevel,
            'experience_remainder' => $experienceRemainder
        ];
    }

    private function updateAttributes(int $newLevel, int $experienceRemainder)
    {
        $this->user->experience = $experienceRemainder;
        $this->user->level = $newLevel;
        $this->user->save();
    }

    private function emitEvent()
    {
        event(new LevelUp($this->user));
    }
}
