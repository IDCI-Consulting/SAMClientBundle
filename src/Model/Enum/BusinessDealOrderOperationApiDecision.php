<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealOrderOperationApiDecision: string
{
    case accepted = 'accepted';
    case declined = 'declined';
    case addedDuringService = 'addedDuringService';
}
