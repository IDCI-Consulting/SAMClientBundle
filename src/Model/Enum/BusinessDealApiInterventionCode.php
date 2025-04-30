<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiInterventionCode: string
{
    case _01 = 'Service complet, révision du mvt, avec polissage';
    case _02 = 'Service complet, révision du mvt, sans polissage';
    case _03 = 'Service complet, échange mvt reconditionné, avec polissage';
    case _04 = 'Service complet, échange mvt reconditionné, sans polissage';
    case _05 = 'Service complet, échange mvt neuf, avec polissage';
    case _06 = 'Service complet, échange mvt neuf, sans polissage';
    case _07 = 'Service de maintenance avec polissage';
    case _08 = 'Service de maintenance sans polissage';
    case _09 = 'Service pile';
    case _10 = 'Contrôle étanchéité';
    case _11 = 'Service bracelet avec polissage';
    case _12 = 'Service bracelet sans polissage';
    case _13 = 'Service boucle avec polissage';
    case _14 = 'Service boucle sans polissage';
    case _15 = 'Intervention partielle';
    case _16 = 'Pas d\'intervention';
    case _17 = 'Nettoyage';
    case _18 = 'Service bijouterie sans polissage';
    case _19 = 'Service bijouterie avec polissage';
    case _20 = 'Changement de cadran';
    case _21 = 'Gravure';

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
