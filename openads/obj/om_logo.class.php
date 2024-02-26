<?php
/**
 * OM_LOGO - Surcharge du core
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once PATH_OPENMAIRIE."obj/om_logo.class.php";

class om_logo extends om_logo_core {

    var $metadata = array(
        "fichier" => array(
            "filename" => "getFichierFilename",
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',

            'collectivite' => 'getDossierServiceOrCollectivite'
        ),
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();


        // ACTION - 001 - modifier
        //
        $this->class_actions[1]["condition"] = array("is_user_multi_or_is_object_mono");

        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_user_multi_or_is_object_mono");

        // ACTION - 004 - copier
        //
        $this->class_actions[4] = array(
            "identifier" => "copier",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => _("copier"),
                "order" => 30,
                "class" => "copy-16",
            ),
            "view" => "formulaire",
            "method" => "copier",
            "button" => "copier",
            "permission_suffix" => "copier",
            "crud" => "create",
        );
    }


    /**
     * TREATMENT - copier.
     *
     * Permet de copier un enregistrement.
     *
     * @return boolean
     */
    function copier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // Begin
        $this->begin_treatment(__METHOD__);

        // Récuperation de la valeur de la cle primaire de l'objet
        $id = $this->getVal($this->clePrimaire);
        // Récupération des valeurs de l'objet
        $this->setValFFromVal();
        // Maj des valeur de l'objet à copier
        $this->valF[$this->clePrimaire]=null;
        $this->valF["libelle"]=sprintf(_('copie du %s'), date('d/m/Y'));
        $this->valF["actif"]=false;
        // Si en sousform l'id de la collectivité est celle du formulaire principal
        if ($this->getParameter("retourformulaire") === "om_collectivite") {
            $this->valF["om_collectivite"] = $this->getParameter("idxformulaire");
        } else {
            $this->valF["om_collectivite"] = $_SESSION['collectivite'];
        }
        // Certains champs ne sont pas présent dans la table om_lettretype
        // (jointure sur om_requete dans om_lettretype.form.inc.php)
        unset($this->valF["merge_fields"]);
        unset($this->valF["substitution_vars"]);
        
        // Copie du fichier
        $tmpFile = $this->f->storage->get($this->getVal("fichier"));
        if(isset($tmpFile)) {
            $fichier = $this->f->storage->create(
                $tmpFile["file_content"],
                $tmpFile["metadata"],
                "from_content",
                $this->table.".fichier"
            );
            if($fichier == OP_FAILURE) {
                $this->addToMessage(_("L'élément n'a pas été correctement dupliqué."));
                return $this->end_treatment(__METHOD__, false);
            }
            $this->valF['fichier'] = $fichier;
        }
        else {
            $this->addToMessage(_("L'élément n'a pas été correctement dupliqué."));
            return $this->end_treatment(__METHOD__, false);
        }


        $ret = $this->ajouter($this->valF);
        // Si le traitement ne s'est pas déroulé correctement
        if ($ret !== true) {
            // Return
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Message
        $this->addToMessage(_("L'element a ete correctement duplique."));
        // Return
        return $this->end_treatment(__METHOD__, true);
    }


    /**
     * Création du nom de fichier
     * @return string numéro de dossier d'instruction
     */
    protected function getFichierFilename() {
      // Récupération de l'uid temporaire
      $uid = explode("|", $this->valF["fichier"]);
      // Récupération de l'extension
      $userfile_extn = substr(
        $this->f->storage->getFilename_temporary($uid[1]),
        strrpos(
          $this->f->storage->getFilename_temporary($uid[1]),
          '.'
        )
      );
      return "om_logo_".$this->valF[$this->clePrimaire].$userfile_extn;
    }

    // {{{ 
    // Méthodes de récupération des métadonnées document
    /**
     * Récupération du numéro de dossier d'instruction à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getDossier($champ = null) {
        return '';
    }
    /**
     * Récupération la version du dossier d'instruction à ajouter aux métadonnées
     * @return int Version
     */
    protected function getDossierVersion() {
        return '';
    }
    /**
     * Récupération du numéro de dossier d'autorisation à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getNumDemandeAutor() {
        return '';
    }
    /**
     * Récupération de la date de demande initiale du dossier à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getAnneemoisDemandeAutor() {
        return '';
    }
    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getTypeInstruction() {
        return '';
    }
    /**
     * Récupération du statut du dossier d'autorisation à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getStatutAutorisation() {
        return '';
    }
    /**
     * Récupération du type de dossier d'autorisation à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getTypeAutorisation() {
        return '';
    }
    /**
     * Récupération de la date d'ajout de document à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getDateEvenementDocument() {
        return date("Y-m-d");
    }
    /**
     * Récupération du groupe d'instruction à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getGroupeInstruction() {
        return 'ADS';
    }
    /**
     * Récupération du libellé du type du document à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getTitle() {
        return 'Logo';
    }
    // Fin des méthodes de récupération des métadonnées
    // }}}

    protected function getDossierServiceOrCollectivite($champ = null) {
        $collectiviteId = $this->getVal('om_collectivite');
        if (! empty($collectiviteId)) {
            $collectivite = $this->f->findObjectById('om_collectivite', $collectiviteId);
            if (! empty($collectivite)) {
                return $collectivite->getVal('libelle');
            }
        }
    }
}
