<?php
//$Id$ 
//gen openMairie le 18/12/2020 20:07

require_once "../gen/obj/lien_id_interne_uid_externe.class.php";

class lien_id_interne_uid_externe extends lien_id_interne_uid_externe_gen {

    /**
     * @var $SQL_TEMPLATE_DOSSIER_COLLECTIVITE
     *
     * Template pour sélectionner un/des éléments de la table de lien,
     * à partir d'un numéro de dossier et d'un identifiant de collectivité.
     */
    protected $SQL_TEMPLATE_DOSSIER_COLLECTIVITE = '
        SELECT
            %2$s
        FROM
            %1$sdossier
            LEFT JOIN %1$slien_id_interne_uid_externe
                ON lien_id_interne_uid_externe.%6$s = dossier.dossier
                AND lien_id_interne_uid_externe.object = \'%3$s\'
        WHERE
            dossier.om_collectivite = \'%4$s\'
            AND lien_id_interne_uid_externe.external_uid = \'%5$s\'
    ';

    /**
     * @var $SQL_TEMPLATE_DOSSIER
     *
     * Template pour sélectionner un/des éléments de la table de lien,
     * à partir d'un numéro de dossier et d'un identifiant de collectivité.
     */
    protected $SQL_TEMPLATE_DOSSIER = '
        SELECT
            %2$s
        FROM
            %1$sdossier
            LEFT JOIN %1$slien_id_interne_uid_externe
                ON lien_id_interne_uid_externe.%5$s = dossier.dossier
                AND lien_id_interne_uid_externe.object = \'%3$s\'
        WHERE
            lien_id_interne_uid_externe.external_uid = \'%4$s\'
    ';

    /**
     * @var $SQL_TEMPLATE_CONSULTATION
     *
     * Template pour sélectionner un/des éléments de la table de lien,
     * à partir d'un numéro de consultation et d'un identifiant de collectivité.
     */
    protected $SQL_TEMPLATE_CONSULTATION = '
        SELECT
            %2$s
        FROM
            %1$sconsultation
            LEFT JOIN %1$slien_id_interne_uid_externe
                ON lien_id_interne_uid_externe.object_id::INTEGER = consultation.consultation
                AND lien_id_interne_uid_externe.object = \'consultation\'
                AND lien_id_interne_uid_externe.dossier = \'%4$s\'
        WHERE
            lien_id_interne_uid_externe.external_uid = \'%3$s\'
    ';

    /**
     * Vérifie si la liaison existe déjà.
     *
     * @param  string  $object       Objet
     * @param  string  $object_id    Identifiant interne de l'objet
     * @param  string  $external_uid Identifiant externe de l'objet
     * @param  string  $dossier      Identifiant interne du dossier d'instruction
     *
     * @return boolean
     */
    public function is_exists($object = null, $object_id = null, $external_uid = null, $dossier = null) {
        // Condition de la requête SQL
        $where = '';
        if ($object !== null) {
            $where_or_and = $where !== '' ? 'AND' : 'WHERE';
            $where .= sprintf(' %s object = \'%s\' ', $where_or_and, $object);
        }
        if ($object_id !== null) {
            $where_or_and = $where !== '' ? 'AND' : 'WHERE';
            $where .= sprintf(' %s object_id = \'%s\' ', $where_or_and, $object_id);
        }
        if ($external_uid !== null) {
            $where_or_and = $where !== '' ? 'AND' : 'WHERE';
            $where .= sprintf(' %s external_uid = \'%s\' ', $where_or_and, $external_uid);
        }
        if ($dossier !== null) {
            $where_or_and = $where !== '' ? 'AND' : 'WHERE';
            $where .= sprintf(' %s dossier = \'%s\' ', $where_or_and, $dossier);
        }
        // Requête SQL
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    COUNT(lien_id_interne_uid_externe)
                FROM
                    %1$slien_id_interne_uid_externe
                %2$s',
                DB_PREFIXE,
                $where
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return null;
        }
        if ($qres["result"] === '0') {
            return false;
        }
        return true;
    }


    /**
     * Recupère la liste complète des liens par numéro du dossier d'instruction
     *
     * @param  string $dossier  Identifiant du dossier d'instruction
     * @param  string $category Filtre par catégorie les liens
     * @param  string $object   Filtre par objet les liens
     *
     * @return mixed           Array, sinon false en cas d'erreur
     */
    public function get_all_lien_id_interne_uid_externe_by_dossier(string $dossier, string $category = null, string $object = null) {
        $query = sprintf('
            SELECT *
            FROM %1$slien_id_interne_uid_externe
            WHERE (dossier = \'%2$s\' OR ((dossier IS NULL OR dossier = \'\') AND object_id = \'%2$s\'))
            %3$s
            %4$s
            ORDER BY lien_id_interne_uid_externe ASC',
            DB_PREFIXE,
            $dossier,
            $category !== null ? sprintf(' AND category = \'%s\' ', $category) : '',
            $object !== null ? sprintf(' AND object = \'%s\' ', $object) : ''
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        return $res['result'];
    }

    /**
     * Permet de vérifier que le dossier existe à partir de son identifiant.
     * Il est nécessaire de spécifier soit l'acteur soit la collectivité
     *
     * @param string $external_uid    identifiant du dossier ou de la consultation
     * @param string $collectiviteId  identifiant de la collectivité
     * @param string $type            type d'objet pour le dossier (dossier|consultation)
     *
     * @return boolean  'true' si le dossier existe, 'false' sinon
     *
     * @throw InvalidArgumentException  si aucun acteur ni collectivité
     */
    public function dossier_exists(string $external_uid, string $collectiviteId,
                                     string $type = 'dossier') {
        if (empty($collectiviteId)) {
            throw new InvalidArgumentException(sprintf(
                __("Échec du test d'existence du dossier %s (aucun acteur / service indiqué)"),
                $external_uid));
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                $this->SQL_TEMPLATE_DOSSIER_COLLECTIVITE,
                DB_PREFIXE,
                'COUNT(lien_id_interne_uid_externe.object_id)',
                $this->f->db->escapeSimple($type),
                $this->f->db->escapeSimple($collectiviteId),
                $this->f->db->escapeSimple($external_uid),
                'object_id'
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $count = $qres["result"];
        $this->f->addToLog(__METHOD__."() count: $count", VERBOSE_MODE);
        return intval($count) != 0;
    }

    /**
     * Récupère l'identifiant openADS d'un dossier à partir de son identifiant Platau
     * Il est nécessaire de spécifier l'identifiant de la collectivité.
     *
     * @param string $external_uid    identifiant du dossier ou de la consultation
     * @param string $collectiviteId  identifiant de la collectivité
     * @param string $type                 type d'objet pour le dossier (dossier|dossier_consultation)
     *
     * @return string  le numéro de dossier trouvé, null sinon
     *
     * @throw InvalidArgumentException  si aucun acteur ni collectivité
     */
    public function get_id_dossier_from_external_uid(string $external_uid, string $collectiviteId,
                                                     string $type = 'dossier', string $field = 'object_id') {
        if (empty($collectiviteId)) {
            throw new InvalidArgumentException(sprintf(
                __("Échec de l'obtention du dossier %s (aucun acteur / service indiqué)"),
                $external_uid));
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                $this->SQL_TEMPLATE_DOSSIER_COLLECTIVITE,
                DB_PREFIXE,
                sprintf('lien_id_interne_uid_externe.%s', $field),
                $this->f->db->escapeSimple($type),
                $this->f->db->escapeSimple($collectiviteId),
                $this->f->db->escapeSimple($external_uid),
                $field
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $id_dossier = $qres["result"];
        $this->f->addToLog(__METHOD__."() id_dossier: $id_dossier", VERBOSE_MODE);
        return $id_dossier;
    }

    /**
     * Récupère l'identifiant openADS d'un dossier à partir de son identifiant Platau
     *
     * @param string $external_uid    identifiant du dossier ou de la consultation
     * @param string $type                 type d'objet pour le dossier (dossier|dossier_consultation)
     *
     * @return string  le numéro de dossier trouvé, null sinon
     *
     * @throw InvalidArgumentException  si aucun acteur ni collectivité
     */
    public function get_id_dossier_from_external_uid_without_collectivite(string $external_uid, string $type = 'dossier', string $field = 'object_id') {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                $this->SQL_TEMPLATE_DOSSIER,
                DB_PREFIXE,
                sprintf('lien_id_interne_uid_externe.%s', $field),
                $this->f->db->escapeSimple($type),
                $this->f->db->escapeSimple($external_uid),
                $field
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $id_dossier = $qres["result"];
        $this->f->addToLog(__METHOD__."() id_dossier: $id_dossier", VERBOSE_MODE);
        return $id_dossier;
    }

    /**
     * Récupère l'identifiant openADS d'une consultation à partir de son identifiant Platau
     * Il est nécessaire de spécifier l'identifiant de la collectivité.
     *
     * @param string $external_uid    identifiant de la consultation
     * @param string $dossier         identifiant du dossier d'instruction
     *
     * @return string  le numéro de la consultation trouvé, null sinon
     *
     * @throw InvalidArgumentException  si aucun acteur ni collectivité
     */
    public function get_id_consultation_from_external_uid(string $external_uid, string $dossier) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                $this->SQL_TEMPLATE_CONSULTATION,
                DB_PREFIXE,
                'lien_id_interne_uid_externe.object_id',
                $this->f->db->escapeSimple($external_uid),
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $id_consultation = $qres["result"];
        $this->f->addToLog(__METHOD__."() id_consultation: $id_consultation", VERBOSE_MODE);
        return $id_consultation;
    }
}
