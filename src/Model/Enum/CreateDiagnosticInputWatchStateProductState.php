<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum CreateDiagnosticInputWatchStateProductState: string
{
    case Ok = 'greenOk';
    case Scratched = 'yellowScratched';
    case Marked = 'orangeMarked';
    case Broken = 'redBroken';
}
