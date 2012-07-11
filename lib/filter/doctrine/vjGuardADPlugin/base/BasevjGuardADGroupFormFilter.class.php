<?php

/**
 * vjGuardADGroup filter form base class.
 *
 * @package    baselinegenerator
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasevjGuardADGroupFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'guid'             => new sfWidgetFormFilterInput(),
      'name'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'description'      => new sfWidgetFormFilterInput(),
      'is_activated'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'users_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADUser')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADPermission')),
    ));

    $this->setValidators(array(
      'guid'             => new sfValidatorPass(array('required' => false)),
      'name'             => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'is_activated'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'users_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADUser', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADPermission', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('vj_guard_ad_group_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addUsersListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.vjGuardADUserGroup vjGuardADUserGroup')
      ->andWhereIn('vjGuardADUserGroup.user_id', $values)
    ;
  }

  public function addPermissionsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.vjGuardADGroupPermission vjGuardADGroupPermission')
      ->andWhereIn('vjGuardADGroupPermission.permission_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'vjGuardADGroup';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'guid'             => 'Text',
      'name'             => 'Text',
      'description'      => 'Text',
      'is_activated'     => 'Boolean',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'users_list'       => 'ManyKey',
      'permissions_list' => 'ManyKey',
    );
  }
}
