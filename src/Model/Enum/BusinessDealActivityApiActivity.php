<?php

namespace IDCI\Bundle\SAMClientBundle\Model\Enum;

enum BusinessDealActivityApiActivity: string
{
    case C010 = 'Pré-enregistrement';
    case A010 = 'Organisation envoi';
    case C020 = 'Attente réception montre';
    case A020 = 'Enregistrement';
    case W010 = 'Diagnostic';
    case A025 = 'Envoi à la marque';
    case A035 = 'Informations marque';
    case A030 = 'Etablissement et envoi devis';
    case C025 = 'Attente autorisation client';
    case C030 = 'Devis en attente';
    case A040 = 'Préparation du travail';
    case W000 = 'Atelier';
    case W020 = 'Démontage boite';
    case W025 = 'Travail de bijouterie';
    case W030 = 'Polissage';
    case W035 = 'Polissage/Lavage';
    case W040 = 'Lavage';
    case W050 = 'Sortie composants';
    case W060 = 'Attente composants';
    case W070 = 'Montage boite';
    case W080 = 'Analyse spécifique';
    case W090 = 'Rhabillage du mouvement';
    case W095 = 'Révision mvt + emboitage, pose cadran aiguilles';
    case W100 = 'Emboitage, cadran & aiguille';
    case W110 = 'Test de fonctionnement & réserve de marche';
    case W120 = 'Réassemblage';
    case W130 = 'Contrôle qualité';
    case W140 = 'Retouche';
    case W200 = 'Sous-traitance externe';
    case W210 = 'Sous-traitance à la marque';
    case A050 = 'Validation du travail';
    case A060 = 'Facturation';
    case C040 = 'Attente client';
    case T010 = 'Envoi transfert';
    case T020 = 'Réception transfert';
    case T030 = 'Transféré';
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
