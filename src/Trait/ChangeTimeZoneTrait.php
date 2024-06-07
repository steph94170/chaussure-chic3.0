<?php

namespace App\Trait;

    trait ChangeTimeZoneTrait
    {
        public function ChangeTimeZone(string $timeZone) : void
        {
            \date_default_timezone_set($timeZone);
        }
    }
