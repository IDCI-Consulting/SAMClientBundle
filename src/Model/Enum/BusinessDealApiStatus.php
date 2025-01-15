<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiStatus: string
{
    case Active = 'active';
    case Closed = 'closed';
    case Canceled = 'canceled';
}
