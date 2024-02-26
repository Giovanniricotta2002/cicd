-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.5.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.5.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#8925] Suppression d'un état dans le paramétrage par défaut de l'application
--

DELETE FROM om_etat
WHERE om_collectivite = 1
    AND id = 'ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE'
    AND libelle = 'ACCUSE DE RECEPTION DE CONSULTATION OFFICIELLE'
    AND actif = true
    AND orientation = 'P'
    AND format = 'A4'
    AND logo = 'logopdf.png'
    AND logoleft = 10
    AND logotop = 10
    AND titre_om_htmletat = '<p style="text-align: left;"><span style="font-size: 10px;"><span style="font-family: times;"><span style="font-weight: bold;">[libelle_om_lettretype]<br/>Pour le dossier&nbsp;numéro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[libelle_dossier]&nbsp;&nbsp;déposé&nbsp;le&nbsp;[date_depot_dossier]<br/>par&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[nom_petitionnaire_principal]<br/><br/>Correspondant&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[nom_correspondant]<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[numero_correspondant]&nbsp;[voie_correspondant]<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[complement_correspondant]&nbsp;[lieu_dit_correspondant]&nbsp;[bp_correspondant]<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[code_postal_correspondant]&nbsp;[ville_correspondant]&nbsp;[cedex_correspondant]&nbsp;[pays_correspondant]<br/><br/>sur&nbsp;le&nbsp;terrain&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[terrain_adresse_voie_numero_dossier]&nbsp;[terrain_adresse_voie_dossier]&nbsp;[terrain_adresse_lieu_dit_dossier]&nbsp;[terrain_adresse_bp_dossier]&nbsp;[terrain_adresse_code_postal_dossier]&nbsp;[terrain_adresse_localite_dossier]&nbsp;[terrain_adresse_cedex_dossier]<br/>arrondissement&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[libelle_arrondissement]<br/>______________________________________________________________________<br/>Dossier&nbsp;suivi&nbsp;par&nbsp;&nbsp;[nom_instructeur]&nbsp;-&nbsp;[telephone_instructeur]&nbsp;-&nbsp;[division_instructeur]&nbsp;-&nbsp;[email_instructeur]</span></span></span></p>'
    AND titreleft = 70
    AND titretop = 15
    AND titrelargeur = 130
    AND titrehauteur = 5
    AND titrebordure = '1'
    AND corps_om_htmletatex = '<p style="text-align: left;"><span style="font-size: 10px;"><span style="font-family: times;"><span style="font-weight: bold;">Accusé de réception automatique.<br/>______________________________________________________________________<br/></span>Le message ci-dessous a bien été reçu par le logiciel openARIA:<br/>Consultation&nbsp;numéro&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[service_libelle]&nbsp;&nbsp;envoyé&nbsp;le&nbsp;[dossier_message_date_emission]<br/>La consultation originel est [dossier_message_originel_consultation]<br/></span></span></p>'
    AND om_sql = (SELECT om_requete FROM om_requete WHERE code = 'accuse_reception_consultation')
    AND se_font = 'helvetica'
    AND se_couleurtexte = '0-0-0'
    AND margeleft = 10
    AND margetop = 10
    AND margeright = 10
    AND margebottom = 10
    AND header_om_htmletat IS NULL
    AND header_offset = 0
    AND footer_om_htmletat = '<p style="text-align:center;font-size:8pt;"><em>Page &numpage/&nbpages</em></p>'
    AND footer_offset = 12;

--
-- END / [#8925] Suppression d'un état dans le paramétrage par défaut de l'application
--

--
-- BEGIN / [#8927] Modification de la récupération des valeurs des contraintes SIG 
--

COMMENT ON COLUMN dossier_contrainte.reference IS 'Contrainte récupérée depuis le SIG';

--
-- END / [#8927] Modification de la récupération des valeurs des contraintes SIG 
--
