<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealApiInvoicingCode: string
{
    case _001 = 'Garantie de vente nationale';
    case _002 = 'Garantie de vente internationale';
    case _003 = 'Garantie de réparation';
    case _004 = 'Travaux de complaisance';
    case _005 = 'Intervention facturée';
    case _006 = 'Retour non-fait';
    case _007 = 'Maintenance de stock';
    case _008 = 'Montre échangée';
    case _009 = 'Contrefaçon';
    case _010 = 'Garantie de réparations tierces';
    case _011 = 'Test d\'étanchéité - garantie 5 ans';
    case _012 = 'Gratuité commerciale';
    case _013 = 'Délai de complaisance garantie de vente';
    case _014 = 'Délai de complaisance garantie de réparation';
    case _015 = 'Intervention sans garantie sur le fonctionnement du produit';
    case _016 = 'Extension de garantie de vente nationale';
    case _017 = 'Extension de garantie de vente internationale';

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
