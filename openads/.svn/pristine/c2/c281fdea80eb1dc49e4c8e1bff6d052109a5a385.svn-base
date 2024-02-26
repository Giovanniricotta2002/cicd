<?php
//$Id$ 
//gen openMairie le 28/02/2022 15:38

require_once "../gen/obj/tiers_consulte.class.php";

class tiers_consulte extends tiers_consulte_gen {


    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "tiers_consulte.tiers_consulte",
            "categorie_tiers_consulte",
            "abrege",
            "libelle",
            "adresse",
            "complement",
            "cp",
            "ville",
            "liste_diffusion",
            "accepte_notification_email",
            "uid_platau_acteur",
        );
    }

    /**
     * SURCHARGE
     *
     * Paramétrage du type des champs du formulaire.
     * Surcharge pour que le champ uid_platau_acteur soit un textarea en consultation
     * et modification.
     * 
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     *
     * @return void
     */   
    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        if ($maj == 0 || $maj == 1) {
            $form->setType('uid_platau_acteur', 'textarea');
        }
    }
 
    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        $form->setLib("email", __("liste de diffusion"));
    }

    /**
     * SURCHARGE
     *
     * Configuration du formulaire (VIEW formulaire et VIEW sousformulaire).
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     *
     * @return void
     */
    function setMax(&$form, $maj) {
        parent::setMax($form, $maj);

        $form->setMax("uid_platau_acteur", 11);
    }


    // XXX WIP
    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }


    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte() {
        // Filtre les catégorie de tiers consulté qui peuvent être sélectionné selon la collectivité
        // de l'utilisateur.
        // Si l'utilisateur est un utilisateur de niveau 2 toutes les catégorie seront affichées.
        // Si l'utilisateur est un utilisateur de niveau 1 seules les catégories liée à sa collectivité
        // seront affichées
        $filtreCollectivite = '';
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $filtreCollectivite = "AND lien_categorie_tiers_consulte_om_collectivite.om_collectivite = '".
                $_SESSION["collectivite"].
                "'";
        }
        return sprintf(
            'SELECT
                DISTINCT (categorie_tiers_consulte.categorie_tiers_consulte),
                categorie_tiers_consulte.libelle
            FROM
                %1$scategorie_tiers_consulte
                LEFT JOIN %1$slien_categorie_tiers_consulte_om_collectivite
                    ON categorie_tiers_consulte.categorie_tiers_consulte=lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte
            WHERE
                (
                    categorie_tiers_consulte.om_validite_debut IS NULL
                    OR categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE
                )
                AND (
                    categorie_tiers_consulte.om_validite_fin IS NULL
                    OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE
                )
                %2$s
            ORDER BY
                categorie_tiers_consulte.libelle ASC',
            DB_PREFIXE,
            $filtreCollectivite
        );
    }
}
