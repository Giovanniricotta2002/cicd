<?php

use \ReflectionObject;
use \DirectoryIterator;

require_once __DIR__.'/Metadata.class.php';

/**
 * Représente une usine (logicielle) à Métadonnées.
 */
class MetadataFactory
{
    const METADATA_BASE_CLASSNAME = 'Metadata';

    protected $minimalSetOfKv = array();

    /**
     * Construit un ensemble de metadonnée à partir d'un type.
     *
     * @param  string  $type  Type de métadonnée à construire
     * @param  array   $key   Clés/valeurs à assigner (doit contenir au moins les métadonnées de la
     *                        classe de base METADATA_BASE_CLASSNAME)
     *
     * @return  string|Metadata  Chaîne si une erreur est rencontrée, Metadata sinon
     */
    public function build(string $type, array $kv) {

        // s'assure que le minimum des métadonnées est renseigné
        foreach(self::getMinimalSetOfKv() as $key) {
            if (! isset($kv[$key]) || empty($kv[$key])) {
                return __("La métadonnée '$key' est obligatoire (de base)");
            }
        }

        // charge la classe de cet ensemble de métadonnées
        $className = '/Metadata'.ucwords($type).'.class.php';
        $classPath = __DIR__."/$className";
        if (! file_exists($classPath)) {
            return __("Le fichier '$classPath' des métadonnées de type '$type' n'existe pas");
        }
        require_once "$classPath";

        // constuit l'objet
        return $this->build($className, $kv);
    }

    /**
     * Obtient l'ensemble minimum de métadonnée à fournir pour construire un ensemble.
     *
     * @return array  La liste des noms des métadonnées à fournir
     */
    protected function getMinimalSetOfKv() {
        if (empty($this->minimalSetOfKv)) {
            $refObj = new ReflectionObject(self::METADATA_BASE_CLASSNAME);
            $props = $refObj->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
            foreach($props as $prop) {
                $this->minimalSetOfKv[] = $prop->getName();
            }
        }
        return $this->minimalSetOfKv;
    }

    /**
     * Construit l'objet de l'ensemble de métadonnées.
     *
     * @param  string  $type  Type de métadonnée à construire
     * @param  array   $key   Clés/valeurs à assigner (doit contenir au moins les métadonnées de la
     *                        classe générique 'Metadata')
     *
     * @return  string|Metadata  Chaîne si une erreur est rencontrée, Metadata sinon
     */
    protected function buildMetadata(string $className, array $kv) {
        $md = new $className();

        $refObj = new ReflectionObject($md);
        $props = $refObj->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
        foreach($props as $prop) {
            $propName = $prop->getName();
            if (isset($kv[$propName]) && ! empty($kv[$propName])) {
                $md->$propName = $kv[$propName];
            }
        }
        return $md;
    }

    /**
     * Liste les différents types de métadonnées existantes
     * (basés sur les nom des fichiers des classes de métadonnées).
     *
     * @return array  La liste des nom des types de métadonnées disponibles
     */
    public function listTypes() {
        $types = array();
        foreach (new DirectoryIterator(__DIR__) as $file) {
            if ($file->isFile()) {
                $fn = $file->getFilename();
                if (strpos($fn, self::METADATA_BASE_CLASSNAME) === 0 && $fn != basename(__FILE__) &&
                        substr($fn, -10, 10) == '.class.php') {
                    $types[] = substr($fn, strlen(self::METADATA_BASE_CLASSNAME), -10);
                }
            }
        }
        return $types;
    }
}
