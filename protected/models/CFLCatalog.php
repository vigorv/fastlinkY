<?php

/**
 * This is the model class for table "{{catalog}}".
 *
 * The followings are the available columns in table '{{catalog}}':
 * @property string $id
 * @property string $user_id
 * @property string $email
 * @property string $title
 * @property string $original_name
 * @property string $name
 * @property string $comment
 * @property string $group
 * @property string $dt
 * @property integer $is_visible
 * @property integer $is_confirm
 * @property string $dir
 * @property string $sgroup
 * @property string $tp
 * @property string $sz
 * @property string $vtp
 * @property string $chk_md5
 */
class CFLCatalog extends CActiveRecord {

    /**
     * @static
     * @param string $className
     * @return CFLCatalog
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{catalog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, original_name, name, group, dt, dir', 'required'),
            array('is_visible, is_confirm', 'numerical', 'integerOnly' => true),
            array('user_id, group, sgroup, tp, vtp', 'length', 'max' => 10),
            array('sz','length','max'=>20),
            array('email', 'length', 'max' => 100),
            array('title, original_name, name, dir', 'length', 'max' => 255),
            array('chk_md5', 'length', 'max' => 32),
            array('comment', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, email, title, original_name, name, comment, group, dt, is_visible, is_confirm, dir, sgroup, tp, sz, vtp, chk_md5', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'user_id' => 'User',
            'email' => 'Email',
            'title' => 'Title',
            'original_name' => 'Original Name',
            'name' => 'Name',
            'comment' => 'Comment',
            'group' => 'Group',
            'dt' => 'Dt',
            'is_visible' => 'Is Visible',
            'is_confirm' => 'Is Confirm',
            'dir' => 'Dir',
            'sgroup' => 'Sgroup',
            'tp' => 'Tp',
            'sz' => 'Sz',
            'vtp' => 'Vtp',
            'chk_md5' => 'Chk Md5',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('original_name', $this->original_name, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('`group`', $this->group, true);
        $criteria->compare('dt', $this->dt, true);
        $criteria->compare('is_visible', $this->is_visible);
        $criteria->compare('is_confirm', $this->is_confirm);
        $criteria->compare('dir', $this->dir, true);
        $criteria->compare('sgroup', $this->sgroup, true);
        $criteria->compare('tp', $this->tp, true);
        $criteria->compare('sz', $this->sz, true);
        $criteria->compare('vtp', $this->vtp, true);
        $criteria->compare('chk_md5', $this->chk_md5, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => Yii::app()->params['admin_items_per_page']),
                        )
        );
    }

    public function getFullColumnsList() {
        return Yii::app()->db->cache(20)->createCommand('SHOW FULL COLUMNS FROM ' . $this->tableName())->queryAll();
    }

    public function SearchByTitle($query, CPagination &$pages, $sphinx_search = true) {
        if ($sphinx_search) {
            $criteria = new stdClass();

            $pages->itemCount = 1000;
            //$pages->applyLimit($criteria);
            //$criteria->condition = array('Catalog.is_confirm' => 1, 'Catalog.is_visible' => 1);

            $criteria->query = $query;
            $criteria->paginator = $pages;

            $criteria->from = 'fastlink_catalog';


            $search = Yii::App()->search->
                    // setArrayResult(false)->
                    setMatchMode(SPH_MATCH_ALL);
            $search->setLimits($pages->offset, 1000, 1000);
            $search->SetSortMode(SPH_SORT_EXTENDED, '@relevance DESC');
            $res = $search->searchRaw($criteria); // array result
            if (count($res['matches'])) {
                $ids = implode(array_keys($res['matches']), ',');
                $result = $this->findAll('id in (' . $ids . ')');
            }else
                $result = array();

            return $result;
        } else {
            // $itemCount=0;
            $itemCount = Yii::app()->db->createCommand('SELECT count(*) FROM {{catalog}} WHERE (name LIKE "%' . $query . '%") OR (title LIKE "%' . $query . '%") GROUP BY `group`,`sgroup` LIMIT 100')->query()->count();
            $pages->itemCount = $itemCount;
            return
                            Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('{{catalog}}')
                            ->where('(name LIKE "%' . $query . '%") OR (title LIKE "%' . $query . '%") GROUP BY `group`,`sgroup` ')
                            ->limit($pages->limit, $pages->offset)
                            ->queryAll();
        }
    }

    /**
     * Actually for only default zone
     * @param string $query
     * @param CPagination $pages
     * @param int $zone
     * @param bool $sphinx_search
     * @return mixed
     */
    public function SearchByTitleInZone($query, CPagination &$pages, $zone, $sphinx_search = true) {
        if (false) {
            //if ($sphinx_search) {
            $criteria = new stdClass();

            $pages->itemCount = 1000;
            //$pages->applyLimit($criteria);
            //$criteria->condition = array('Catalog.is_confirm' => 1, 'Catalog.is_visible' => 1);

            $criteria->query = $query;
            $criteria->paginator = $pages;

            $criteria->from = 'fastlink_catalog';


            $search = Yii::App()->search->
                    // setArrayResult(false)->
                    setMatchMode(SPH_MATCH_ALL);
            $search->setLimits($pages->offset, 1000, 1000);
            $search->SetSortMode(SPH_SORT_EXTENDED, '@relevance DESC');
            $res = $search->searchRaw($criteria); // array result

            $ids = implode(array_keys($res['matches']), ',');
            $result = $this->findAll('id in (' . $ids . ')');

            return $result;
        } else {
            $pages->itemCount = Yii::app()->db->createCommand()
                    ->select('COUNT(*)')
                    ->from('{{catalog}} cg')
                    ->join('{{servers}} srv', ' ((srv.server_group = cg.sgroup) AND (srv.server_is_active = 1) AND (srv.zone_id =' . $zone . '))')
                    ->where('(cg.title LIKE "%' . $query . '%") OR (cg.name LIKE "%' . $query . '%")')
                    ->queryScalar();


            return Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('{{catalog}} cg')
                            ->join('{{servers}} srv', ' ((srv.server_group = cg.sgroup) AND (srv.server_is_active = 1) AND (srv.zone_id =' . $zone . '))')
                            ->where('(cg.title LIKE "%' . $query . '%") OR (cg.name LIKE "%' . $query . '%")')
                            ->limit($pages->limit, $pages->offset)
                            ->queryAll();
        }
    }

    public function SearchByGroup($query, $sgroup = false, $gtype = false) {
        if (!$sgroup)
            return $this->cache(100)->findAllByAttributes(array('group' => $query));
        else
        if ($gtype === false)
            return $this->cache(100)->findAllByAttributes(array('group' => $query, 'sgroup' => (int) $sgroup));
        else
            return $this->cache(100)->findAllByAttributes(array('group' => $query, 'sgroup' => (int) $sgroup, 'tp' => (int) $gtype));
    }

    public function setGid($gid,$lst_id){
        $sql='UPDATE {{catalog}} set `group` = '.$gid.' WHERE `id` in ("' . $lst_id . '")';
         //$sql;
        return Yii::app()->db->createCommand($sql)->execute();
    }
    public function FreeGidNotInListGid($gid, $lst_id, $sg=2){
        if ($sg==2){
            $sql='UPDATE {{catalog}} set `group` = 0 WHERE (`id` NOT in ("' . $lst_id . '")) AND (`group` ='.(int)$gid.') AND (`sgroup` in (2,6))';
        } else
            $sql='UPDATE {{catalog}} set `group` = 0 WHERE (`id` NOT in ("' . $lst_id . '")) AND (`group` ='.(int)$gid.') AND (`sgroup` = '.$sg.')';
        //$sql;
        return Yii::app()->db->createCommand($sql)->execute();
    }

}