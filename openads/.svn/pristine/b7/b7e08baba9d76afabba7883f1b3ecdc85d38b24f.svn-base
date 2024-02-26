<?php
/**
 * Ce script permet de définir la classe 'export_sitadel'.
 *
 * @package openads
 * @version SVN : $Id: export_sitadel.class.php 5673 2015-12-21 19:35:24Z nmeucci $
 */

/**
 * Classe permettant la mise en forme de chaque ligne de l'export SITADEL
 * Les méthode retourne des morceaux de lignes en faisant correspondre les valeurs
 * du dossier avec les valeurs définie pour l'export SITADEL 
 */
class export_sitadel {
    
    private $dossier; // identifiant du dossier à insérer dans l'export
    private $row; // Valeurs du dossier
    private $val; // parametre par defaut
    private $parametre; //parametre dossier
    private $DEBUG=0; // 1 = valeur
    private $pays;

    /**
     * Instance de la classe utils
     * @var utils
     */
    var $f = NULL;
    
    /**
     * Constructeur, initialisation de l'attribut dossier
     *
     * @param dossier string identifiant du dossier à traiter
     */
    function __construct($dossier, $f) {
        $this->dossier=$dossier;
        //
        $this->f = $f;
        //
        $this->pays = array(
            'ALLE' => 109, 'AMÉR' => 404, 'AUTR' => 990, 'BELG' => 131,
            'GRAN' => 132, 'DANE' => 101, 'ESPA' => 134, 'FRAN' => 100,
            'PAYS' => 135, 'ITAL' => 127, 'PORT' => 139, 'SUIS' => 140,
        );
        // Permet lors de l'instantiation d'objets métiers d'avoir accès à f
        $GLOBALS['f'] = $this->f;
    }// fin constructeur
    
    /**
     * Mutateur pour le tableau de données du dossier
     * 
     * @param   $row    Le tableau de données du dossier
     * @return  void
     * */
    public function setRow($row){
        $this->row = $row;
    }
    
    /**
     * Mutateur pour le paramètre par défaut
     * 
     * @param   $val    Le paramètre par défaut
     * @return  void
     * */
    public function setVal($val){
        $this->val = $val;
    }
    
    /**
     * Permet de mettre en forme le début de chaque la ligne
     * 
     * @param string $mouvement   DEPOT, DECISION, SUIVI, TRANSFERT, MODIFICATIF, SUPPRESSION.
     * @param string $departement Non utilisé.
     * @param string $commune     Code commune du dossier.
     * @param string $version     Numéro de version du dossier.
     *
     * @return string entete de la ligne
     */
    function entete($mouvement, $departement, $commune, $version){

        // Si c'est une commune divisée en arrondissement, le code commune dans 
        // l'entete de chaque mouvement doit être le code impôt de l'arrondissement
        if ($this->f->getParameter("option_arrondissement")==='true'&&$this->row['code_impots']!=''){
            $commune=$this->row['code_impots'];
        }
        //Si la commune est divisée en arrondissement mais que le code impôts de l'arrondissement ne peut pas être récupéré
        elseif($this->f->getParameter("option_arrondissement")==='true'&&$this->row['code_impots']==''){
            $commune=0;
        }

        // sitadel : mouv|typpermis|equivalence|dep|commune|andepnumpc|indmod
        // l'equivalence n'est pas utilisée
        $indice_dossier = '';
        if ($version !== 0
            && $this->row['mouvement_sitadel'] !== 'SUIVI'
            && strpos($this->dossier, "ANNUL") === false) {
            // Le numéro de version doit être sur deux caractères
            $indice_dossier = str_pad(strval($version), 2, "0", STR_PAD_LEFT);
        }

        $entete=$mouvement."|".$this->row['code']."||".$departement."|".$commune."|".substr($this->dossier,8,2).
                "|".substr($this->dossier,10,5)."|".$indice_dossier."|";  
        return $entete;
    }


    /**
     * Permet de mettre en forme l'état civil :
     * personne morale / physique
     * société, siret, civilité, nom, prénom / civilité, nom, prénom
     *
     * @return string demandeur désigné
     */
    function etatcivil(){
        // etat civil demandeur
        // codemo|
        if ($this->row['qualite'] == "particulier") {
           $codemo=1;// personne physique
        } else {
           $codemo=2;// personne morale
        }    
        $etatcivil=$codemo."|"; // 1 personne physique ; 2 sinon
        // openfoncier civilite (5/8 ok), nom (80/30-> substr), societe (80/50->substr) 
        // civpart|prenompart|nompart|denopm|rspm|siret|catjur|civrep|prenomrep|nomrep| 
        // suivant codemo = 1 (personne physique) ou 2 (personne morale)
        // demandeur_civilite n est pas normalise Madame ou Monsieur 
        if ($codemo == 1) {
           // *civpart*|*prenompart*|nompart||||||
            $etatcivil.= $this->maj(substr($this->row['civilite_pp'],0,8))."|"; 
            $etatcivil.= $this->maj(substr($this->row['pp_particulier_prenom'],0,30))."|"; 

            $etatcivil.= $this->maj(substr($this->row['pp_particulier_nom'],0,30))."||||||||"; 
        } else {
           //denopm|*rspm*|*siret*|*catjur*|*civrep*|*prenomrep*|nomrep|         
           $etatcivil.="|||"; // codemo=1
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_denomination'],0,50))."|"; 
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_raison_sociale'],0,30))."|";
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_siret'],0,14))."|";
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_categorie_juridique'],0,4))."|";
           $etatcivil.=$this->maj(substr($this->row['civilite_pm_libelle'],0,8))."|";
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_prenom'],0,30))."|";
           $etatcivil.=$this->maj(substr($this->row['pp_personne_morale_nom'],0,30))."|";
        }
        return $etatcivil;
    }
    
    function adresse(){
        // openfoncier : adresse (80/ 26+38 -> substr sur 2 zones) - cp (5/5 OK) - ville (30/36 -> OK)
        // *numvoiemo*|*typvoiemo*|libvoiemo|lieuditmo(+)|communemo|codposmo|*bpmo*|*cedexmo*|*paysmo*|*divetermo|
        $adresse="";
        $adresse.= $this->maj(substr($this->row['pp_numero'],0,5))."|";
        $adresse.= $this->maj(substr("",0,5))."|";
        $adresse.= $this->maj(substr($this->row['pp_voie'],0,26))."|";
        $adresse.= $this->maj(substr($this->row['pp_lieu_dit'],0,38))."|";
        $adresse.= $this->maj(substr($this->row['pp_localite'],0,32))."|";
        $adresse.= $this->maj(substr($this->row['pp_code_postal'],0,5))."|";
        $adresse.= $this->maj(substr($this->row['pp_bp'],0,5))."|";
        $adresse.= $this->maj(substr($this->row['pp_cedex'],0,5))."|";
        $adresse.= $this->maj($this->getCodeInseePays(strtoupper($this->row['pp_pays'])))."|";
        $adresse.= $this->maj(substr($this->row['pp_division_territoriale'],0,38))."|";

        return $adresse;
    }
    
    
    function delegataire(){
        
        //On récupère le délégataire
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    civilite.libelle AS civilite_delegataire_libelle,
                    demandeur.particulier_nom AS delegataire_particulier_nom,
                    demandeur.particulier_prenom AS delegataire_particulier_prenom,
                    demandeur.numero AS delegataire_numero,
                    demandeur.voie AS delegataire_voie,
                    demandeur.complement AS delegataire_complement,
                    demandeur.lieu_dit AS delegataire_lieu_dit,
                    demandeur.localite AS delegataire_localite,
                    demandeur.code_postal AS delegataire_code_postal,
                    demandeur.bp AS delegataire_bp,
                    demandeur.cedex AS delegataire_cedex,
                    demandeur.pays AS delegataire_pays,
                    demandeur.division_territoriale AS delegataire_division_territoriale
                FROM 
                    %1$sdemandeur
                    LEFT JOIN %1$slien_dossier_demandeur
                        ON demandeur.demandeur = lien_dossier_demandeur.demandeur 
                            AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
                    LEFT JOIN %1$scivilite
                        ON civilite.civilite = demandeur.particulier_civilite
                WHERE 
                    demandeur.type_demandeur = \'delegataire\'
                    AND lien_dossier_demandeur.dossier = \'%2$s\' ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->dossier)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        if ($qres['row_count'] == 0) {
            $row['civilite_delegataire_libelle'] = '';
            $row['delegataire_particulier_prenom'] = '';
            $row['delegataire_particulier_nom'] = '';
            $row['delegataire_numero'] = '';
            $row['delegataire_voie'] = '';
            $row['delegataire_lieu_dit'] = '';
            $row['delegataire_localite'] = '';
            $row['delegataire_code_postal'] = '';
            $row['delegataire_bp'] = '';
            $row['delegataire_cedex'] = '';
            $row['delegataire_pays'] = '';
            $row['delegataire_division_territoriale'] = '';
        } else {
            $row = array_shift($qres['result']);
        }
        // openFoncier civilite (non normalise monsieur/madame),  nom (80/30 substr)
        // openfoncier : adresse (80/ 26+38 -> substr sur 2 zones) - cp (5/5 OK) - ville (30/32 -> OK)
        // *civtiers*|*prenomtier*|nomtier|*numvoietiers*|*typvoietiers*|
        // libvoietiers|lieudittier|communetier|codpostier
        // |*bptier*|*cedextier*|*paystier*|*divtertier*|
        $delegataire="";
        $delegataire.= $this->maj(substr($row['civilite_delegataire_libelle'],0,8))."|";
        $delegataire.= $this->maj(substr($row['delegataire_particulier_prenom'],0,30))."|";
        $delegataire.= $this->maj(substr($row['delegataire_particulier_nom'],0,30))."|";
        $delegataire.= $this->maj(substr($row['delegataire_numero'],0,5))."|";
        $delegataire.= $this->maj(substr("",0,5))."|";
        $delegataire.= $this->maj(substr($row['delegataire_voie'],0,26))."|";
        $delegataire.= $this->maj(substr($row['delegataire_lieu_dit'],0,38))."|";
        $delegataire.= $this->maj(substr($row['delegataire_localite'],0,32))."|";
        $delegataire.= $this->maj(substr($row['delegataire_code_postal'],0,5))."|";
        $delegataire.= $this->maj(substr($row['delegataire_bp'],0,5))."|";
        $delegataire.= $this->maj(substr($row['delegataire_cedex'],0,5))."|";
        $delegataire.= $this->maj($this->getCodeInseePays(strtoupper($row['delegataire_pays'])))."|";
        $delegataire.= $this->maj(substr($row['delegataire_division_territoriale'],0,38))."|";
        return $delegataire;
    }
    
    function meltel($mouvement){
        // openfoncier telephone_fixe (14/20), courriel(40, 50) pas de suivi
        // sitadel : telmo|melmo|suivi
        $meltel="";
        if($mouvement != "TRANSFERT")
            $meltel.=$this->maj($this->row['pp_telephone_fixe'])."|";
        $meltel.= $this->maj($this->row['pp_courriel'])."|";
        // suivi electronique
        // Il n'y a pas de notification par mail gérée dans l'appli
        $meltel.= "0";

        // suivi -> fin enr pour transfert (sans |)
        if($mouvement != "TRANSFERT")
            $meltel.= "|";
        return $meltel;
    }   
    
    /**
     * Permet de mettre en forme l'adresse du terrain
     * @return string champs du terrain séparés par des |
     */
    function adresse_terrain(){
        // openfoncier numero (4/5 substr), adresse(80, 26 +38 -> substr), complement (non utilise (80)), cp (5/5 ok), ville (30/32 ok) 
        // sitadel : |numvoiete|*typvoiete*|libvoiete|lieudite|communete|codposte|*bpte*|*cedexte*|
        // mettre le | en debut pour info du 2eme groupe (suite 1er groupe)   
        $adresse="";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_voie_numero'],0,5))."|";
        $adresse.= $this->maj(substr("",0,5))."|";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_voie'],0,26))."|";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_lieu_dit'],0,38))."|";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_localite'],0,32))."|";
        $code_postal = substr($this->row['dossier_terrain_adresse_code_postal'],0,5);
        $adresse.= $this->maj($code_postal)."|";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_bp'],0,5))."|";
        $adresse.= $this->maj(substr($this->row['dossier_terrain_adresse_cedex'],0,5))."|";

        return $adresse;
    }
    
    /**
     * Formalise la parcelle à partir de la référence cadastrale
     * 
     * @return string la chaine formatée 
     */
    function parcelle(){
        // ========
        // parcelle
        // ========
        // cadastre 3 parcelles + 3 sections
        // openfoncier = 1 seule parcelle (6/3+5)
        // sitadel : scadastre1|ncadastre1|*scadastre2*|*ncadastre2*|*scadastre3*|*ncadastre3*|
        $parcelle = "";
        if ($this->row['dossier_terrain_references_cadastrales'] != "" ) {
            $tab_parcelles = $this->f->parseParcelles($this->row['dossier_terrain_references_cadastrales'], false, $this->row['dossier']);
            $parcelle .= ( isset($tab_parcelles[0]) && count($tab_parcelles[0]) == 3 )
                ? $this->maj(substr($tab_parcelles[0]['section'],0,3))."|".
                  $this->maj(substr($tab_parcelles[0]['parcelle'],0,5))."|" 
                : "||";
            $parcelle .= ( isset($tab_parcelles[1]) && count($tab_parcelles[1]) == 3 )
                ? $this->maj(substr($tab_parcelles[1]['section'],0,3))."|".
                  $this->maj(substr($tab_parcelles[1]['parcelle'],0,5))."|" 
                : "||";
            $parcelle .= ( isset($tab_parcelles[2]) && count($tab_parcelles[2]) == 3 )
                ? $this->maj(substr($tab_parcelles[2]['section'],0,3))."|".
                  $this->maj(substr($tab_parcelles[2]['parcelle'],0,5))."|" 
                : "||";
        } else {
            $parcelle= "||||||";
        }
        
        return $parcelle;
    }

    /**
     * Données pour le groupe 1 du mouvement décision
     *  
     * @return  string  la chaine de données du groupe 1
     */
    function decision_groupe1(){
        // openfoncier autorite_competente (integer/1), sitadel(integer, 1)
        //             date_limite (date, 8)| date_notification_delai (date, 8),
        //             sitadel_motif (integer, 1)
        // sitadel : collectivite|natdec|datredec|motifann
        
        $decision = $this->maj(substr($this->row['autorite_competente_sitadel'],0,1))."|";
        $decision.= (($this->row['sitadel']!="")?$this->maj(substr($this->row['sitadel'],0,1)):"0")."|";
        
        $datredec = "";
        //Choix de la date
        // Date limite de retour des pièces manquantes en cas de rejet tacite
        if ( $this->row['sitadel'] == 1 ){
            $datredec = ($this->row['date_limite_incompletude']!="")?$this->row['date_limite_incompletude']:$this->row['date_decision'];
        } elseif( $this->row['sitadel'] == 2 || $this->row['sitadel'] == 3 ) {
            $datredec = $this->row['date_limite'];
        } elseif ( $this->row['sitadel'] == "" ){
            $datredec = "";
        } else {
            $datredec = $this->row['date_decision'];
        }
        
        // date au format francais 8 caracteres
        $decision.= $this->maj(substr($datredec,8,2).''.
                        substr($datredec,5,2)."".
                        substr($datredec,0,4))."|";
                    
        $decision.= $this->maj(substr($this->row['sitadel_motif'],0,1))."|";
        return $decision;
    }
    
    /**
     * Données pour le groupe 2 du mouvement décision concernant les aménagements et 
     * le terrain
     *  
     * @return  string  la chaine de données du groupe 2
     */
    function amenagement_terrain(){
        // openfoncier am_terr_surf (numeric/7) am_lotiss (bool/1) terr_juri_afu (20/1) 
        //             co_cstr_nouv (20/1) co_cstr_exist (text/1000) co_modif_aspect (bool/1) 
        //             co_modif_struct (bool/1) co_cloture (bool/1) co_trx_exten (bool/1) 
        //             co_trx_surelev (bool/1) co_trx_nivsup (bool/1) co_trx_amgt (bool/1) 
        //             co_anx_pisc (bool/1) co_anx_gara (bool/1) co_anx_veran (bool/1) 
        //             co_anx_abri (bool/1) co_anx_autr (bool/1) co_bat_niv_nb (integer/3)
        // sitadel :   terrain|lotissement|ZAC|AFU|libnattrav|natproj|natdp|nattrav|
        //             annexe|niax 
        $amenagement_terrain="";
        //Terrain
        $amenagement_terrain .= ((isset($this->row['dossier_terrain_superficie'])) ? $this->maj(substr(floor(floatval($this->row['dossier_terrain_superficie'])),0,7)) : 0)."|";
        //Lotissement
        $amenagement_terrain .= ((isset($this->row['am_lotiss']) && $this->row['am_lotiss'] == 't') ? 1 : 0)."|";
        //ZAC
        $amenagement_terrain .= ((isset($this->row['terr_juri_zac']) && $this->maj($this->row['terr_juri_zac']) != '') ? 1 : 0)."|";
        //AFU
        $amenagement_terrain .= ((isset($this->row['terr_juri_afu']) && $this->maj($this->row['terr_juri_afu']) != '') ? 1 : 0)."|";
        //Libnattrav
        if (isset($this->row['co_projet_desc'])&&$this->row['co_projet_desc']!=''){
            $amenagement_terrain .= $this->maj(substr($this->row['co_projet_desc'],0,1000));
        } elseif(isset($this->row['am_projet_desc'])&&$this->row['am_projet_desc']!=''){
            $amenagement_terrain .= $this->maj(substr($this->row['am_projet_desc'],0,1000));
        } elseif(isset($this->row['dm_projet_desc'])&&$this->row['dm_projet_desc']!=''){
            $amenagement_terrain .= $this->maj(substr($this->row['dm_projet_desc'],0,1000));
        } 
        $amenagement_terrain .= "|";
        
        // Nouvelle construction et travaux sur construction (natproj)
        if ( isset($this->row['co_cstr_nouv']) && isset($this->row['co_cstr_exist']) &&
            $this->row['co_cstr_nouv'] == 't' && 
            $this->row['co_cstr_exist'] == 't' ){
            $amenagement_terrain .= "3";
        }
        //Nouvelle construction
        elseif ( isset($this->row['co_cstr_nouv']) && $this->row['co_cstr_nouv'] == 't' ) {
            $amenagement_terrain .= "1";
        }
        //Travaux sur construction existante
        elseif(($this->row['co_cstr_nouv'] == 'f' && $this->row['co_cstr_exist'] == 'f') OR 
                $this->row['co_cstr_exist']=='t') {
            $amenagement_terrain .= "2";
        }
        $amenagement_terrain .= "|";
        
        //Nature du projet dans le cas d'un DP (natdp)
        if ( $this->row['code'] == "DP" ){
            
            $amenagement_terrain .= ((isset($this->row['co_cstr_nouv']) && $this->row['co_cstr_nouv'] == 't') ? 1 : 0);
            $amenagement_terrain .= ((isset($this->row['co_cstr_exist']) && $this->row['co_cstr_exist'] == 't') ? 1 : 0);
            $amenagement_terrain .= ((isset($this->row['co_modif_aspect']) && $this->row['co_modif_aspect'] == 't') ? 1 : 0);
            $amenagement_terrain .= ((isset($this->row['co_modif_struct']) && $this->row['co_modif_struct'] == 't') ? 1 : 0);
            $amenagement_terrain .= ((isset($this->row['co_cloture']) && $this->row['co_cloture'] == 't') ? 1 : 0);
        }
        $amenagement_terrain .= "|";
        
        //Nature des travaux sur construction existante
        //nattrav
        $amenagement_terrain .= ((isset($this->row['co_trx_exten']) && $this->row['co_trx_exten'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_trx_surelev']) && $this->row['co_trx_surelev'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_trx_niv_sup']) && $this->row['co_trx_niv_sup'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_trx_amgt']) && $this->row['co_trx_amgt'] == 't') ? 1 : 0)."|";
        
        //Annexe
        $amenagement_terrain .= ((isset($this->row['co_anx_pisc']) && $this->row['co_anx_pisc'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_anx_gara']) && $this->row['co_anx_gara'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_anxveran']) && $this->row['co_anxveran'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_anx_abri']) && $this->row['co_anx_abri'] == 't') ? 1 : 0);
        $amenagement_terrain .= ((isset($this->row['co_anx_autr']) && $this->row['co_anx_autr'] == 't') ? 1 : 0)."|";

        //niax
        $amenagement_terrain .= ((isset($this->row['co_bat_niv_nb']) && $this->maj($this->row['co_bat_niv_nb'])<=1)?"1":$this->row['co_bat_niv_nb'])."|";

        return $amenagement_terrain;
    }


    /**
     * Récupère les valeurs des shon après traitement.
     *
     * @param string  $nom   Nom de la colonne (avt, cstr, sup, ...).
     * @param integer $ligne Pour récupérer seulement le résultat d'une ligne
     *                       (1 à 9).
     *
     * @return array Liste des sommes de chaque ligne.
     */
    public function get_shon_val($nom, $ligne = 0) {

        // Somme de chaque résultat (9 lignes)
        $result = array();
        $result[1] = 0;
        $result[2] = 0;
        $result[3] = 0;
        $result[4] = 0;
        $result[5] = 0;
        $result[6] = 0;
        $result[7] = 0;
        $result[8] = 0;
        $result[9] = 0;

        // Si le tableau des surfaces est celui de la version 1
        if ($this->get_tab_su_version() === 1) {
            //
            $result[1] = ((isset($this->row['su_'.$nom.'_shon'.'1'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'1'])),0,7)) : 0);
            $result[2] = ((isset($this->row['su_'.$nom.'_shon'.'2'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'2'])),0,7)) : 0);
            $result[3] = ((isset($this->row['su_'.$nom.'_shon'.'3'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'3'])),0,7)) : 0);
            $result[4] = ((isset($this->row['su_'.$nom.'_shon'.'4'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'4'])),0,7)) : 0);
            $result[5] = ((isset($this->row['su_'.$nom.'_shon'.'5'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'5'])),0,7)) : 0);
            $result[6] = ((isset($this->row['su_'.$nom.'_shon'.'6'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'6'])),0,7)) : 0);
            $result[7] = ((isset($this->row['su_'.$nom.'_shon'.'7'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'7'])),0,7)) : 0);
            $result[8] = ((isset($this->row['su_'.$nom.'_shon'.'8'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'8'])),0,7)) : 0);
            $result[9] = ((isset($this->row['su_'.$nom.'_shon'.'9'])) ? $this->maj(substr(floor(floatval($this->row['su_'.$nom.'_shon'.'9'])),0,7)) : 0);
        }

        // Si le tableau des surfaces est celui de la version 2, une
        // correspondance est faite entre les lignes de ce tableau vers celui
        // de la version 1
        if ($this->get_tab_su_version() === 2) {
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'3'])) {
                //
                $result[1] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'3'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'4'])) {
                //
                $result[1] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'4'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'9'])) {
                //
                $result[2] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'9'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'21'])) {
                //
                $result[2] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'21'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'22'])) {
                //
                $result[2] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'22'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'19'])) {
                //
                $result[3] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'19'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'5'])) {
                //
                $result[4] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'5'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'6'])) {
                //
                $result[4] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'6'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'7'])) {
                //
                $result[4] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'7'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'8'])) {
                //
                $result[4] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'8'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'17'])) {
                //
                $result[6] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'17'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'1'])) {
                //
                $result[7] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'1'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'2'])) {
                //
                $result[7] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'2'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'18'])) {
                //
                $result[8] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'18'])),0,7));
            }

            //
            if (isset($this->row['su2_'.$nom.'_shon'.'10'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'10'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'11'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'11'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'12'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'12'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'13'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'13'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'14'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'14'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'15'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'15'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'16'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'16'])),0,7));
            }
            //
            if (isset($this->row['su2_'.$nom.'_shon'.'20'])) {
                //
                $result[9] += $this->maj(substr(floor(floatval($this->row['su2_'.$nom.'_shon'.'20'])),0,7));
            }
        }

        // Si aucune ligne n'est précisée
        if ($ligne == 0) {
            // Retourne le tableau de tous les résultats
            return $result;
        }

        // Retourne un seul résultat
        return $result[$ligne];
    }


    /**
     * Données pour le groupe 2 du mouvement décision concernant les SHON
     *
     * @param string $nom Nom de la colonne (avt, cstr, sup, ...).
     *
     * @return string la chaine de données du groupe 2
     */
    public function shon($nom) {

        // Récupère la valeur de la ligne du tableau passé en paramètre
        $result = $this->get_shon_val($nom);

        // Concaténation des shon dans la chaîne à retourner
        $shon = $result[1] . "|" . $result[2] . "|" . $result[3] . "|" . $result[4] . "|" . $result[5] . "|" . $result[6] . "|" . $result[7] . "|" . $result[8] . "|" . $result[9] . "|";

        //
        return $shon;
    }


    /**
     * Retourne le numéro de version du tableau des surfaces utilisé.
     *
     * @return integer
     */
    public function get_tab_su_version() {

        // Par défaut on utilise la première version du tableau des surfaces (
        // celui avec 9 destinations)
        $result = 1;

        // Si un des champs du tableau version 2 est renseigné alors on utilise
        // celui avec les 21 sous-destinations
        for ($i = 1; $i < 21; $i++) { 
            //
            if (($this->row["su2_avt_shon".$i] !== '' && $this->row["su2_avt_shon".$i] !== null && $this->row["su2_avt_shon".$i] !== '0')
                || ($this->row["su2_cstr_shon".$i] !== '' && $this->row["su2_cstr_shon".$i] !== null && $this->row["su2_cstr_shon".$i] !== '0')
                || ($this->row["su2_chge_shon".$i] !== '' && $this->row["su2_chge_shon".$i] !== null && $this->row["su2_chge_shon".$i] !== '0')
                || ($this->row["su2_demo_shon".$i] !== '' && $this->row["su2_demo_shon".$i] !== null && $this->row["su2_demo_shon".$i] !== '0')
                || ($this->row["su2_sup_shon".$i] !== '' && $this->row["su2_sup_shon".$i] !== null && $this->row["su2_sup_shon".$i] !== '0')
                || ($this->row["su2_tot_shon".$i] !== '' && $this->row["su2_tot_shon".$i] !== null) && $this->row["su2_tot_shon".$i] !== '0') {
                //
                $result = 2;
            }
        }

        // Version du tableau
        return $result;
    }


    /**
     * Permet de mettre en forme le descriptif des modifications apportés sur le
     * terrain dans les dossier d'instruction de type modificatif
     * 
     * @return string chaîne mise en forme
     */
    function modificatif_terrain() {
        $modificatif_terrain="";

        // Terrain
        $modificatif_terrain .= ((isset($this->row['dossier_terrain_superficie'])) ? $this->maj(substr(floor(floatval($this->row['dossier_terrain_superficie'])),0,7)) : 0)."|";
        // Description des modifications
        $modificatif_terrain .= (isset($this->row['co_projet_desc'])) ? $this->maj(substr($this->row['co_projet_desc'],0,1000))."|" : "|";
        //Nature des travaux sur construction existante
        //nattrav
        $modificatif_terrain .= ((isset($this->row['co_trx_exten']) && $this->row['co_trx_exten'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_trx_surelev']) && $this->row['co_trx_surelev'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_trx_niv_sup']) && $this->row['co_trx_niv_sup'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_trx_amgt']) && $this->row['co_trx_amgt'] == 't') ? 1 : 0)."|";
                
        //Annexe
        $modificatif_terrain .= ((isset($this->row['co_anx_pisc']) && $this->row['co_anx_pisc'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_anx_gara']) && $this->row['co_anx_gara'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_anxveran']) && $this->row['co_anxveran'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_anx_abri']) && $this->row['co_anx_abri'] == 't') ? 1 : 0);
        $modificatif_terrain .= ((isset($this->row['co_anx_autr']) && $this->row['co_anx_autr'] == 't') ? 1 : 0)."|";
        
        //niax
        $modificatif_terrain .= (isset($this->row['co_bat_niv_nb']) && $this->maj(substr($this->row['co_bat_niv_nb'],0,3)))."|";

        return $modificatif_terrain;
    }

    /**
     * Données pour le groupe 2 du mouvement décision concernant les destinations
     *  
     * @return  string  la chaine de données du groupe 2
     */
    function destination($mouvement){
        
        $destination = "";
        
        $destination .= ((isset($this->row['co_sp_transport']) && $this->row['co_sp_transport'] == 't') ? 1 : 0);
        $destination .= ((isset($this->row['co_sp_enseign']) && $this->row['co_sp_enseign'] == 't') ? 1 : 0);
        $destination .= ((isset($this->row['co_sp_sante']) && $this->row['co_sp_sante'] == 't') ? 1 : 0);
        $destination .= ((isset($this->row['co_sp_act_soc']) && $this->row['co_sp_act_soc'] == 't') ? 1 : 0);
        $destination .= ((isset($this->row['co_sp_ouvr_spe']) && $this->row['co_sp_ouvr_spe'] == 't') ? 1 : 0);
        $destination .= ((isset($this->row['co_sp_culture']) && $this->row['co_sp_culture'] == 't') ? 1 : 0)."|";
        
        if($mouvement != "MODIFICATIF"){
            $destination .= ((isset($this->row['dm_tot_log_nb']) && !empty($this->row['dm_tot_log_nb'])) ? $this->row['dm_tot_log_nb'] : 0)."|";
        }
        
        $destination .= ((isset($this->row['co_tot_ind_nb']) && !empty($this->row['co_tot_ind_nb'])) ? $this->row['co_tot_ind_nb'] : 0)."|";
        $destination .= ((isset($this->row['co_tot_coll_nb']) && !empty($this->row['co_tot_coll_nb'])) ? $this->row['co_tot_coll_nb'] : 0)."|";
        $destination .= ((isset($this->row['co_tot_log_nb']) && !empty($this->row['co_tot_log_nb'])) ? $this->row['co_tot_log_nb'] : 0)."|";
        
        $destination .= ((isset($this->row['co_resid_agees']) && $this->row['co_resid_agees']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_etud']) && $this->row['co_resid_etud']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_tourism']) && $this->row['co_resid_tourism']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_hot_soc']) && $this->row['co_resid_hot_soc']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_soc']) && $this->row['co_resid_soc']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_hand']) && $this->row['co_resid_hand']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_resid_autr']) && $this->row['co_resid_autr']=='t') ? 1 : 0)."|";
        $destination .= (isset($this->row['co_resid_autr_desc']) ? $this->maj($this->row['co_resid_autr_desc']) : "")."|";
        
        $destination .= ((isset($this->row['co_uti_pers']) && $this->row['co_uti_pers']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_uti_princ']) && $this->row['co_uti_princ']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_uti_secon']) && $this->row['co_uti_secon']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_uti_vente']) && $this->row['co_uti_vente']=='t') ? 1 : 0);
        $destination .= ((isset($this->row['co_uti_loc']) && $this->row['co_uti_loc']=='t') ? 1 : 0)."|";
        
        $destination .= ((isset($this->row['co_foyer_chamb_nb']) && !empty($this->row['co_foyer_chamb_nb'])) ? $this->row['co_foyer_chamb_nb'] : 0)."|";
        
        return $destination;
    }

    /**
     * Données pour le groupe 2 du mouvement décision concernant la répartition des 
     * logements créées par type de financement
     *  
     * @return  string  la chaine de données du groupe 2
     */
    function repartitionFinan(){
        
        $repartitionFinan = "";
        
        $repartitionFinan .= ((isset($this->row['co_fin_lls_nb']) && $this->row['co_fin_lls_nb']) ? $this->row['co_fin_lls_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_fin_aa_nb']) && $this->row['co_fin_aa_nb']) ? $this->row['co_fin_aa_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_fin_ptz_nb']) && $this->row['co_fin_ptz_nb']) ? $this->row['co_fin_ptz_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_fin_autr_nb']) && $this->row['co_fin_autr_nb']) ? $this->row['co_fin_autr_nb'] : 0)."|";

        return $repartitionFinan;
    }

    /**
     * Données pour le groupe 2 du mouvement décision concernant la répartition des 
     * logements créées par nombre de pièces
     *  
     * @return  string  la chaine de données du groupe 2
     */
    function repartitionNbPiece($mouvement){
        
        $repartitionFinan = "";
        if($mouvement != "MODIFICATIF"){
            $repartitionFinan .= ((isset($this->row['co_mais_piece_nb']) && $this->row['co_mais_piece_nb'] == 't') ? 1 : 0)."|";
        }
        
        $repartitionFinan .= ((isset($this->row['co_log_1p_nb']) && is_numeric($this->row['co_log_1p_nb'])) ? $this->row['co_log_1p_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_log_2p_nb']) && is_numeric($this->row['co_log_2p_nb'])) ? $this->row['co_log_2p_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_log_3p_nb']) && is_numeric($this->row['co_log_3p_nb'])) ? $this->row['co_log_3p_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_log_4p_nb']) && is_numeric($this->row['co_log_4p_nb'])) ? $this->row['co_log_4p_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_log_5p_nb']) && is_numeric($this->row['co_log_5p_nb'])) ? $this->row['co_log_5p_nb'] : 0)."|";
        $repartitionFinan .= ((isset($this->row['co_log_6p_nb']) && is_numeric($this->row['co_log_6p_nb'])) ? $this->row['co_log_6p_nb'] : 0);

        return $repartitionFinan;
    }

    /**
     * Permet de mettre en forme les données du mouvement suivi pour une ouverture de chantier
     * @return string Chaîne contenant les infos spécifiques aux DOC séparé par "|"
     */
    function chantier($row){

            $chantier="";
            if(isset($row['date_chantier'])) {
                $chantier .= substr($row['date_chantier'],8,2).substr($row['date_chantier'],5,2).
                    substr($row['date_chantier'],0,4); // *** au format francais
            }
            $chantier .= "|";
            $chantier .= ((isset($row['doc_nb_log']) AND $row['doc_nb_log'] != "" ) ? $row['doc_nb_log'] : "")."|";
            $chantier .= ((isset($row['doc_nb_log_indiv']) AND $row['doc_nb_log_indiv'] != "" ) ? $row['doc_nb_log_indiv'] : "")."|";
            $chantier .= ((isset($row['doc_nb_log_coll']) AND $row['doc_nb_log_coll'] != "" ) ? $row['doc_nb_log_coll'] : "")."|";
            $chantier .= ((isset($row['doc_surf']) AND $row['doc_surf'] != "" ) ? substr(floor(floatval($row['doc_surf'])),0,7) : "")."|";
            $chantier .= ((isset($row['doc_nb_log_lls']) AND $row['doc_nb_log_lls'] != "" ) ? $row['doc_nb_log_lls'] : "")."|";
            $chantier .= ((isset($row['doc_nb_log_aa']) AND $row['doc_nb_log_aa'] != "" ) ? $row['doc_nb_log_aa'] : "")."|";
            $chantier .= ((isset($row['doc_nb_log_ptz']) AND $row['doc_nb_log_ptz'] != "" ) ? $row['doc_nb_log_ptz'] : "")."|";
            $chantier .= ((isset($row['doc_nb_log_autre']) AND $row['doc_nb_log_autre'] != "" ) ? $row['doc_nb_log_autre'] : "")."|";
            // indice de la tranche commencée
            $chantier .= "0|";

            return $chantier;       
    }

    /**
     * Permet d'afficher le dessein correspondant à une DAACT
     * @param   array   $row    Les données à ajouter
     * 
     * @return string Chaîne contenant les infos spécifiques aux DAACT séparé par "|"
     */
    function achevement($row){
        
        $achevement="";
        if(isset($row['date_achevement'])) {
            $achevement .= substr($row['date_achevement'],8,2).substr($row['date_achevement'],5,2).
                substr($row['date_achevement'],0,4); // *** au format francais
        }
        $achevement .= "|";
        
        $achevement .= ((isset($row['daact_nb_log']) AND $row['daact_nb_log'] != "" ) ? $row['daact_nb_log'] : "")."|";
        $achevement .= ((isset($row['daact_nb_log_indiv']) AND $row['daact_nb_log_indiv'] != "" ) ? $row['daact_nb_log_indiv'] : "")."|";
        $achevement .= ((isset($row['daact_nb_log_coll']) AND $row['daact_nb_log_coll'] != "" ) ? $row['daact_nb_log_coll'] : "")."|";
        $achevement .= ((isset($row['daact_surf']) AND $row['daact_surf'] != "" ) ? substr(floor(floatval($row['daact_surf'])),0,7) : "")."|";
        $achevement .= ((isset($row['daact_nb_log_lls']) AND $row['daact_nb_log_lls'] != "" ) ? $row['daact_nb_log_lls'] : "")."|";
        $achevement .= ((isset($row['daact_nb_log_aa']) AND $row['daact_nb_log_aa'] != "" ) ? $row['daact_nb_log_aa'] : "")."|";
        $achevement .= ((isset($row['daact_nb_log_ptz']) AND $row['daact_nb_log_ptz'] != "" ) ? $row['daact_nb_log_ptz'] : "")."|";
        $achevement .= ((isset($row['daact_nb_log_autre']) AND $row['daact_nb_log_autre'] != "" ) ? $row['daact_nb_log_autre'] : "")."|";
        // indice de la tranche complétée
        $achevement .= "0|";
        // Finchantier 1 si etat=cloturer sinon 0
        if ($row['statut_di']=="cloture"){
          $achevement.="1";
        }else{
          $achevement.="0";
        }
        // indique la provenance de l'info d'achèvement des travaux (déclaration/DGI)
        $achevement .= "|";
        return $achevement;
    }
    
    /**
     * Permet de récupérer la valeur par defaut du champ passé en paramètre
     * @param  string $champ nom du champ dont on souhaite afficher la valeur par defaut
     * @return string        valeur par defaut
     */
    function defaultValue($champ){
        if($this->DEBUG==2) return $champ;
        if(isset($this->parametre[$champ])){
            return $this->parametre[$champ];
        }else
            return $this->val[$champ];
    }
    
    /**
     * Normalise la chaine de caractère ou renvoit "valeur manquant".
     * 
     * @param   $val    La valeur du champ
     * @return  string  la chaine formatée ou ""
     */
    function maj($val) {
        $val = strtoupper($val);
        $val=str_replace(chr(195), "", $val);	// supprime le premier code des accents en UTF-8
        $s = array('/[âàäÀÂ]/', '/[éêèëÉÈÊ]/', '/[îï]/', '/[ôöÔ]/', '/[ûùü]/', '/[çÇ]/', '/\'|\"|^abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ\-\s\r/', '/\n/');
        $r = array('A', 'E', 'I', 'O', 'U', 'C', ' ', ' ');
        $val = preg_replace($s , $r, $val);
        // Formatage des valeurs manquantes
        return $val;
    }
    
    /**
     * Retourne le code INSEE d'un pays
     * 
     * @param string $pays  Le nom du pays
     * @return int  Le code insee du pays
     */
    function getCodeInseePays($pays) {
        //
        if($pays!=''&&isset($this->pays[substr($pays, 0, 4)])) {
            return $this->pays[substr($pays, 0, 4)];
        }
        return $this->pays['FRAN'];
    }
    
    function getCommune($collectivite) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    valeur
                FROM
                    %1$som_parametre
                WHERE
                    om_collectivite = %2$d
                    AND libelle = \'commune\'',
                DB_PREFIXE,
                intval($collectivite)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    function getDepartement($collectivite) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    valeur
                FROM
                    %1$som_parametre
                WHERE
                    om_collectivite = %2$d
                    AND libelle = \'departement\'',
                DB_PREFIXE,
                intval($collectivite)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

}


