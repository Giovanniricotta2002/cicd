<?php
/**
 * Ce script permet d'uploader un fichier CSV pouvant mettre à jour le numéro de
 * versement aux archives de plusieurs dossier en même temps
 * 
 * @package openfoncier
 * @version SVN : $Id: versement_archives.php 4651 2015-04-26 09:15:48Z tbenita $
 */

// Fichiers requis
require_once "../obj/utils.class.php";

// Instance de la classe utils
$f = new utils(null, "versement_archives", _("export / import")." -> "._("Versement aux archives"));

// Description de la page
$description = _("Cette page permet d'importer les numeros d'archives des dossiers.");
// Affichage de la description
$f->displayDescription($description);

function afficherFormulaireSaisie($f, $value = array()) {

    // Les champs du formulaire
    $champs = array("insee", "fichier", "separateur");

    // Instance du formulaire
    $form = $f->get_inst__om_formulaire(array(
        "validation" => 0,
        "maj" => 0,
        "champs" => $champs,
    ));

    // Tableau des contraintes
    $params = array(
        "constraint" => array(
            "extension" => ".csv"
        ),
    );

    // Restriction sur le champ d'upload    
    $form->setSelect("fichier", $params);

    // Type des champs
    $form->setType("insee", "text");
    $form->setType("fichier", "upload2");
    $form->setType("separateur", "select");

    // Libellé des champs
    $form->setLib("insee", _("insee"));
    $form->setLib("fichier", _("fichier").' <span class="not-null-tag">*</span>');
    $form->setLib("separateur", _("separateur").' <span class="not-null-tag">*</span>');

    // Taille des champs
    $form->setTaille("insee", 5);
    $form->setTaille("fichier", 64);

    // Taille max des champs
    $form->setMax("insee", 5);
    $form->setMax("fichier", 30);

    // Initilisation des liste à choix
    $contenu = array(
        0 => array(";", ",", ),
        1 => array("; "._("(point-virgule)"), ", "._("(virgule)")),
    );
    $form->setSelect("separateur", $contenu);

    // Si le paramètre n'est pas vide
    if (!empty($value)) {
        // Valeurs des champs
        $form->setVal("insee", $value["insee"]);
        $form->setVal("fichier", $value["fichier"]);
        $form->setVal("separateur", $value["separateur"]);
    }

    // Ouverture du formulaire
    printf("<form method=\"POST\" action=\"versement_archives.php\" name=f2>");

    // Champs du formulaire
    $form->entete();
    $form->afficher($champs, 0, false, false);
    $form->enpied();

    // Bouton "Importer"
    printf("<div class=\"formControls\">");
        printf("<input id=\"button-versement_archives-importer\" type=\"submit\" class=\"om-button ui-button ui-widget ui-state-default ui-corner-all\" value=\"Importer\" role=\"button\" aria-disabled=\"false\">");
    printf("</div>");

    // Fermeture du formulaire
    printf("</form>");
}

/**
 * Récupère le numéro de dossier d'autorisation
 * @param  object $f              Instance de la classe utils
 * @param  string $annee          Année du dossier
 * @param  string $code           Code du type du dossier d'autorisation
 * @param  string $numero_dossier Numéro du dossier sur 5 chiffres
 * @return string                 Numéro du dossier d'autorisation
 */
function getDossierAutorisation($f, $annee, $code, $numero_dossier) {

    // Récupération du code département
    $dep = $f->getParameter("departement");
    // Récupération du code commune
    $com = $f->getParameter("commune");

    // Numéro de dossier d'autorisation
    $dossier_autorisation = $code . $dep . $com . $annee . str_pad($numero_dossier, 5, "0", STR_PAD_LEFT);

    // Retourne le dossier d'autorisation
    return $dossier_autorisation;
}

/**
 * Récupère le numéro de dossier d'instruction
 * @param  object   $f                        Instance de la classe utils
 * @param  integer  $insee                    Numéro INSEE
 * @param  string   $dossier_autorisation     Numéro du dossier d'autorisation
 * @param  string   $version                  Numéro de version
 * @return string                             Numéro du dossier d'instruction
 */
function getDossier($f, $insee, $dossier_autorisation, $version) {
    $qres = $f->get_one_result_from_db_query(
        sprintf(
            'SELECT
                dossier.dossier
            FROM
                %1$sdossier
                LEFT JOIN %1$sdossier_autorisation
                    ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
            WHERE
                dossier_autorisation.dossier_autorisation = \'%2$s\'
                AND dossier.version = %3$d
                AND dossier_autorisation.insee = \'%4$s\'',
            DB_PREFIXE,
            $f->db->escapeSimple($dossier_autorisation),
            intval($version),
            $f->db->escapeSimple($insee)
        ),
        array(
            "origin" => "app/versement_archives.php",
        )
    );
    return $qres["result"];
}

// Si le formulaire de saisie à été validé
if ($f->get_submitted_post_value() != null) {

    // Initialisation de la variable permettant de définir que le traitement
    // est en erreur
    $error = false;

    // Récupère les valeurs des champs
    $insee = ($f->get_submitted_post_value('insee') !== null) ? $f->get_submitted_post_value('insee') : "";
    $fichier_tmp = ($f->get_submitted_post_value('fichier') !== null) ? $f->get_submitted_post_value('fichier') : "";
    $separateur = ($f->get_submitted_post_value('separateur') !== null) ? $f->get_submitted_post_value('separateur') : ";";

    // Si aucun fichier n'est uploadé
    if ($fichier_tmp == "") {

        // Indique que le traitement est en erreur
        $error = true;
        $message = _("Vous n'avez pas selectionne de fichier a importer.");
    }

    // Initialisation d'un fichier temporaire destiné à l'écriture d'un fichier résultat
    $csv_res = tmpfile();

    // Si il n'y a pas d'erreur 
    if ($error === false) {

        // On enlève le préfixe du fichier temporaire
        $fichier_tmp = str_replace("tmp|", "", $fichier_tmp);
        // On récupère le chemin vers le fichier
        $fichier_path = $f->storage->storage->temporary_storage->getPath($fichier_tmp);

        // Si le fichier existe
        if (file_exists($fichier_path) 
            && $error === false) {

            // Ouverture du fichier
            $file = fopen($fichier_path, "r+");

            // Initialisation des variables compteurs
            $cpt = array(
                "total" => 0,
                "accepte" => 0,
                "rejete" => 0,
                "ignore" => 0
            );

            // Boucle sur chaque ligne du fichier
            while (($line = fgetcsv($file, 0, $separateur)) !== FALSE) {
                
                // Initialisation de la variable permettant de définir jusqu'où
                // le traitement doit aller
                $stop = false;

                // Incrémente le compteur de ligne
                $cpt["total"]++;

                // Contrôle du nombre de colonne sur la ligne
                if ($line == false
                    || (is_array($line) && count($line) != 7)) {
                    // Incrémente le compteur des lignes rejetées
                    $cpt["rejete"]++;
                    // Arrête le traitement pour cette ligne
                    $stop = true;
                    // Colonne résultat à ajouter dans la ligne
                    $line[] = _("ligne rejetee : nombre de separateur incorrect.");
                    // Ecrit dans le fichier csv
                    fputcsv($csv_res, $line, $separateur);
                }

                // Contrôle le contenu de chaque colonne de la ligne
                if ($stop === false) {

                    // Chaque colonne doit respecter un certain format
                    if (!is_string($line[0]) && strlen($line[0]) != 5
                        || !is_string($line[1]) && strlen($line[1]) != 2
                        || !is_string($line[2]) && strlen($line[2]) != 2
                        || !is_numeric($line[3]) && strlen($line[3]) > 5
                        || !is_numeric($line[4]) && strlen($line[4]) > 2
                        || !is_string($line[5]) && strlen($line[5]) > 4
                        || !is_numeric($line[6])) {

                        // Incrémente le compteur des lignes rejetées
                        $cpt["rejete"]++;
                        // Arrête le traitement pour cette ligne
                        $stop = true;
                        // Colonne résultat à ajouter dans la ligne
                        $line[] = _("ligne rejetee : contenu non conforme.");
                        // Ecrit dans le fichier csv
                        fputcsv($csv_res, $line, $separateur);
                    }
                }

                // Si un code INSEE est renseigné
                if ($stop === false 
                    && $insee != "") {

                    // Si le code INSEE de la ligne est différent de celui
                    // renseigné dans le formulaire, alors on ne traite pas 
                    // la ligne
                    if ($line[0] != $insee) {
                        // Incrémente le compteur des lignes ingorées
                        $cpt["ignore"]++;
                        // Arrête le traitement pour cette ligne
                        $stop = true;
                        // Colonne résultat à ajouter dans la ligne
                        $line[] = _("ligne ignoree : code insee different de celui indique dans le formulaire.");
                        // Ecrit dans le fichier csv
                        fputcsv($csv_res, $line, $separateur);
                    }
                }

                // Si le traitement doit continuer
                if ($stop === false) {

                    // Récupère le numéro du dossier d'autorisation
                    $dossier_autorisation = getDossierAutorisation($f, $line[1], $line[2], $line[3]);
                    // Récupère le numéro du dossier d'instruction
                    $dossier = getDossier($f, $line[0], $dossier_autorisation, $line[4]);
                    // Si le dossier n'existe pas dans la base de données
                    if ($dossier == "") {
                        // Incrémente le compteur des lignes rejetées
                        $cpt["rejete"]++;
                        // Arrête le traitement pour cette ligne
                        $stop = true;
                        // Colonne résultat à ajouter dans la ligne
                        $line[] = _("ligne rejetee : dossier inexistant dans l'application.");
                        // Ecrit dans le fichier csv
                        fputcsv($csv_res, $line, $separateur);
                    }
                }

                // Si le traitement doit continuer
                if ($stop === false) {

                    // Numéro d'archive
                    $archive = $line[5] . " " . $line[6];
                    
                    // Valeur à modifier
                    $value_dossier['numero_versement_archive'] = $archive;

                    // Met à jour le numéro de versement aux archives du dossier
                    $res = $f->db->autoExecute(
                                        DB_PREFIXE."dossier",
                                        $value_dossier, DB_AUTOQUERY_UPDATE,
                                        "dossier = '".$dossier."'");
                    // Si il y une erreur lors de la mise à jour
                    if ($f->isDatabaseError($res)) {

                        // Log
                        $f->addToLog("app/versement_archives.php: db->autoexecute(\"".DB_PREFIXE."dossier\", ".print_r($value_dossier, true).", DB_AUTOQUERY_UPDATE, \"dossier = '".$dossier."'\");", DEBUG);

                        // Indique que le traitement est en erreur
                        $error = true;
                        $message = sprintf(_("Erreur de base de donnees lors de la mis a jour du dossier %s."), $dossier);

                    } else {

                        // Log
                        $f->addToLog("app/versement_archives.php: db->autoexecute(\"".DB_PREFIXE."dossier\", ".print_r($value_dossier, true).", DB_AUTOQUERY_UPDATE, \"dossier = '".$dossier."'\");", VERBOSE_MODE);

                        // Incrémente le compteur des lignes acceptées
                        $cpt["accepte"]++;
                        // Colonne résultat à ajouter dans la ligne
                        $line[] = _("ligne acceptee : dossier mis a jour.");
                        // Ecrit dans le fichier csv
                        fputcsv($csv_res, $line, $separateur);
                    }

                }

            }

            // Fermeture des fichiers;
            fclose($file);
        }
    }

    // Si une erreur s'est produite
    if ($error === true) {

        // Tableau des valeurs
        $value = array();
        $value['insee'] = $insee;
        $value['fichier'] = $fichier_tmp;
        $value['separateur'] = $separateur;

        // Affiche le message d'erreur
        $f->displayMessage("error", $message);

        // Afiche le formulaire avec les valeurs
        afficherFormulaireSaisie($f, $value);

    // Si il n'y a aucune erreur
    } else {

        // On se positionne au début du fichier temporaire avant de récupérer son contenu
        rewind($csv_res);
        $csv_res_content = stream_get_contents($csv_res);
        // Métadonnées du fichier csv résultat
        $metadata['filename'] = "versement_archives_resultat_".date("Ymd_His").".csv";
        $metadata['size'] = strlen($csv_res_content);
        $metadata['mimetype'] = "text/csv";
        // Création du fichier sur le storage temporaire
        $csv_res_uid = $f->storage->create_temporary($csv_res_content, $metadata);

        // Message traitement csv
        $message = sprintf(_("Il y a eu %s ligne(s) lue(s), %s ligne(s) acceptee(s), %s ligne(s) rejetee(s) et %s ligne(s) ignoree(s)"), $cpt['total'], $cpt['accepte'], $cpt['rejete'], $cpt['ignore']);
        // Message pour télécharger le csv résultat
        $message .= "<br/>"._("Pour telecharger le fichier, cliquer ici :")."<a href=\"../app/index.php?module=form&snippet=file&uid=$csv_res_uid&mode=temporary\"><img src=\"../app/img/ico_trace.png\" alt=\""._("Telecharger le fichier CSV")."\" title=\""._("Telecharger le fichier CSV")."\" /></a>";

        // Affiche le message
        $f->displayMessage("valid", $message);

        // Si le mode DEBUG n'est pas "PRODUCTION_MODE"
        if(DEBUG != "PRODUCTION_MODE") {

            // Affiche le contenu du fichier de résultat
            $csv_res_tmp = $f->storage->get_temporary($csv_res_uid);
            $csv_res_content = $csv_res_tmp['file_content'];
            $csv_res_content = str_replace("\n","<br>", $csv_res_content);

            printf('<div id="content_versement_archives" >');
            printf($csv_res_content);
            printf('</div>');
        }

    }

    // Fermeture et donc destruction du fichier temporaire
    fclose($csv_res);

// Sinon affiche le formulaire de saisie de base
} else {

    // Affiche le formulaire de saisie
    afficherFormulaireSaisie($f);
}

?>
