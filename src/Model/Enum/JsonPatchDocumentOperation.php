<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum JsonPatchDocumentOperation: string
{
    case Add = 'add';
    case Remove = 'remove';
    case Replace = 'replace';
    case Move = 'move';
    case Copy = 'copy';
    case Test = 'test';
}
