<?php

/**
 * BasevjGuardADGroupPermission
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $group_id
 * @property integer $permission_id
 * @property vjGuardADGroup $vjGuardADGroup
 * @property vjGuardADPermission $vjGuardADPermission
 * 
 * @method integer                  getGroupId()             Returns the current record's "group_id" value
 * @method integer                  getPermissionId()        Returns the current record's "permission_id" value
 * @method vjGuardADGroup           getVjGuardADGroup()      Returns the current record's "vjGuardADGroup" value
 * @method vjGuardADPermission      getVjGuardADPermission() Returns the current record's "vjGuardADPermission" value
 * @method vjGuardADGroupPermission setGroupId()             Sets the current record's "group_id" value
 * @method vjGuardADGroupPermission setPermissionId()        Sets the current record's "permission_id" value
 * @method vjGuardADGroupPermission setVjGuardADGroup()      Sets the current record's "vjGuardADGroup" value
 * @method vjGuardADGroupPermission setVjGuardADPermission() Sets the current record's "vjGuardADPermission" value
 * 
 * @package    baselinegenerator
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasevjGuardADGroupPermission extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vj_guard_a_d_group_permission');
        $this->hasColumn('group_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('permission_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('vjGuardADGroup', array(
             'local' => 'group_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('vjGuardADPermission', array(
             'local' => 'permission_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}