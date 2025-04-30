<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiInterventionInvoicingCode: string
{
    case _000 = 'A analyser, facturé';
    case _001 = 'Decrochetage spiral, facturé';
    case _002 = 'Démagnetisation, facturé';
    case _003 = 'Echange bracelet, facturé';
    case _004 = 'Gravure, facturé';
    case _005 = 'Mise à taille, facturé';
    case _006 = 'Nettoyage ultrason, facturé';
    case _007 = 'Pose cuir, facturé';
    case _008 = 'Réglage, facturé';
    case _009 = 'Réparation immédiate, facturé';
    case _010 = 'Retouche polissage, facturé';
    case _011 = 'Service pile joint de fond, facturé';
    case _012 = 'Service pile rapide, facturé';
    case _013 = 'Test étancheité, facturé';
    case _100 = 'A analyser, gratuit';
    case _101 = 'Decrochetage spiral, gratuit';
    case _102 = 'Démagnetisation, gratuit';
    case _103 = 'Echange bracelet, gratuit';
    case _104 = 'Gravure, gratuit';
    case _105 = 'Mise à taille, gratuit';
    case _106 = 'Nettoyage ultrason, gratuit';
    case _107 = 'Pose cuir, gratuit';
    case _108 = 'Réglage, gratuit';
    case _109 = 'Réparation immédiate, gratuit';
    case _110 = 'Retouche polissage, gratuit';
    case _111 = 'Service pile joint de fond, gratuit';
    case _112 = 'Service pile rapide, gratuit';
    case _113 = 'Test étancheité, gratuit';

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
