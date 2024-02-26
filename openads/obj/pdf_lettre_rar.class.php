<?php
/**
 * Ce script permet de définir la classe 'pdf_lettre_rar'.
 *
 * @package openads
 * @version SVN : $Id: pdf_lettre_rar.class.php 3721 2016-03-17 11:25:25Z nmeucci $
 */

require_once PATH_OPENMAIRIE."fpdf_etat.php";

/**
 * Classe de base permettant l'édition d'un document pdf à imprimer sur
 * les feuillets d'accusé de récéption de la poste
 */
class pdf_lettre_rar extends PDF {

    private $pdf;
    private $utils;
    private $filename;
    private $adresse_dest;
    private $adresse_emetteur;
    private $specifique_content;
    private $font = 'Helvetica';
    private $fontsize = 9;
    private $code_phase = null;
    private $ligne_code_phase = 1; // 2ème ligne car débute à 0
    private $cell_width = 84;
    private $cell_height = 4;


    // Initialisation des attributs
    function init($f) {

        // Definition des attributs
        $this->filename = "lettre_rar".date("dmYHis");
        $this->utils = $f;
        $this->adresse_emetteur = explode("\n",$this->utils->getParameter('adresse_direction_urbanisme_RAR'));
        if (DBCHARSET=="UTF8"){
            $this->adresse_emetteur = $this->encodeToUtf8($this->adresse_emetteur);
        }

        //Paramétrage du pdf
        $this->SetFont($this->font, '', $this->fontsize);
        $this->SetMargins(0,0,0);
        $this->SetAutoPageBreak(false, 0);
        $this->setPrintHeader(false);
    }

    /**
     * Ajout d'une page au document PDF.
     * 
     * @param   array de string  $adresse_dest        Adresse destinataire
     * @param   array de string  $specifique_content  Nom destinataire + DI + Code barre
     * @param   string           $code_phase          Eventuel code de phase
     * @return  void
     */
    public function addLetter($adresse_dest, $specifique_content, $code_phase = '') {
        if ($code_phase != '') {
            $this->code_phase = $code_phase;
        }
        $this->adresse_dest = $adresse_dest;
        $this->specifique_content = $specifique_content;
        //Formatage des données si la base de données est en UTF8
        if(DBCHARSET=="UTF8"){
            $this->adresse_dest = $this->encodeToUtf8($adresse_dest);
            $this->specifique_content = $this->encodeToUtf8($specifique_content);
        }
        $this->addPage();
        $this->printAvisPassage();
        $this->printPreuveDistri();
        $this->printAvisRecept();
    }

    // Insertion des adresses dans la partie "Avis de passage"
    private function printAvisPassage() {
        if( DEBUG != 0) {
            $this->SetXY(0, 0);
            $this->SetDrawColor(255, 215, 0);
            $this->Cell(209.5, 98.5,"",1,2,true);
        }
        $this->printCellRAR(32, 35, $this->adresse_dest);
        $this->printCellRAR(120, 35, $this->adresse_dest);
    }

    // Insertion des adresses dans la partie "Preuve de distribution"
    private function printPreuveDistri() {
        if( DEBUG != 0) {
            $this->SetXY(0, 98.5);
            $this->SetDrawColor(131, 131, 131);
            $this->Cell(209.5, 101.5,"",1,2,true);
        }
        $this->printCellRAR(52, 142, $this->adresse_dest);
        $this->printCellRAR(52, 172, $this->adresse_emetteur, true);
    }

    // Insertion des adresses dans la partie "Avis de reception"
    private function printAvisRecept() {
        if( DEBUG != 0) {
            $this->SetXY(0, 200);
            $this->SetDrawColor(205, 51, 51);
            $this->Cell(209.5, 97,"",1,2,true);
        }
        $this->printCellRAR(52, 233, $this->specifique_content, true);
        // s'il existe, on ajoute dans l'adresse émetteur le code de phase
        if ($this->code_phase != null) {
            $this->add_phase_to_adresse_emetteur();
        }
        $this->printCellRAR(52, 263, $this->adresse_emetteur, true);
        // puis, vu que l'on passe par une propriété de la classe,
        // on le supprime afin de l'afficher uniquement dans le bloc AR
        if ($this->code_phase != null) {
            $this->unset_phase_in_adresse_emetteur();
        }
    }

    /**
     * Insertion du code de phase à la nième ligne de l'adresse de l'émetteur.
     * 
     * @return  void
     */
    private function add_phase_to_adresse_emetteur() {
        $adresse_emetteur = $this->adresse_emetteur;
        array_splice($adresse_emetteur, $this->ligne_code_phase, 0, $this->code_phase);
        $this->adresse_emetteur = $adresse_emetteur;
    }

    /**
     * Suppression du code de phase à la nième ligne de l'adresse de l'émetteur.
     * Attention : aucun contrôle sur sa présence n'est effectué !
     * 
     * @return  void
     */
    private function unset_phase_in_adresse_emetteur() {
        unset($this->adresse_emetteur[$this->ligne_code_phase]);
    }

    // Insertion d'une adresse
    private function printCellRAR($left, $top, $content,$fullBold = false) {

        // 1ere ligne en gras
        $this->SetFont($this->font, 'B', $this->fontsize);
        $this->SetXY($left, $top);
        $border = 0;
        if( DEBUG != 0) {
            $this->SetDrawColor(0, 0, 0);
            $border = 1;
        }
        foreach ($content as $line) {
            
            //Gestion du code barres
            if ( preg_match('/^\|{5}[0-9]{12}\|{5}$/', $line)){
                $this->Code128($this->GetX()+19, $this->GetY(), str_replace("|||||", "", $line), 50, 5);
                $this->Cell($this->cell_width, $this->cell_height*2,"",$border,2,false);
            }
            else{
                $this->Cell($this->cell_width, $this->cell_height,/*utf8_decode(*/trim($line)/*)*/,$border,2,false);
            }
            // test si tout le contenu de la cellule doit être en gras
            if(!$fullBold) {
                $this->SetFont($this->font, '', $this->fontsize);
            }
        }

    }
    
    //Surchage afin que le nombre de page ne s'affiche pas
    function Footer() {
    }
    
    /**
     * Encode les données passées au tableau en paramètre en UTF8
     * @param $data array Le tableau de données à traiter
     * 
     * @return array Le tableau de données encodées en UTF8
     */
    function encodeToUtf8($data) {
        
        //Tableau de résultats
        $res = array();
        //Liste des encodages possibles
        $encodage = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1");
        
        foreach ($data as $key => $value) {
            //
            $res[] = iconv(mb_detect_encoding($value,$encodage), "UTF-8", $value);
        }

        return $res;
    }

}


