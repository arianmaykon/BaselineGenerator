<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createForeignKey('baseline', 'baseline_created_by_sf_guard_user_id', array(
             'name' => 'baseline_created_by_sf_guard_user_id',
             'local' => 'created_by',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             ));
        $this->createForeignKey('baseline', 'baseline_updated_by_sf_guard_user_id', array(
             'name' => 'baseline_updated_by_sf_guard_user_id',
             'local' => 'updated_by',
             'foreign' => 'id',
             'foreignTable' => 'sf_guard_user',
             ));
        $this->addIndex('baseline', 'baseline_created_by', array(
             'fields' => 
             array(
              0 => 'created_by',
             ),
             ));
        $this->addIndex('baseline', 'baseline_updated_by', array(
             'fields' => 
             array(
              0 => 'updated_by',
             ),
             ));
    }

    public function down()
    {
        $this->dropForeignKey('baseline', 'baseline_created_by_sf_guard_user_id');
        $this->dropForeignKey('baseline', 'baseline_updated_by_sf_guard_user_id');
        $this->removeIndex('baseline', 'baseline_created_by', array(
             'fields' => 
             array(
              0 => 'created_by',
             ),
             ));
        $this->removeIndex('baseline', 'baseline_updated_by', array(
             'fields' => 
             array(
              0 => 'updated_by',
             ),
             ));
    }
}