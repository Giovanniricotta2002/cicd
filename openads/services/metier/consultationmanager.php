<?php
/**
 * Ce fichier permet de déclarer la classe ConsultationManager, qui effectue les
 * traitements pour la ressource 'consultations'.
 *
 * @package openfoncier
 * @version SVN : $Id: consultationmanager.php 4843 2015-06-18 16:28:11Z nmeucci $
 */

// Inclusion de la classe de base MetierManager
require_once("./metier/metiermanager.php");

// Inclusion de la classe métier consultation
require_once("../obj/consultation.class.php"); 

/**
 * Cette classe hérite de la classe MetierManager. Elle permet d'effectuer des
 * traitements pour la ressource 'consultations'. Le traitement permet de
 * rendre un retour d'avis sur une consultation existante par un service
 * interne à la mairie directement depuis son application.
 *
 * @todo XXX Traduire et commenter toutes les méthodes
 */
class ConsultationManager extends MetierManager {

    /**
     *
     */
    var $metier_instance = null;
    var $filename_prefix = null;
    var $filename = null;

    /**
     * Cette méthode permet de modifier une consultation existante pour lui
     * ajouter les informations de retour d'avis.
     * 
     * @param mixed $data Les données JSON reçues
     * @param string $id L'identifiant de la ressource
     */
    public function consultationDecision($data, $id) {

        // Si l'identifiant envoyé n'est pas un numérique alors on ajoute un
        // message d'informations et on retourne un résultat d'erreur
        if (!is_numeric($id)) {
            $this->setMessage("L'identifiant '".$id."' fourni est incorrect.");
            return $this->BAD_DATA;
        }

        // On instancie la consultation sur laquelle porte la requête
        $this->metier_instance = $this->f->get_inst__om_dbform(array(
            "obj" => "consultation",
            "idx" => $id,
        ));
        $this->metier_instance->setValFFromVal();

        // On vérifie si l'instanciation a produit une erreur de base de données
        // alors on ajoute un message d'informations et on retourne un résultat
        // d'erreur
        if (isset($this->metier_instance->errors['db_debuginfo'])
            && !empty($this->metier_instance->errors['db_debuginfo'])) {
            $this->setMessage("Erreur lors de la récupération de la".
                              " consultation '".$id."'.");
            return $this->KO;
        }

        // Si l'identifiant de la consultation instanciée est différent de
        // l'identifiant envoyé alors on ajoute un message d'informations et
        // on retourne un résultat d'erreur
        if ($id != $this->getMetierInstanceValForPrimaryKey()) {
            $this->setMessage("Aucune consultation '".$id."'.");
            return $this->BAD_DATA;
        }

        // Si la consultation possède déjà une date de retour ou un avis ou une
        // motivation alors on ajoute un message d'informations et on retourne
        // un résultat d'erreur
        $date_retour = $this->getMetierInstanceValForField("date_retour");
        $avis = $this->getMetierInstanceValForField("avis");
        $motivation = $this->getMetierInstanceValForField("motivation");
        if (!empty($date_retour) || !empty($avis) || !empty($motivation)) {
            $this->setMessage("Un retour d'avis a déjà été rendu pour la".
                              " consultation '".$id."'.");
            return $this->BAD_DATA;
        }

        // Le format de la date de retour valide est 'JJ/MM/AAAA'
        // Si la donnée fournie n'est pas valide alors on ajoute
        // un message d'informations et on retourne un résultat d'erreur
        $date_retour = explode("/", $data['date_retour']);
        if (count($date_retour)!= 3
            || !checkdate($date_retour[1], $date_retour[0], $date_retour[2])) {
            $this->setMessage("Le format de la date de retour d'avis fournie".
                              " pour la consultation '".$id."' n'est pas".
                              " correct.");
            return $this->BAD_DATA;
        }

        // Si la date de retour de l'avis ne se situe pas entre la date d'envoi
        // de la consultation et la date limite de retour d'avis alors on ajoute
        // un message d'informations et on retourne un résultat d'erreur
        $date_retour = $data['date_retour'];
        $date_envoi = $this->getMetierInstanceValForField("date_envoi");
        $date_limite = $this->getMetierInstanceValForField("date_limite");
        if (!$this->dateInsideInterval($date_retour,
                                       $date_envoi, $date_limite)) {
            $this->setMessage("La date de retour d'avis fournie pour la".
                              " consultation '".$id."' ne se trouve pas entre".
                              " la date d'envoi et la date limite.");
            return $this->BAD_DATA;
        }

        // => DATE DE RETOUR
        $this->metier_instance->valF['date_retour'] = $data['date_retour'];

        // Si l'avis fourni ne correspond pas à la liste d'avis valides alors
        // on ajoute un message d'informations et on retourne un résultat
        // d'erreur
        $avis = $data["avis"];
        $avis_valid = array("Favorable",
                            "Favorable avec réserve", "Défavorable", );
        if (!in_array($avis, $avis_valid)) {
            $this->setMessage("L'avis du retour d'avis fourni pour la".
                              " consultation '".$id."' n'est pas correct.");
            return $this->BAD_DATA;
        }

        // Récupération de la référence vers un avis_consultation existant
        // On liste les avis possibles et on récupère l'identifiant
        // correspondant au libellé transmis en paramètre
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    avis_consultation, libelle
                FROM 
                    %savis_consultation
                WHERE 
                    (
                        avis_consultation.om_validite_debut IS NULL
                        AND (avis_consultation.om_validite_fin IS NULL
                            OR avis_consultation.om_validite_fin > CURRENT_DATE))
                    OR (
                        avis_consultation.om_validite_debut <= CURRENT_DATE
                        AND (avis_consultation.om_validite_fin IS NULL
                            OR avis_consultation.om_validite_fin > CURRENT_DATE))',
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );

        // Si une erreur de base de données se produit sur cette requête
        // alors on retourne un résultat d'erreur
        if ($qres['code'] !== 'OK') {
            $this->setMessage("Erreur lors de la récupération des avis pour la".
                              " consultation '".$id."'.");
            return $this->KO;
        }

        // Récupération de la référence vers un avis_consultation existant
        // On liste les avis possibles et on récupère l'identifiant
        // correspondant au libellé transmis en paramètre
        $avis = $data["avis"];
        $avis_id = NULL;
        foreach($qres['result'] as $row) {
            if ($avis == $row["libelle"]) {
                $avis_id = $row["avis_consultation"];
                break;
            }
        }

        // Si la décision n'existe pas dans la base de données alors on ajoute
        // un message d'informations et on retourne un résultat d'erreur
        if (is_null($avis_id)) {
            $this->setMessage("L'avis n'existe pas.");
            return $this->KO;
        }

        // => AVIS
        $this->metier_instance->valF['avis_consultation'] = $avis_id;

        // Si un nom de fichier (nom_fichier) est fourni mais pas un contenu de
        // fichier (fichier_base64) alors on ajoute un message d'informations
        // et on retourne un résultat d'erreur
        if (isset($data['nom_fichier']) && !isset($data['fichier_base64'])
            || isset($data['fichier_base64']) && !isset($data['nom_fichier'])) {
            $this->setMessage("Les informations du fichier de retour d'avis".
                              " fournies pour la consultation '".$id."' ne".
                              " sont pas correctes.");
            return $this->BAD_DATA;
        }

        // Vérification de l'existance d'un fichier
        if (isset($data['fichier_base64'])) {
            // vérification de la disponibilité du stockage des documents (GED en général)
            if (! $this->f->storage->is_service_available()) {
                $err_msg = __("Service de stockage des documents indisponible");
                $this->setMessage($err_msg);
                return $this->KO;
            }
            // Vérification du format de la chaine + décodage du fichier
            if ($file_content = base64_decode($data['fichier_base64'], true)) {
                // Si le décodage retourne un fichier fide
                if (empty($file_content)) {
                    return  _("Le fichier est vide");
                }
                // Initialisation des métadonnées
                $metadata['filename'] = $data['nom_fichier'];
                $metadata['size']= strlen($file_content);

                // Utilisation de la classe finfo issue de l'extension PECL Fileinfo
                // afin d'obtenir le mimetype
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $metadata['mimetype'] = $finfo->buffer($file_content);

                // Récupération des métadonnées spécifiques 
                $spe_metadata = $this->metier_instance->getMetadata("fichier");

                // Fusionnent les métadonnées
                $metadata = array_merge($metadata, $spe_metadata);

                // Vérification de l'existance d'un file storage
                if($this->f->storage != NULL) {
                    // Création du fichier
                    $uploaded = $this->f->storage->create($file_content, $metadata);
                    // Vérification des erreurs
                    if ($uploaded == OP_FAILURE) {
                        // Configuration du message à afficher lors d'une erreur à l'écriture
                        $this->setMessage( _("Erreur a l'ecriture du fichier :")." [".$metadata['filename']."] "._("Veuillez contacter votre administrateur."));
                        return $this->KO;
                    }
                } else {
                    // Configuration du message à afficher si le file storage n'est pas configuré
                    $this->setMessage( _("La sauvegarde de fichier n'est pas configure : Veuillez contacter votre administrateur."));
                    return $this->KO;
                }
            } else {
                // Si le format du fichier n'est pas correct
                $this->setMessage("Le contenu du fichier n'est pas valide.");
                return $this->BAD_DATA;
            }

            // Enregistrement de l'uid du fichier
            if ($uploaded != OP_FAILURE) {
                $this->metier_instance->valF['fichier'] = $uploaded;
            }
        }

        // => MOTIVATION
        if (isset($data['motivation'])) {
            $this->metier_instance->valF['motivation'] = $data['motivation'];
        }

        // => LU
        $this->metier_instance->valF['lu'] = false;

        // Supprime les champs qui n'existe pas dans consultation
        unset($this->metier_instance->valF['dossier_libelle']);
        unset($this->metier_instance->valF['live_preview']);

        // Récupération de la clé de l'action du parent
        $maj = parent::getParameter('maj');
        // On spécifie le contexte modifier
        parent::setParameter('maj', 1);
        // Exécution du traitement
        $ret = parent::modifier($this->metier_instance->valF,
            "L'avis de la consultation $id a été pris en compte",
            "Erreur pendant le traitemande de la demande pour la consultation $id");
        // Remise en place du contexte précédent
        if (!empty($maj)) {
            // Ancienne clé de l'action si elle existe
            parent::setParameter('maj', $maj);
        } else {
            // Sinon suppression du paramètre
            parent::unsetParameter('maj');
        }
        

        // XXX vérifier ce retour car filename n'est jamais rempli
        if ($ret != $this->OK) {
            // delete the file on disk
            if (isset($data['nom_fichier'])) {
                shell_exec("rm -f $this->filename");
            }
        }
        return $ret;

    }

}

?>
