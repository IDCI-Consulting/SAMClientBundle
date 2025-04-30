<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealActivityApiActivity: string
{
    case A020 = 'Enregistrement';
    case W010 = 'Diagnostic';
    case A030 = 'Etablissement et envoi devis';
    case C025 = 'Attente autorisation client';
    case C030 = 'Devis en attente';
    case A040 = 'Préparation du travail';
    case W000 = 'Atelier';
    case W060 = 'Attente composants';
    case A050 = 'Validation du travail';
    case A060 = 'Facturation';
    case C040 = 'Attente client';
    case A070 = 'Expédition';

    public function code(): string
    {
        return $this->name;
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
