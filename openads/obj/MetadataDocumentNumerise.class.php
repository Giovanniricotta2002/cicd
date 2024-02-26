<?php

require_once __DIR__.'/Metadata.class.php';

/**
 * Réprésente les métadonnées d'un document d'instruction
 */
class MetadataDocumentNumerise extends Metadata
{
    // uid
    /**
     * @var string
     */
    public $dossier;
    /**
     * @var string
     */
    public $dossier_version;
    /**
     * @var string
     */
    public $numDemandeAutor;
    /**
     * @var string
     */
    public $anneemoisDemandeAutor;
    /**
     * @var string
     */
    public $typeInstruction;
    /**
     * @var string
     */
    public $statutAutorisation;
    /**
     * @var string
     */
    public $typeAutorisation;
    /**
     * @var string
     */
    public $dateEvenementDocument;
    /**
     * @var string
     */
    public $filename;
    /**
     * @var string
     */
    public $groupeInstruction;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $consultationPublique;
    /**
     * @var string
     */
    public $consultationTiers;
    /**
     * @var string
     */
    public $concerneERP;
}
