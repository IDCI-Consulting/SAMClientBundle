<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiDefectComponent: string
{
    case A01 = 'Accessoire';
    case B01 = 'Bracelet';
    case B02 = 'Fermoir / Boucle';
    case C01 = 'Couronne';
    case C02 = 'Poussoir';
    case C03 = 'Correcteur';
    case C04 = 'Valve Hélium';
    case C05 = 'Lunette';
    case C06 = 'Cavalier';
    case C07 = 'Fond';
    case C08 = 'Glace';
    case C09 = 'Carrure';
    case C10 = 'Cadran / Réhaut';
    case C11 = 'Aiguilles';
    case C12 = 'Fixation mouvement / Cercle';
    case C13 = 'Piézo';
    case C14 = 'Connecteur';
    case C15 = 'Montre';
    case J01 = 'Bijou';
    case J02 = 'Fermoir';
    case M01 = 'Organe réglant et oscillateur';
    case M02 = 'Platine / ponts';
    case M03 = 'Mécanisme de remontoir et de mise à l\'heure';
    case M04 = 'Mécanisme de chronographe';
    case M05 = 'Mécanisme automatique';
    case M06 = 'Rouage finissage';
    case M07 = 'Mécanisme de calendrier';
    case M08 = 'Mécanisme additionnel / Complication';
    case M09 = 'Mécanisme d\'affichage HMS';
    case M10 = 'Source d\'énergie - Barillet / Pile / Batterie';
    case M11 = 'Affichage digital';
    case M12 = 'Module électronique';

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