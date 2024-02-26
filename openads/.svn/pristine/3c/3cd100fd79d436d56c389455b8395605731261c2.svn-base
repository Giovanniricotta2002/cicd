-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.10.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.10.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9833] Évolution du moniteur Plat'AU / IDE'AU
--

-- La requete permettant de créer les colonnes suivantes : creation_date, creation_time, last_modification_date, last_modification_time
ALTER TABLE task
    ADD COLUMN creation_date date NULL,
    ADD COLUMN creation_time time without time zone NULL,
    ADD COLUMN last_modification_date date NULL,
    ADD COLUMN last_modification_time time without time zone NULL;
--
COMMENT ON COLUMN task.creation_date IS 'Date de création de la tâche';
COMMENT ON COLUMN task.creation_time IS 'Heure de création de la tâche';
COMMENT ON COLUMN task.last_modification_date IS 'Date de la dernière modification de la tâche';
COMMENT ON COLUMN task.last_modification_time IS 'Heure de la dernière modification de la tâche';

-- La requete permettant de récuperer la date de creation qui est dans timestamp_log et mettre cette date dans la colonne creation_date
UPDATE task SET creation_date = (
    SELECT TO_DATE(
        json_extract_path_text(timestamp_log::json, 'creation_date'), 'YYYY-MM-DD HH24:MI:SS')
    FROM task as task1
    WHERE task1.task = task.task
);

-- La requete permettant de récuperer l'heure de creation qui est dans timestamp_log et mettre cette heure dans la colonne creation_time
UPDATE task SET creation_time = (
    SELECT TO_TIMESTAMP(
        json_extract_path_text(timestamp_log::json, 'creation_date'), 'YYYY-MM-DD HH24:MI:SS'
    )
    FROM task as task1
    WHERE task1.task = task.task
);

-- La requete permettant de récuperer la date de dernier modification qui est dans timestamp_log et mettre cette date dans la colonne last_modification_date
UPDATE task
SET last_modification_date = (
    SELECT TO_DATE(
        ARRAY_TO_STRING(
            REGEXP_MATCHES(
                timestamp_log,
                '^.*.modification_date.\:.(.*).,.state.*$',
                'gm'
            ),
        ''
        ),
        'YYYY-MM-DD HH24:MI:SS'
    )
    FROM task as task1
    WHERE task1.task = task.task
);

--La requete permettant de récuperer l'heure de dernier modification qui est dans timestamp_log et mettre cette heure dans la colonne last_modification_time
UPDATE task
SET last_modification_time = (
    SELECT TO_TIMESTAMP(
        ARRAY_TO_STRING(
            REGEXP_MATCHES(
                timestamp_log,
                '^.*.modification_date.\:.(.*).,.state.*$',
                'gm'
            ),
        ''
        ),
        'YYYY-MM-DD HH24:MI:SS'
    )
    FROM task as task1
    WHERE task1.task = task.task
);

-- Mise en forme du timestamp_log et suppression de la date de création
UPDATE task SET timestamp_log = COALESCE((
    SELECT (
        SELECT 
            array_to_json(ARRAY_AGG(value)) 
        FROM 
            json_each(
            (SELECT 
                timestamp_log::json 
            FROM 
                task as task_sq 
            WHERE 
                task_sq.task = task_sq2.task)) 
        WHERE 
                key != 'creation_date') 
    FROM 
        task as task_sq2 
    WHERE 
        task_sq2.task =task.task
    ), '[]'
);

--
-- END / [#9833] Évolution du moniteur Plat'AU / IDE'AU
--

--
-- BEGIN - [#9864] Widget de suivi des tâches Plat'AU 
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'suivi_tache', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'suivi_tache' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

--
-- END - [#9864] Widget de suivi des tâches Plat'AU 
--

--
-- BEGIN / [#9848] Ajout de trois permissions pour les journaux d'instruction
--

-- Ajout Administrateur fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle  = 'ADMINISTRATEUR FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);

-- Ajout Administrateur technique
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle  = 'ADMINISTRATEUR TECHNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
);

-- Ajout Administrateur technique et fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle  = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#9848] - Ajout de trois permissions pour les journaux d'instruction
--

--
-- BEGIN / [#9856] - Ajouter un champ de fusion sur la liste "récapitulatif du dossier d'instruction/instruction"
--

--
-- Évolution de la requête permettant de récupérer les champs de fusion de l'instruction pour
-- ajouter un champs de récupération du libellé du service consultant
--
UPDATE om_requete AS omr SET
    requete = regexp_replace(
            omr.requete,
            '(signataire_arrete.visa_4 AS visa_signataire_4,)',
            E'\\1\nconsultation_entrante.service_consultant_libelle,'
        ),
    merge_fields = regexp_replace(
        omr.merge_fields,
        '(\[archive_delai_instruction\])',
        E'\\1\n[agrement_signataire]\n[visa_signataire]\n[visa_signataire_2]\n[visa_signataire_3]\n[visa_signataire_4]\n[service_consultant_libelle]'
    )
WHERE
    omr.code = 'instruction';

-- mise à jour du FROM
UPDATE om_requete AS omr SET
    requete = regexp_replace(
            omr.requete,
            '(instruction.dossier=dossier.dossier)',
            E'\\1\nLEFT JOIN\n &DB_PREFIXEconsultation_entrante\n ON consultation_entrante.dossier=dossier.dossier'
        )
WHERE
    omr.code = 'instruction';

--
-- END / [#9856] - Ajouter un champ de fusion sur la liste "récapitulatif du dossier d'instruction/instruction"
--

--
-- BEGIN / [#9876] Ajout de la permission de créer des messages manuel pour les profils d'instructeur polyvalent et d'instructeur polyvalent commune 
--

-- Ajout du droit d'ajouter des messages au profil INSTRUCTEUR POLYVALENT
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter', (SELECT om_profil FROM om_profil WHERE libelle  = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- Ajout du droit d'ajouter des messages au profil INSTRUCTEUR POLYVALENT COMMUNE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter', (SELECT om_profil FROM om_profil WHERE libelle  = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

--
-- END / [#9876] Ajout de la permission de créer des messages manuel pour les profils d'instructeur polyvalent et d'instructeur polyvalent commune 
--
