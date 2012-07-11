<?php

/**
 * vjGuardADGroup form base class.
 *
 * @method vjGuardADGroup getObject() Returns the current form's model object
 *
 * @package    baselinegenerator
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasevjGuardADGroupForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'guid'             => new sfWidgetFormInputText(),
      'name'             => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'is_activated'     => new sfWidgetFormInputCheckbox(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'users_list'       => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADUser')),
      'permissions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADPermission')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'guid'             => new sfValidatorString(array('max_length' => 32, 'required' => false)),
      'name'             => new sfValidatorString(array('max_length' => 255)),
      'description'      => new sfValidatorString(array('max_length' => 1000, 'required' => false)),
      'is_activated'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'users_list'       => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADUser', 'required' => false)),
      'permissions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'vjGuardADPermission', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'vjGuardADGroup', 'column' => array('guid'))),
        new sfValidatorDoctrineUnique(array('model' => 'vjGuardADGroup', 'column' => array('name'))),
      ))
    );

    $this->widgetSchema->setNameFormat('vj_guard_ad_group[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'vjGuardADGroup';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['users_list']))
    {
      $this->setDefault('users_list', $this->object->users->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['permissions_list']))
    {
      $this->setDefault('permissions_list', $this->object->permissions->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveusersList($con);
    $this->savepermissionsList($con);

    parent::doSave($con);
  }

  public function saveusersList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['users_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->users->getPrimaryKeys();
    $values = $this->getValue('users_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('users', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('users', array_values($link));
    }
  }

  public function savepermissionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['permissions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->permissions->getPrimaryKeys();
    $values = $this->getValue('permissions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('permissions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('permissions', array_values($link));
    }
  }

}
