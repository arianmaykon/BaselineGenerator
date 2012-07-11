<?php

/**
 * BasevjGuardADUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $guid
 * @property string $username
 * @property boolean $is_super_admin
 * @property Doctrine_Collection $groups
 * @property Doctrine_Collection $permissions
 * @property Doctrine_Collection $vjGuardADUserPermission
 * @property Doctrine_Collection $vjGuardADUserGroup
 * 
 * @method string              getGuid()                    Returns the current record's "guid" value
 * @method string              getUsername()                Returns the current record's "username" value
 * @method boolean             getIsSuperAdmin()            Returns the current record's "is_super_admin" value
 * @method Doctrine_Collection getGroups()                  Returns the current record's "groups" collection
 * @method Doctrine_Collection getPermissions()             Returns the current record's "permissions" collection
 * @method Doctrine_Collection getVjGuardADUserPermission() Returns the current record's "vjGuardADUserPermission" collection
 * @method Doctrine_Collection getVjGuardADUserGroup()      Returns the current record's "vjGuardADUserGroup" collection
 * @method vjGuardADUser       setGuid()                    Sets the current record's "guid" value
 * @method vjGuardADUser       setUsername()                Sets the current record's "username" value
 * @method vjGuardADUser       setIsSuperAdmin()            Sets the current record's "is_super_admin" value
 * @method vjGuardADUser       setGroups()                  Sets the current record's "groups" collection
 * @method vjGuardADUser       setPermissions()             Sets the current record's "permissions" collection
 * @method vjGuardADUser       setVjGuardADUserPermission() Sets the current record's "vjGuardADUserPermission" collection
 * @method vjGuardADUser       setVjGuardADUserGroup()      Sets the current record's "vjGuardADUserGroup" collection
 * 
 * @package    baselinegenerator
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasevjGuardADUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('vj_guard_a_d_user');
        $this->hasColumn('guid', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 32,
             ));
        $this->hasColumn('username', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_super_admin', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));

        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('vjGuardADGroup as groups', array(
             'refClass' => 'vjGuardADUserGroup',
             'local' => 'user_id',
             'foreign' => 'group_id'));

        $this->hasMany('vjGuardADPermission as permissions', array(
             'refClass' => 'vjGuardADUserPermission',
             'local' => 'user_id',
             'foreign' => 'permission_id'));

        $this->hasMany('vjGuardADUserPermission', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('vjGuardADUserGroup', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}