<?php
/**
 * Définition des variables communes permettant de définir des éléments de la
 * clause SELECT des requêtes des listings.
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

/*Formatage de l'adresse du terrain, concatenantion de plusieurs champs pour les 
 * mettrent dans une seule colonne*/
// Cette variable va être utilisé dans le title du span de la colonne dossier.
$trim_concat_terrain = '
TRIM(
    CASE
        WHEN dossier.adresse_normalisee IS NULL
            OR TRIM(dossier.adresse_normalisee) = \'\'
        THEN
        '.DB_PREFIXE.'adresse(
            dossier.terrain_adresse_voie_numero::text,
            dossier.terrain_adresse_voie::text,
            \'\'::text,
            dossier.terrain_adresse_lieu_dit::text,
            dossier.terrain_adresse_bp::text,
            dossier.terrain_adresse_code_postal::text,
            dossier.terrain_adresse_localite::text,
            dossier.terrain_adresse_cedex::text,
            \'\'::text,
            \' \'::text
        )
        ELSE
            dossier.adresse_normalisee
    END
)';

// Colonne représentant le libellé du dossier : elle se compose du libellé du
// dossier ainsi que d'une classe pour identifier le code DATD du dossier.
// Cette classe CSS permet d'appliquer un style spécifique en fonction du type
// du dossier sur la valeur affichée dans les listings.
// Attention la requête qui utilise ce SELECT doit avoir une jointure vers la
// table *dossier_autorisation_type_detaille*.
$select__dossier_libelle__column = "dossier.dossier_libelle";

$title_span_dossier = "dossier.dossier_libelle";

if (isset($f) === false) {
    $f = $this->f;
}
if ($f->is_option_afficher_localisation_colonne_dossier() === true) {
    // numéro de dossier et localisation dans le title du span
    $title_span_dossier = "dossier.dossier_libelle, '\n', $trim_concat_terrain";
    $select__dossier_libelle__column = "CONCAT('<span title=\"', $title_span_dossier, '\">', dossier.dossier_libelle, '</span>')";
}
if ($f->is_option_afficher_couleur_dossier() === true) {
    $select__dossier_libelle__column = sprintf(
        'CONCAT(
            \'%1$s\',
            dossier.dossier_libelle,
            \'%2$s\'
        )',
        sprintf('<p class="datd-num" title="\', %1$s, \'"style="--datd-color:#\', %4$s, \'; --datd-bg:#\', %4$s, \'33"><span id="\', %2$s, \'" class="datd-color \', %3$s, \'">',
            $title_span_dossier,
            'dossier.dossier_libelle',
            'CONCAT(\'datd-\', dossier_autorisation_type_detaille.code)',
            'COALESCE(dossier_autorisation_type_detaille.couleur, \'bbbbbb\')'
        ),
        '</span></p>'
    );
}

$select__dossier_libelle__column_as = sprintf('%s as "%s"', $select__dossier_libelle__column, __("dossier_libelle"));

// On rajoute le as afin que la variable puisse être utilisée pour afficher la colonne.
$trim_concat_terrain .= 'as "'.__("localisation").'"';