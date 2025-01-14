<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum UpdateActivityInputStatus: string
{
    case Started = 'started';
    case Paused = 'paused';
    case Terminated = 'terminated';
}
