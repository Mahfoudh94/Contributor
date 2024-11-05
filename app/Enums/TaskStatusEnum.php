<?php

namespace App\Enums;

enum TaskStatusEnum: int
{
    case Planned = 0;
    case Active = 1;
    case Done = 2;
    case Canceled = 3;
}
