<?php
/*
 * XXX
 *
 * @package openads
 * @version SVN : $Id$
 */

// XXX
$shon = "
[CASE WHEN su2_avt_shon1 IS NOT NULL
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
    THEN donnees_techniques.su2_tot_shon2
    ELSE donnees_techniques.su_tot_shon2
END as shon]";

//
$libelle_destination = "
[CASE WHEN su2_avt_shon1 IS NOT NULL
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
                ELSE 'Exploitation agricole / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                THEN ''
                ELSE 'Exploitation forestière / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                THEN ''
                ELSE 'Logement / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                THEN ''
                ELSE 'Hébergement / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                THEN ''
                ELSE 'Artisanat et commerce de détail / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                THEN ''
                ELSE 'Restauration / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                THEN ''
                ELSE 'Commerce de gros / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                THEN ''
                ELSE 'Activités de services où s''effectue l''accueil d''une clientèle / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                THEN ''
                ELSE 'Hébergement hôtelier et touristique / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                THEN ''
                ELSE 'Cinéma / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon21 IS NULL
                THEN ''
                ELSE 'Hôtels / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon22 IS NULL
                THEN ''
                ELSE 'Autres hébergements touristiques / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                THEN ''
                ELSE 'Locaux et bureaux accueillant du public des administrations publiques et assimilés / ' 
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                THEN ''
                ELSE 'Locaux techniques et industriels des administrations publiques et assimilés / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                THEN ''
                ELSE 'Établissements d''enseignement, de santé et d''action sociale / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                THEN ''
                ELSE 'Salles d''art et de spectacles / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                THEN ''
                ELSE 'Équipements sportifs / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                THEN ''
                ELSE 'Autres équipements recevant du public / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                THEN ''
                ELSE 'Industrie / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                THEN ''
                ELSE 'Entrepôt / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                THEN ''
                ELSE 'Bureau / '
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                THEN ''
                ELSE 'Centre de congrès et d''exposition'
            END
        ), ' / $', '')
    ELSE
        REGEXP_REPLACE(CONCAT(
            CASE
                WHEN donnees_techniques.su_cstr_shon1 IS NULL
                THEN ''
                ELSE 'Habitation / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon2 IS NULL
                THEN ''
                ELSE 'Hébergement hôtelier / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon3 IS NULL
                THEN ''
                ELSE 'Bureaux / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon4 IS NULL
                THEN ''
                ELSE 'Commerce / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon5 IS NULL
                THEN ''
                ELSE 'Artisanat / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon6 IS NULL
                THEN ''
                ELSE 'Industrie / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon7 IS NULL
                THEN ''
                ELSE 'Exploitation agricole ou forestière / '
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon8 IS NULL
                THEN ''
                ELSE 'Entrepôt / '
            END, 
            CASE
                WHEN donnees_techniques.su_cstr_shon9 IS NULL
                THEN ''
                ELSE 'Service public ou d''intérêt collectif'
            END
        ), ' / $', '')
END as libelle_destination]";

$destination_surfaces = "
[CASE WHEN su2_avt_shon1 IS NOT NULL
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
                ELSE CONCAT ('Exploitation agricole - ', donnees_techniques.su2_cstr_shon1, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                THEN ''
                ELSE CONCAT ('Exploitation forestière - ', donnees_techniques.su2_cstr_shon2, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                THEN ''
                ELSE CONCAT ('Logement - ', donnees_techniques.su2_cstr_shon3, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                THEN ''
                ELSE CONCAT ('Hébergement - ', donnees_techniques.su2_cstr_shon4, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                THEN ''
                ELSE CONCAT ('Artisanat et commerce de détail - ', donnees_techniques.su2_cstr_shon5, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                THEN ''
                ELSE CONCAT ('Restauration - ', donnees_techniques.su2_cstr_shon6, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                THEN ''
                ELSE CONCAT ('Commerce de gros - ', donnees_techniques.su2_cstr_shon7, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                THEN ''
                ELSE CONCAT ('Activités de services où s''effectue l''accueil d''une clientèle - ', donnees_techniques.su2_cstr_shon8, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                THEN ''
                ELSE CONCAT ('Hébergement hôtelier et touristique - ', donnees_techniques.su2_cstr_shon9, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                THEN ''
                ELSE CONCAT ('Cinéma - ', donnees_techniques.su2_cstr_shon10, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon21 IS NULL
                THEN ''
                ELSE CONCAT ('Hôtels - ', donnees_techniques.su2_cstr_shon21, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon22 IS NULL
                THEN ''
                ELSE CONCAT ('Autres hébergements touristiques - ', donnees_techniques.su2_cstr_shon22, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                THEN ''
                ELSE CONCAT ('Locaux et bureaux accueillant du public des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon11, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                THEN ''
                ELSE CONCAT ('Locaux techniques et industriels des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon12, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                THEN ''
                ELSE CONCAT ('Établissements d''enseignement, de santé et d''action sociale - ', donnees_techniques.su2_cstr_shon13, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                THEN ''
                ELSE CONCAT ('Salles d''art et de spectacles - ', donnees_techniques.su2_cstr_shon14, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                THEN ''
                ELSE CONCAT ('Équipements sportifs - ', donnees_techniques.su2_cstr_shon15, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                THEN ''
                ELSE CONCAT ('Autres équipements recevant du public - ', donnees_techniques.su2_cstr_shon16, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                THEN ''
                ELSE CONCAT ('Industrie - ', donnees_techniques.su2_cstr_shon17, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                THEN ''
                ELSE CONCAT ('Entrepôt - ', donnees_techniques.su2_cstr_shon18, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                THEN ''
                ELSE CONCAT ('Bureau - ', donnees_techniques.su2_cstr_shon19, ' m² / ')
            END,
            CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                THEN ''
                ELSE CONCAT ('Centre de congrès et d''exposition - ', donnees_techniques.su2_cstr_shon20, ' m²')
            END
        ), ' / $', '')
    ELSE
        REGEXP_REPLACE(CONCAT(
            CASE
                WHEN donnees_techniques.su_cstr_shon1 IS NULL
                THEN ''
                ELSE CONCAT('Habitation - ', donnees_techniques.su_cstr_shon1, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon2 IS NULL
                THEN ''
                ELSE CONCAT('Hébergement hôtelier - ', donnees_techniques.su_cstr_shon2, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon3 IS NULL
                THEN ''
                ELSE CONCAT('Bureaux - ', donnees_techniques.su_cstr_shon3, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon4 IS NULL
                THEN ''
                ELSE CONCAT('Commerce - ', donnees_techniques.su_cstr_shon4, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon5 IS NULL
                THEN ''
                ELSE CONCAT('Artisanat - ', donnees_techniques.su_cstr_shon5, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon6 IS NULL
                THEN ''
                ELSE CONCAT('Industrie - ', donnees_techniques.su_cstr_shon6, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon7 IS NULL
                THEN ''
                ELSE CONCAT('Exploitation agricole ou forestière - ', donnees_techniques.su_cstr_shon7, ' m² / ')
            END,
            CASE
                WHEN donnees_techniques.su_cstr_shon8 IS NULL
                THEN ''
                ELSE CONCAT('Entrepôt - ', donnees_techniques.su_cstr_shon8, ' m² / ')
            END, 
            CASE
                WHEN donnees_techniques.su_cstr_shon9 IS NULL
                THEN ''
                ELSE CONCAT('Service public ou d''intérêt collectif - ', donnees_techniques.su_cstr_shon9, ' m²')
            END
        ), ' / $', '')
END as destination_surfaces]";

?>
