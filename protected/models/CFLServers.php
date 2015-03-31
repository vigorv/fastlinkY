
<?php

/**
 * This is the model class for table "{{servers}}".
 *
 * The followings are the available columns in table '{{servers}}':
 * @property string $server_id
 * @property string $server_addr
 * @property string $server_ip
 * @property integer $server_port
 * @property string $server_desc
 * @property string $server_ipv6
 * @property integer $server_is_active
 * @property integer $server_priority
 * @property string $server_letter
 * @property integer $server_group
 * @property integer $zone_id
 */
class CFLServers extends CActiveRecord {

    /**
     * @static
     * @param string $className
     * @return CFLServers
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{servers}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('server_port, server_is_active, server_priority, server_group, zone_id', 'numerical', 'integerOnly' => true),
            array('server_addr, server_desc', 'length', 'max' => 64),
            //array('server_ip', 'match', 'pattern'=>'/^(\d{1,15})|(INET_ATON\(\'(?:\d{1,3}\.){3}\d{1,3}\'\))$/i'),
            //array('server_ip', 'length', 'max'=>10),
            array('server_ipv6', 'length', 'max' => 16),
            array('server_letter', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('server_id, server_addr, server_ip, server_port, server_desc, server_ipv6, server_is_active, server_priority, server_letter, server_group, zone_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'server_id' => 'Server',
            'server_addr' => 'Server Addr',
            'server_ip' => 'Server Ip',
            'server_port' => 'Server Port',
            'server_desc' => 'Server Desc',
            'server_ipv6' => 'Server Ipv6',
            'server_is_active' => 'Server Is Active',
            'server_priority' => 'Server Priority',
            'server_letter' => 'Server Letter',
            'server_group' => 'Server Group',
            'zone_id' => 'Zone',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('server_id', $this->server_id, true);
        $criteria->compare('server_addr', $this->server_addr, true);
        $criteria->compare('server_ip', $this->server_ip, true);
        $criteria->compare('server_port', $this->server_port);
        $criteria->compare('server_desc', $this->server_desc, true);
        $criteria->compare('server_ipv6', $this->server_ipv6, true);
        $criteria->compare('server_is_active', $this->server_is_active);
        $criteria->compare('server_priority', $this->server_priority);
        $criteria->compare('server_letter', $this->server_letter, true);
        $criteria->compare('server_group', $this->server_group);
        $criteria->compare('zone_id', $this->zone_id);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria, 'pagination' => array(
                        'pageSize' => Yii::app()->params['admin_items_per_page']),
                        )
        );
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

    /**
     *
     * @param string $lst_zones
     * @return array
     */
    public function getServersInZones($lst_zones) {
        $sv_criteria = new CDbCriteria();
        $sv_criteria->select = '*,z.zone_prio';
        $sv_criteria->alias = 'servers';
        $sv_criteria->join = 'left join {{zones}} z ON z.`zone_id` = `servers`.`zone_id`';
        $sv_criteria->condition = '`servers`.`zone_id` in (' . $lst_zones . ')';
        $sv_criteria->order = 'z.zone_prio DESC';
        return $this->getCommandBuilder()
                        ->createFindCommand($this->tableSchema, $sv_criteria)
                        ->queryAll();
    }

    public function getClientServerList($lst_zones) {
        $sv_criteria = new CDbCriteria();
        $sv_criteria->select = '*,z.zone_prio';
        $sv_criteria->alias = 'servers';
        $sv_criteria->join = 'left join {{zones}} z ON z.`zone_id` = `servers`.`zone_id`';
        $sv_criteria->condition = '`servers`.`zone_id` in (' . $lst_zones . ') AND servers.server_is_active = 1 AND ';
        $sv_criteria->order = 'z.zone_prio DESC';
        return $this->getCommandBuilder()
                        ->createFindCommand($this->tableSchema, $sv_criteria)
                        ->queryAll();
    }

    /**
     *
     * @param string $lst_zones
     * @param int $group
     * @param string $letter
     * @return mixed
     */
    public function getClientServers($lst_zones, $group, $letter) {
        $sv_criteria = new CDbCriteria();
        $sv_criteria->select = '*,z.zone_prio';
        $sv_criteria->alias = 'servers';
        $sv_criteria->join = 'left join {{zones}} z ON z.`zone_id` = `servers`.`zone_id`';
        $sv_criteria->condition = '`servers`.`zone_id` in (' . $lst_zones . ') AND servers.server_is_active = 1 AND servers.server_group = ' . $group;
        $sv_criteria->order = 'z.zone_prio DESC';
        $servers = $this->getCommandBuilder()
                ->createFindCommand($this->tableSchema, $sv_criteria)
                ->queryAll();
        $actual_servers = array();
        $prio = 0;
        if ($letter == '') {
            foreach ($servers as $server) {
                if ($server['zone_prio'] > $prio) {
                    $actual_servers = array();
                    $prio = $server['zone_prio'];
                }

                if ($server['zone_prio'] == $prio)
                    $actual_servers[] = $server;
            }
        } else {
            foreach ($servers as $server) {
                if ($server['zone_prio'] > $prio) {
                    if (($letter >= $server['server_letter'][0]) && ($letter <= $server['server_letter'][2])){
                        $actual_servers = array();
                        $prio = $server['zone_prio'];
                    }
                }
                if ($server['zone_prio'] == $prio) {
                    if (($letter >= $server['server_letter'][0]) && ($letter <= $server['server_letter'][2]))
                        $actual_servers[] = $server;
                }
            }
        }

        return $actual_servers;
    }

    /**
     *
     * @param string $lst_zones
     * @param int $group
     * @param string $letter
     * @return mixed
     */
    public function getClientServerString($lst_zones, $group, $letter) {

        $servers=$this->getClientServers($lst_zones, $group, $letter);
        if (count($servers)) {
        $server = $servers[array_rand($servers)];
        $server_string = 'http://' . $server['server_ip'] . ':' . $server['server_port'] . '/';
        //file_put_contents("/1.log",print_r($server_string,1));
          //file_put_contents("/1.log",print_r($server_string,1));
          //file_put_contents("/1.log",print_r($this->ip,1),FILE_APPEND);
        }
        return $server_string;
    }

    public function setActive($id,$active)
    {
            $sql='UPDATE {{servers}} set `server_is_active` = '.$active.' WHERE `server_id` ='.$id;
             return Yii::app()->db->createCommand($sql)->execute();
    }

}


?>
