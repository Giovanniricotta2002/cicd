<?php
//$Id$

require_once "../obj/instruction.class.php";

class instruction_modale extends instruction {

/**
*
*/
protected $_absolute_class_name = "instruction_modale";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 115 - view_formulaire_selection_document_signe
        $this->class_actions[115] = array(
            "identifier" => "selection_document_signe",
            "view" => "view_formulaire_selection_document_signe",
            "permission_suffix" => "selection_document_signe",
        );
    }


        /**
     * VIEW - view_formulaire_selection_document_signe.
     *
     * Formulaire d'envoi d'un document signé dans une instruction'
     *  - Un message d'alerte doit indiquer du caractère irrémédiable de l'action 
     *    (écrasement du fichier existant)
     *  - L'utilisateur doit sélectionner un fichier à téléverser (champs obligatoire)
     *  - L'utilisateur peux saisir une date de retour d'avis.
     *  
     * A la validation de ce formulaire:
     *  - Une alerte de succès (verte) doit apparaitre et informer l'utilisateur du bon
     *    déroulement de la mise à jour du document de l'instruction.
     *  - le fichier visible dans l'action "Édition" doit être
     *    le document téléversé par l'utilisateur, 
     *
     * @return void
     */
    function view_formulaire_selection_document_signe() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Non affichage du fil d'ariane. /!\ la surcharge se fait
        // depuis la méthode getSubFormTitle en renseignant le numéro de l'action
        // dans la méthode puis en appellant la méthode
        $this->getSubFormTitle('');
        $dossier = $this->getVal('dossier');
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);

        //
        // Traitement des données du formulaire
        //
        $postValues = $this->f->get_submitted_post_value();

        // Paramétrage du formulaire
        // a. Tableau de champs
        $champs = array('document_signe', 'modale_date_retour_signature');
        // b. Instanciation du formulaire 
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => $this->getParameter("maj"),
            "champs" => $champs
        ));
        
        // Paramétrage du champs type 'file' pour téléverser le document signé
        $form->setLib('document_signe', __('Document signé'));
        $form->setType('document_signe', 'upload2');
        $form->setTaille('document_signe', 64);
        $form->setMax('document_signe', 30);
        $form->setVal('document_signe', '');

        
        // Paramétrage du champs type 'date' afin de sélectionner une daate de retour signature
        $form->setLib('modale_date_retour_signature', __('Date de retour signature'));
        $form->setType('modale_date_retour_signature', 'date');
        $form->setTaille('modale_date_retour_signature', 10);
        $form->setMax('modale_date_retour_signature', 10);
        $form->setVal('modale_date_retour_signature', '');
        $form->setOnchange('modale_date_retour_signature', "fdate(this)");

        // Affichage alerte bleue :
        $this->f->displayMessage('info', __("Sélectionnez un document et cliquez sur Valider pour déposer votre document d'instruction signé. Attention, le dépôt d'un document d'instruction signé entraînera la suppression du document d'instruction actuel."));
        
        if ($postValues != null && is_array($postValues) && $postValues != array()) {
            // On vérifie que le champs de fichier a bien été renseigné
            if ($postValues['document_signe'] === '') {
                $error = true;
                $message = __("Le champs 'Document signé' est obligatoire");
            } else {
                // Update du fichier généré par l'instruction

                // On enlève le 'tmp|' du nom du fichier téleversé dans le champs "document_signe"
                $docSigne = $this->f->storage->get_temporary(str_replace('tmp|', '', $postValues['document_signe']));
                $docUpdate = $this->f->storage->update($this->getVal('om_fichier_instruction'), $docSigne['file_content'], $docSigne['metadata']);
                if ($docUpdate !== $this->getVal('om_fichier_instruction')) {
                    $error = true;
                    $message = __("Une erreur est survenue, veuillez réessayer ultérieurement");
                    return;
                }
            
                $error = false;
                $message = __("Le document a bien été mis à jour.");
                

                // Update de la date de retour signature

                // Le champs "Date" n'est pas obligatoire;
                // si la date est indiquée, on modifie les valeurs du formulaire de l'instruction
                // et on ajoute un message indiquant l'ajout de date de retour signature
                if($postValues["modale_date_retour_signature"] !== '') {
                    $instData = array_combine($this->champs, $this->val);
                    $instData['date_retour_signature'] = $postValues["modale_date_retour_signature"];
                    $this->modifier($instData);

                    $message .= __("<br />La date de retour signature a bien été mise à jour.");
                }

            };
            // On affiche le message d'erreur/de succès.
            $typeMessage = $error ? 'error' : 'valid';
            $this->f->displayMessage($typeMessage, $message);
        };

        // Affichage du formulaire
        $onsubmit = sprintf(
            "
            affichersform('instruction_modale', '%1\$s', this);
            form_container_refresh('sousform');
            return false;",
            $this->getDataSubmit()
        );
    
        $this->afficher_formulaire_modale($form, $champs, $onsubmit);
    }

    

    protected function afficher_formulaire_modale(
        $form,
        $champs,
        $formOnsubmit = '',
        $valueBoutonValidation = 'Valider',
        $formAction = '',
        $formName = 'f2',
        $nameBoutonValidation = "submit-directory",
        $classBoutonValidation = "boutonFormulaire"
    ) {
        // Ouverture du formulaire
        $this->f->layout->display__form_container__begin(array(
            "action" => $formAction,
            "onsubmit" => $formOnsubmit,
            "name" => $formName,
        ));
        // Ouverture du conteneur de formulaire
        $form->entete();
        // affichage des champs
        $form->afficher($champs, 0, false, false);
        // Fermeture du conteneur de formulaire
        $form->enpied();
        // Ouverture de la zone contenant le bouton de validation
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        // Affichage du bouton valider
        $this->f->layout->display__form_input_submit(array(
            "name" => $nameBoutonValidation,
            "value" => $valueBoutonValidation,
            "class" => $classBoutonValidation,
        ));
        // Fermeture de la zone contenant le bouton de validation
        $this->f->layout->display__form_controls_container__end();
        // Fermeture du formulaire
        $this->f->layout->display__form_container__end();
    }
}