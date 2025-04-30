<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiDefectReason: string
{
    case _01 = 'Casse / Perte d\'assemblage';
    case _02 = 'Usure';
    case _03 = 'Lubrification / grippé';
    case _04 = 'Hors tolérences';
    case _05 = 'Indexation';
    case _06 = 'Oxydation';
    case _07 = 'Magnétisme';
    case _08 = 'Etanchéité';
    case _09 = 'Propreté fonctionnelle';
    case _10 = 'Propreté non fonctionnelle / Esthétique';
    case _11 = 'Ergonomie / confort';
    case _12 = 'Entretien';
    case _13 = 'Etat de surface';
    case _14 = 'Gravage / Poinçon';
    case _15 = 'Revêtement / Finition';
    case _16 = 'Porosité';
    case _17 = 'Sertissage';
    case _18 = 'Pas de défaut';

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