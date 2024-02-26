<?php
//$Id$ 

$table = DB_PREFIXE."consultation
    INNER JOIN ".DB_PREFIXE."dossier 
        ON consultation.dossier=dossier.dossier
    INNER JOIN ".DB_PREFIXE."dossier_instruction_type
        ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
    INNER JOIN ".DB_PREFIXE."dossier_autorisation 
        ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille
            =dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    INNER JOIN ".DB_PREFIXE."service
        ON service.service=consultation.service
    INNER JOIN ".DB_PREFIXE."lien_service_om_utilisateur
        ON lien_service_om_utilisateur.service=service.service
    INNER JOIN ".DB_PREFIXE."om_utilisateur
        ON om_utilisateur.om_utilisateur=lien_service_om_utilisateur.om_utilisateur
    LEFT OUTER JOIN ".DB_PREFIXE."avis_consultation 
        ON consultation.avis_consultation=avis_consultation.avis_consultation 
    LEFT JOIN ".DB_PREFIXE."donnees_techniques
        ON donnees_techniques.dossier_instruction = dossier.dossier
    LEFT OUTER JOIN ".DB_PREFIXE."instructeur
        ON instructeur.instructeur=dossier.instructeur
    LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON demandeur.dossier=consultation.dossier
    ";

// Tableau des champs spécifiques aux demandes d'avis passées
$demande_avis_passee_specific_fields = array(
    'avis_consultation.libelle as "'._("avis rendu").'"',
    'to_char(consultation.date_retour, \'DD/MM/YYYY\') as "'._("date de l'avis rendu").'"',
    'consultation.motivation as "'._("motivation").'"',
    'CASE WHEN consultation.fichier IS NULL
        THEN \'Non\'
        ELSE \'Oui\'
    END as "'._("présence fichier").'"',
);

// Initialisation du tableau contenant la liste des colonnes
$champAffiche = array();

// Début du tableau contenant la liste des colonnes
$champAffiche_begin = array(
    'consultation.dossier as "'._("dossier").'"',
    'TRIM(CONCAT(demandeur.numero,\' \',demandeur.voie,\' \',demandeur.complement,
                      \' \',demandeur.lieu_dit,\' \',demandeur.code_postal,\' \',demandeur.localite,
                      \' \',demandeur.bp,\' \',demandeur.cedex,\' \',demandeur.pays)) as "'._("Adresse Petitionnaire").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("Type de dossier").'"',
    'dossier.terrain_adresse_voie_numero as "'._("Num voie chantier").'"',
    'TRIM(CONCAT(dossier.terrain_adresse_voie,\' \', dossier.terrain_adresse_lieu_dit)) as "'._("Adresse chantier").'"',
    'dossier.terrain_adresse_code_postal as "'._("Code postal chantier").'"',
    'dossier.terrain_adresse_localite as "'._("Ville chantier").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
    'replace(dossier.terrain_references_cadastrales, \';\', \' \') as "'._("References cadastrales").'"',
    'consultation.consultation as "'._("Numero d'avis").'"',
    'CONCAT(donnees_techniques.am_projet_desc,\' \',donnees_techniques.co_projet_desc) as "'._("Travaux").'"',
);

// Fin du tableau contenant la liste des colonnes
$champAffiche_end = array(
    'dossier.etat as "'._("état du dossier").'"',
    '-- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_avt_shon_tot
        ELSE donnees_techniques.su_avt_shon_tot
    END as "'._("sdp totale existante").'"',
    '\'\' as "'._("Zonages").'"',
    '\'\' as "'._("Risques").'"',
    '-- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_cstr_shon_tot
        ELSE donnees_techniques.su_cstr_shon_tot
    END as "'._("sdp totale creee").'"',
    "-- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN
            REGEXP_REPLACE(CONCAT(
                CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                    THEN ''
                    ELSE CONCAT ('Exploitation agricole - ', donnees_techniques.su2_cstr_shon1, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                    THEN ''
                    ELSE CONCAT ('Exploitation forestière - ', donnees_techniques.su2_cstr_shon2, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                    THEN ''
                    ELSE CONCAT ('Logement - ', donnees_techniques.su2_cstr_shon3, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                    THEN ''
                    ELSE CONCAT ('Hébergement - ', donnees_techniques.su2_cstr_shon4, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                    THEN ''
                    ELSE CONCAT ('Artisanat et commerce de détail - ', donnees_techniques.su2_cstr_shon5, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                    THEN ''
                    ELSE CONCAT ('Restauration - ', donnees_techniques.su2_cstr_shon6, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                    THEN ''
                    ELSE CONCAT ('Commerce de gros - ', donnees_techniques.su2_cstr_shon7, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                    THEN ''
                    ELSE CONCAT ('Activités de services où s''effectue l''accueil d''une clientèle - ', donnees_techniques.su2_cstr_shon8, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                    THEN ''
                    ELSE CONCAT ('Hébergement hôtelier et touristique - ', donnees_techniques.su2_cstr_shon9, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                    THEN ''
                    ELSE CONCAT ('Cinéma - ', donnees_techniques.su2_cstr_shon10, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon21 IS NULL
                    THEN ''
                    ELSE CONCAT ('Hôtels - ', donnees_techniques.su2_cstr_shon21, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon22 IS NULL
                    THEN ''
                    ELSE CONCAT ('Autres hébergements touristiques - ', donnees_techniques.su2_cstr_shon22, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                    THEN ''
                    ELSE CONCAT ('Locaux et bureaux accueillant du public des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon11, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                    THEN ''
                    ELSE CONCAT ('Locaux techniques et industriels des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon12, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                    THEN ''
                    ELSE CONCAT ('Établissements d''enseignement, de santé et d''action sociale - ', donnees_techniques.su2_cstr_shon13, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                    THEN ''
                    ELSE CONCAT ('Salles d''art et de spectacles - ', donnees_techniques.su2_cstr_shon14, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                    THEN ''
                    ELSE CONCAT ('Équipements sportifs - ', donnees_techniques.su2_cstr_shon15, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                    THEN ''
                    ELSE CONCAT ('Autres équipements recevant du public - ', donnees_techniques.su2_cstr_shon16, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                    THEN ''
                    ELSE CONCAT ('Industrie - ', donnees_techniques.su2_cstr_shon17, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                    THEN ''
                    ELSE CONCAT ('Entrepôt - ', donnees_techniques.su2_cstr_shon18, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                    THEN ''
                    ELSE CONCAT ('Bureau - ', donnees_techniques.su2_cstr_shon19, ' m², ')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                    THEN ''
                    ELSE CONCAT ('Centre de congrès et d''exposition - ', donnees_techniques.su2_cstr_shon20, ' m²')
                END
            ), ', $', '')
        ELSE
            REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''
                    ELSE CONCAT('Habitation - ', donnees_techniques.su_cstr_shon1, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''
                    ELSE CONCAT('Hébergement hôtelier - ', donnees_techniques.su_cstr_shon2, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''
                    ELSE CONCAT('Bureaux - ', donnees_techniques.su_cstr_shon3, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''
                    ELSE CONCAT('Commerce - ', donnees_techniques.su_cstr_shon4, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''
                    ELSE CONCAT('Artisanat - ', donnees_techniques.su_cstr_shon5, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''
                    ELSE CONCAT('Industrie - ', donnees_techniques.su_cstr_shon6, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''
                    ELSE CONCAT('Exploitation agricole ou forestière - ', donnees_techniques.su_cstr_shon7, ' m², ')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''
                    ELSE CONCAT('Entrepôt - ', donnees_techniques.su_cstr_shon8, ' m², ')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''
                    ELSE CONCAT('Service public ou d''intérêt collectif - ', donnees_techniques.su_cstr_shon9, ' m²')
                END
            ), ', $', '')
    END as \""._("sdp creee par destination")."\"",
    'donnees_techniques.am_terr_surf as "'._("surface terrain").'"',
    'donnees_techniques.co_tot_log_nb as "'._("nombre total de logements").'"',
    'donnees_techniques.co_statio_place_nb as "'._("nombre de parkings").'"',
    );

// Fusionne les différents tableaux contenant la liste des colonnes
$champAffiche = array_merge($champAffiche_begin, $champAffiche_end);
//
if ($obj === "demande_avis_passee" || $obj === "demande_avis") {
    //
    $champAffiche = array_merge($champAffiche_begin, $demande_avis_passee_specific_fields, $champAffiche_end);
}

$tri = "ORDER BY consultation.date_limite::date ASC";

?>
