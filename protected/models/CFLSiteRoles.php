<?php
/**
 * @property $site_role_id
 * @property $site_role_title
 * @property $site_role_desc
 
 */
class CFLSiteRoles extends CActiveRecord {

    /**
     *
     * @param type $className
     * @return CFLCatalog
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{site_roles}}';
    }
}