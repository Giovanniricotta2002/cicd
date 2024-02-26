<?php
//$Id$ 
//gen openMairie le 09/08/2021 10:36

include "../gen/sql/pgsql/lien_document_n_type_d_i_t.inc.php";

$ent = _("parametrage")." -> "._("Gestion des pièces")." -> "._("Nomencature des pièces");

$tab_title = _("Nomenclature des pièces");

// FROM 
$table = DB_PREFIXE."lien_document_n_type_d_i_t
    LEFT JOIN ".DB_PREFIXE."document_numerise_type 
        ON lien_document_n_type_d_i_t.document_numerise_type=document_numerise_type.document_numerise_type 
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type 
        ON lien_document_n_type_d_i_t.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
    LEFT JOIN ".DB_PREFIXE." dossier_autorisation_type_detaille
        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille";

// SELECT 
$champAffiche = array(
    'lien_document_n_type_d_i_t.lien_document_n_type_d_i_t as "'._("id").'"',
    'document_numerise_type.libelle as "'._("type de pièces").'"',
    'CONCAT(dossier_autorisation_type_detaille.code, \' \', dossier_instruction_type.libelle) as "'._("type de dossier d'instruction").'"',
    'lien_document_n_type_d_i_t.code as "'._("code").'"'
    );