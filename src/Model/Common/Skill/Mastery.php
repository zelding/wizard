<?php

namespace App\Model\Common\Skill;

enum Mastery: string
{
    case Basic = 'Basic';
    case Master = 'Master';

    public static function Basic(): self
    {
        return Mastery::Basic;
    }

    public static function Master(): self
    {
        return Mastery::Master;
    }

    public function isBasic(): bool
    {
        return $this === Mastery::Basic;
    }

    public function isMaster(): bool
    {
        return $this === Mastery::Master;
    }
}
