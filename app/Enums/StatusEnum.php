<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Planned = 'planned';
    case InWork = 'in_work';
    case Testing = 'testing';
    case Finished = 'finished';
}
