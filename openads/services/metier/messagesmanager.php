<?php
/**
 * Ce fichier permet de déclarer la classe MessagesManager, qui effectue les
 * traitements pour la ressource 'messages'.
 *
 * @package openfoncier
 * @version SVN : $Id: messagesmanager.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base MetierManager
require_once("./metier/metiermanager.php");

// Inclusion de la classe métier dossier_message
include_once('../obj/dossier_message.class.php');

/**
 * Cette classe hérite de la classe MetierManager. Elle permet d'effectuer des
 * traitements pour la ressource 'messages'.
 */
class MessagesManager extends MetierManager {

    /**
     *
     */
    var $config_messages_in = null;

    /**
     * Cette méthode permet de récupérer le paramétrage des différents
     * messages entrants autorisés.
     *
     * @return mixed
     */
    function get_config_messages_in($mode = null, $type = null) {

        //
        if ($this->config_messages_in === null) {
            //
            require_once "../obj/interface_referentiel_erp.class.php";
            $interface_referentiel_erp = new interface_referentiel_erp();
            $config = $interface_referentiel_erp->get_config_messages_in();
            //
            $this->config_messages_in = $config;
        }

        //
        if ($mode === null) {
            return $this->config_messages_in;
        }

        //
        if ($mode === "list_types") {
            $list_types = array();
            foreach ($this->config_messages_in as $key => $value) {
                $list_types[] = $value["type"];
            }
            return $list_types;
        }

        //
        if ($mode === "content_fields") {
            foreach ($this->config_messages_in as $key => $value) {
                if ($value["type"] === $type) {
                    return $value["content_fields"];
                }
            }
        }

        //
        return null;
    }


    /**
     * Cette méthode permet de gérer le fonctionnement de base de toutes les
     * méthodes métiers de la classe MessagesManager
     * 
     * @param array $data Les données reçues en format d'un tableau associative.
     */
    public function run($data) {

        /**
         * Vérification du type de message
         */
        // Vérification de la validité du type de message
        // Si le type dans le message ne correspond pas à un type disponible
        // alors on ajoute un message d'informations et on retourne un
        // résultat d'erreur
        if (in_array($data["type"], $this->get_config_messages_in("list_types")) !== true) {
            $this->setMessage("Le type de message n'est pas correct.");
            return $this->BAD_DATA;
        }

        /**
         * Vérification du contenu du message
         */
        //
        $content_fields = $this->get_config_messages_in("content_fields", $data["type"]);
        //
        if (is_array($data["contenu"]) !== true) {
            $this->setMessage("Le contenu du message n'est pas correct.");
            return $this->BAD_DATA;
        }
        //
        foreach ($data["contenu"] as $key => $value) {
            if (in_array($key, array_keys($content_fields)) !== true) {
                $this->setMessage("Le contenu du message n'est pas correct.");
                return $this->BAD_DATA;
            }
        }
        // Vérification de la validité du contenu en fonction du paramètre
        // $contenu_val_verif et formatage du contenu
        $contenu = '';
        $valid_contenu = true;
        // On boucle sur chaque champs à vérifier
        foreach ($content_fields as $contenu_str => $possible_vals) {
            // On récupère la valeur
            $value = $data['contenu'][$contenu_str];
            // Si la valeur est vide alors on sort de la boucle
            if (empty($value)) {
                $valid_contenu = false;
                break;
            }
            // Si la valeur n'est pas dans les valeurs possible et que la valeur
            // possible n'est pas nulle alors on sort de la boucle
            if ($possible_vals
                && !in_array(strtolower($value), $possible_vals)) {
                $valid_contenu = false;
                break;
            }
            // Formatage du contenu
            $contenu .= $contenu_str.' : '.$value.'
'; // il faut que cette ligne soit comme ça pour que le \n soit ajouté à la fin
        }

        // Si un des éléments du contenu n'est pas valide alors on ajoute un
        // message d'informations et on retourne un résultat d'erreur
        if ($valid_contenu === false) {
            $this->setMessage("Le contenu du message n'est pas correct.");
            return $this->BAD_DATA;
        }

        /**
         * Dossier d'instruction
         */
        // Vérification de l'existence du dossier dans la base de données
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                "SELECT 
                    dossier 
                FROM 
                    %sdossier 
                WHERE 
                    dossier = '%s'",
                DB_PREFIXE,
                $this->f->clean_break($data['dossier_instruction'])
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Si une erreur de base de données se produit sur cette requête
        // alors on retourne un résultat d'erreur
        if ($qres['code'] !== 'OK') {
            $this->setMessage("Erreur de base de données.");
            return $this->KO;
        }

        // Vérification de l'existence du dossier dans la base de données
        $this->dossiers = array();
        foreach ($qres['result'] as $row) {
            $this->dossiers[] = $row['dossier'];
        }

        // Si le nombre de dossiers correspondants au numéro de dossier passé
        // en paramètre n'est pas 1 alors on ajoute un message d'informations
        // et on retourne un résultat d'erreur
        if (count($this->dossiers) != 1) {
            $this->setMessage(
                "Le dossier spécifié dans le message n'existe pas."
            );
            return $this->BAD_DATA;
        }

        /**
         * Date
         */
        // Vérification de la validité de la date
        // Si le format de la date transmise dans la requête n'est pas correct
        // alors on ajoute un message d'informations et on retourne un résultat
        // d'erreur
        // Important : $date_db est passé par référence et est modifié dans la
        // méthode timestampValide()
        $date_db = null;
        if (!$this->timestampValide($data['date'], $date_db, true)) {
            $this->setMessage("La date n'est pas correcte.");
            return $this->BAD_DATA;
        }

        /**
         *
         */
        // Affectation de l'identifiant du message dans la variable
        // $data['message'] pour être transmis dans la requête dans le champ
        // message de la table
        $data['dossier_message'] = 0;
        // Affectation du numéro de dossier d'instruction dans la variable
        // $data['dossier'] pour être transmis dans la requête dans le champ
        // dossier de la table
        $data['dossier'] = $data['dossier_instruction'];
        // Affectation de la valeur de la variable $data['lu'] pour être
        // transmis dans la requête dans le champ lu de la table
        $data['lu'] = false;
        // Affectation de la valeur de la variable $data['categorie'] pour être
        // transmis dans la requête dans le champ categorie de la table
        $data['categorie'] = 'entrant';

        // Affectation du numéro de la date dans la variable
        // $data['date_emission'] pour être transmis dans la requête dans le
        // champ date_emission de la table dans le format correct
        $data['date_emission'] = $date_db;
        // Affectation du contenu reformaté dans la variable $data['contenu']
        // pour être transmis dans la requête dans le champ contenu de la table
        $data['contenu'] = $contenu;
        // Affectation du destinataire par défaut à "instructeur"
        $data['destinataire'] = 'instructeur';

        /**
         *
         */
        // On instancie la message qui va être créé par la requête
        $this->metier_instance = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => "]",
        ));
        // Si aucune erreur n'a été rencontrée alors on appelle la méthode
        // ajouter pour insérer le message et on retourne le résultat de
        // la méthode ajouter
        return parent::ajouter(
            $data,
            "Insertion du message '".$data["type"]."' OK.",
            "Echec du message '".$data["type"]."'"
        );
    }


}

?>
