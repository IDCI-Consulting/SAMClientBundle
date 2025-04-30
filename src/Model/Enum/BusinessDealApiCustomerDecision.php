<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiCustomerDecision: string
{
    case _01 = 'Accepté';
    case _09 = 'Sans réponse';
    case _10 = 'Refusé (prix)';
    case _11 = 'Refusé (autre)';

    public function code(): string
    {
        return str_replace('_', '', $this->name);
    }

    public function text(): string
    {
        return $this->value;
    }

    public static function fromCode(string $code) : self {

        foreach(self::cases() as $enum){
            if($enum->code() === $code){
                return $enum;
            }
        }

        throw new \Exception("Not a valid code");
    }

    public static function fromText(string $text) : self {

        foreach(self::cases() as $enum){
            if($enum->text() === $text){
                return $enum;
            }
        }

        throw new \Exception("Not a valid text");
    }
}
