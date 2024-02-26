-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.0.0-rc6' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.0.0-rc6') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN /  #1162 — Mise en place de la solution qui remplace l'utilisation du $_POST pour le développement de create_DI 
--

--
ALTER TABLE demande ADD COLUMN source_depot varchar(255) NULL;
COMMENT ON COLUMN demande.source_depot IS 'Permet d''indiquer la source de dépot, ce champ peut prendre en valeur : platau, app et publik';

--
-- END /  #1162 — Mise en place de la solution qui remplace l'utilisation du $_POST pour le développement de create_DI 
--

--
-- BEGIN /  #9598 — Affichage d'une miniature/vignette pour les documents
--

ALTER TABLE document_numerise ADD COLUMN uid_thumbnail character varying(64) NULL;
COMMENT ON COLUMN document_numerise.uid_thumbnail IS 'Identifiant unique de la miniature du fichier';

--
-- END /  #9598 — Affichage d'une miniature/vignette pour les documents
--

--
-- BEGIN / openads-culture #77 — Gérer les commentaires envoyés depuis le parapheur 
--

ALTER TABLE instruction ADD COLUMN commentaire_signature TEXT NULL;
COMMENT ON COLUMN instruction.commentaire_signature IS 'Commentaire reçu du parapheur.';
--
-- END / openads-culture #77 — Gérer les commentaires envoyés depuis le parapheur 
--

--
-- BEGIN / #1168 — Connecteur FileStorage S3
--

ALTER TABLE commission ALTER COLUMN om_fichier_commission_ordre_jour  TYPE character varying(255);
ALTER TABLE commission ALTER COLUMN om_fichier_commission_compte_rendu TYPE character varying(255);
ALTER TABLE consultation ALTER COLUMN om_fichier_consultation TYPE character varying(255);
ALTER TABLE consultation ALTER COLUMN fichier TYPE character varying(255);
ALTER TABLE document_numerise ALTER COLUMN uid TYPE character varying(255);
ALTER TABLE document_numerise ALTER COLUMN uid_thumbnail TYPE character varying(255);
ALTER TABLE instruction ALTER COLUMN om_fichier_instruction TYPE character varying(255);
ALTER TABLE rapport_instruction ALTER COLUMN om_fichier_rapport_instruction TYPE character varying(255);

--
-- END / #1168 — Connecteur FileStorage S3
--

--
-- BEGIN / [#9604] Ajout de la possibilité d'ajouter un commentaire sur une instruction
--

ALTER TABLE evenement
    ADD COLUMN commentaire BOOLEAN DEFAULT false,
    ADD COLUMN non_modifiable BOOLEAN DEFAULT false,
    ADD COLUMN non_supprimable BOOLEAN DEFAULT false;

COMMENT ON COLUMN evenement.commentaire IS 'Permet de définir si des commentaires doivent pouvoir être ajoutés à l''événement.';
COMMENT ON COLUMN evenement.non_modifiable IS 'Permet d''identifier si l''évenement ne doit plus pouvoir être modifié après ajout.';
COMMENT ON COLUMN evenement.non_supprimable IS 'Permet d''identifier si l''évenement ne doit plus pouvoir être supprimé après ajout.';

ALTER TABLE instruction ADD COLUMN commentaire TEXT NULL;
COMMENT ON COLUMN instruction.commentaire IS 'Commentaire permettant de justifier l''evenement.';

--
-- END / [#9604] Ajout de la possibilité d'ajouter un commentaire sur une instruction
--
