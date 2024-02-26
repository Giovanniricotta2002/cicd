<?php
/**
 * Connecteur SIG de test
 * 
 * @package openads
 * @version SVN : $Id$
 */

require_once '../obj/geoads.class.php';

class geoads_test {

    /**
     * Formate les parcelles en ajoutant le code impôt.
     * 
     * @param  array $liste_parcelles Tableau des parcelles.
     * @return string Liste des parcelles formatées.
     */
    protected function formatParcellesToSend(array $liste_parcelles) {

        //
        $wParcelle = array();

        //Formatage des références cadastrales pour l'envoi
        foreach ($liste_parcelles as $value) {
                
            // On ajoute les données dans le tableau que si quartier + section + parcelle
            // a été fourni
            if ($value["quartier"] !== ""
                && $value["section"] !== ""
                && $value["parcelle"] !== ""
                && isset($value["prefixe"])) {
                    //
                    $wParcelle[] = $value["prefixe"].$value["quartier"].
                        str_pad($value["section"], 2, " ", STR_PAD_LEFT).
                        $value["parcelle"];
            }
        }
        
        $wParcelle = implode(';', $wParcelle);
        //
        return $wParcelle;
    }

    /**
     * Redirection vers le SIG dans le contexte de visualisation du dossier.
     * Si les deux arguments sont nuls, c'est l'url par défaut du sig qui doit
     * être retourné.
     *
     * @param array  $parcelles Tableau de parcelles.
     * @param string $dossier   L'identifiant du dossier.
     *
     * @return string L'url du SIG
     */
    public function redirection_web(array $parcelles = null, $dossier = null) {
        //
        return json_encode(array($parcelles, $dossier));
    }

    /**
     * Redirection vers le SIG dans le contexte de dessin d'emprise pour un
     * dossier.
     *
     * @param array  $parcelles Tableau de parcelles.
     * @param string $dossier   L'identifiant du dossier.
     *
     * @return string L'url du SIG
     */
    public function redirection_web_emprise(array $parcelles, $dossier) {
        //
        return json_encode(array($parcelles, $dossier));
    }

    /**
     * GET- Vérification d'existence de parcelles et récupération de leurs adresses.
     * 
     * openADS fournit une liste de parcelles. Le SIG renvoie une collection,
     * en mentionnant pour chaque parcelle si elle existe, et le cas échéant
     * l'adresse qui y est rattachée.
     * 
     * @param array $parcelles Tableau de références cadastrales à interroger.
     * 
     * @return array Tableau de résultats (un sous-tableau par parcelle).
     */
    public function verif_parcelle(array $parcelles) {
        $wParcelle = $this->formatParcellesToSend($parcelles);
        $wParcelle = explode(';', $wParcelle);
        $return = array();

        foreach ($wParcelle as $key => $parcelle) {
            $return[$key]['parcelle'] = $parcelle;

            if ($parcelle == "999ZZ0001" || $parcelle == "999ZZ0002" || $parcelle == '000ZZ0999') {
                $return[$key]['existe'] = false;
            } else {
                $return[$key]['existe'] = true;
                $return[$key]['nom'] = 'DE LA REPUBLIQUE';
                $return[$key]['prefixe'] = 'RUE';
                $return[$key]['dnuvoi'] = '24';
                $return[$key]['arrdt'] = '01';
            }
        }
        return $return;
    }

      /**
     * POST -Déclenche sur lme SIG le calcul de l'emprise des parcelles d'un dossier.
     * 
     * openADS fournit une liste de parcelles et le numéro de dossier correspondant.
     * Le SIG renvoie un statut, spécifiant si le calcul été effectué correctement ou non.
     * 
     * @param array  $parcelles Tableau de parcelles.
     * @param string $dossier   Numéro du dossier.
     * 
     * @return boolean true si le calcul est OK, false sinon
     */
    public function calcul_emprise(array $parcelles, $dossier) {

        if (empty($parcelles)) {
            return false;
        }

        $wParcelle = $this->formatParcellesToSend($parcelles);
        $wParcelle = explode(';', $wParcelle);
        $return = array();

        foreach ($wParcelle as $key => $parcelle) {
            if ($parcelle == "999ZZ0003" || $parcelle == "999ZZ0004" || $parcelle == "999WW0002") {
                return false;
            }
        }
        return true;
    }

     /**
     * POST - Déclenche sur le SIG le calcul du centroïde d'un dossier.
     * 
     * openADS appelle la méthode centroide sur la ressource du dossier souhaité.
     * Si le calcul du centroïde est conduit avec succès, le SIG renvoie un
     * statut positif, accompagné des coordonnées du centroïde. Dans le cas
     * contraire, le SIG renvoie un statut négatif.
     * 
     * @param string $dossier Numéro du dossier.
     * 
     * @return array Coordonnées du centroïde, null si échec
     */
    public function calcul_centroide($dossier) {
        if ($dossier == 'PC0456781800003P0' 
            || $dossier == 'PC0783451800003P0') {
            //
             return array(
            "statut_calcul_centroide" => false
            );
        }
        if (substr($dossier, 0, -3) == 'PC02636222K000') {
            return array(
                "statut_calcul_centroide" => true,
                "x" => '10123',
                "y" => '10456',
                "parcelles" => "000AB0653",
                "surface" => "700"
            );
        }
        return array(
            "statut_calcul_centroide" => true,
            "x" => '10123',
            "y" => '10456'
        );
    }

    /**
     * GET - Récupération de toutes les contraintes existantes pour une commune.
     *
     * OpenADS appelle le SIG en précisant seulement le code INSEE de la commune.
     * Il renvoie une collection de l'intégralité des contraintes existantes.
     *
     * @param  string $code_insee Code INSEE de la commune.
     *
     * @return array              Tableau de toutes les contraintes existantes
     */
    public function recup_toutes_contraintes($code_insee) {
        $ret = array();
        // Les contraintes sont retournées si le code insee est '2', sinon un tableau
        // vide est renvoyé
        switch ($code_insee) {
            case '13055':
                $ret = array(
                    array(
                        "contrainte" => "8",
                        "libelle" => "Une contrainte du PLU de Marseille",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                        "texte" => "Texte de test"
                    ),
                    array(
                        "contrainte" => "28",
                        "libelle" => "Une seconde contrainte du PLU de Marseille",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection"
                    )
                );
                break;

            case '13002':
                $ret = array(
                    array(
                        "contrainte" => "8",
                        "libelle" => "Une contrainte du PLU d'Allauch",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection"
                    ),
                    array(
                        "contrainte" => "28",
                        "libelle" => "Une seconde contrainte du PLU d'Allauch",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection"
                    )
                );
                break;
            case '45678':
                throw new geoads_connector_exception("Test PHP fatal error");
                break;
                
            default:
                $ret = array(
                    array(
                        "contrainte" => "6",
                        "libelle" => "Une contrainte du PLU pour le test de geoloc",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                        "texte" => "Une description de contrainte du PLU",
                    ),
                    array(
                        "contrainte" => "26",
                        "libelle" => "Une seconde contrainte du PLU pour le test de geoloc",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                    ),
                    array(
                        "contrainte" => "Numerodecontrainte1",
                        "libelle" => "Une contrainte alphanumerique",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                    ),
                    array(
                        "contrainte" => "",
                        "libelle" => "Contrainte sans numéro",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                    )
                );
                break;
        }

        return $ret;
    }

    /**
     * Cette méthode permet de définir le traitement lors d'une requête GET avec appel
     * sur l'URI dossiers/[id_dossier]/contraintes
     *
     * @param string $dossier Récupère le paramètre fourni dans l'URI.
     *
     * @return array JSON $ret  Retourne un tableau d'objets contraintes pour le dossier AZ0130551200002P0
     * Retourne un tableau contenant un tableau de contrainte pour le dossier AZ0130551200001P0
     *
     * @smart routing off
     * @url GET :dossier/contraintes
     */
    public function recup_contrainte_dossier($dossier) {

        // Selon le numéro de dossier les contraintes diffèrent
        switch ($dossier) {
            case 'AZ0130551200001P0':
                $ret = array(
                    array(
                        "contrainte" => "6",
                        "libelle" => "Une contrainte du PLU",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                        "texte" => "Une description de contrainte du PLU",
                    )
                );
                break;
            case 'dossier_sans_contrainte':
                $ret = array();
                break;
            default:
                $ret = array(
                    array(
                        "contrainte" => "6",
                        "libelle" => "Une contrainte du PLU pour le test de geoloc",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                        "texte" => "Une description de contrainte du PLU",
                    ),
                    array(
                        "contrainte" => "26",
                        "libelle" => "Une seconde contrainte du PLU pour le test de geoloc",
                        "groupe_contrainte" => "ZONES DU PLU",
                        "sous_groupe_contrainte" => "protection",
                    )
                );
        }
        return $ret;
    }

    protected function methodIsImplemented(string $method) {
        return true;
    }

    public function supprime_emprise(string $dossier) {
        return true;
    }

    public function replicate_geolocalisation(string $from, string $to) {
        if($from == 'PC0263622200003evol_sig01' && $to == 'PC0263622200003evol_sig02') {
            throw new geoads_connector_exception("Replication geolocalisation forced to fail");
        }
        elseif($from == 'PC0263622200003evol_sig01' && $to == 'PC0263622200003evol_sig03') {
            return false;
        }
        return true;
    }
}
