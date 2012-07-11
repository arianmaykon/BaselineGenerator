<?php

/**
 * Baseline form base class.
 *
 * @method Baseline getObject() Returns the current form's model object
 *
 * @package    baselinegenerator
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBaselineForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'fk_system'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('System'), 'add_empty' => false)),
      'name'                 => new sfWidgetFormInputText(),
      'type'                 => new sfWidgetFormChoice(array('choices' => array('Teste' => 'Teste', 'Release' => 'Release'))),
      'publishToFTP'         => new sfWidgetFormInputCheckbox(),
      'sendMail'             => new sfWidgetFormInputCheckbox(),
      'sendAvailabilityMail' => new sfWidgetFormInputCheckbox(),
      'issues'               => new sfWidgetFormTextarea(),
      'generatedAt'          => new sfWidgetFormDate(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
      'created_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'add_empty' => true)),
      'updated_by'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fk_system'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('System'))),
      'name'                 => new sfValidatorString(array('max_length' => 255)),
      'type'                 => new sfValidatorChoice(array('choices' => array(0 => 'Teste', 1 => 'Release'), 'required' => false)),
      'publishToFTP'         => new sfValidatorBoolean(array('required' => false)),
      'sendMail'             => new sfValidatorBoolean(array('required' => false)),
      'sendAvailabilityMail' => new sfValidatorBoolean(array('required' => false)),
      'issues'               => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'generatedAt'          => new sfValidatorDate(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
      'created_by'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedBy'), 'required' => false)),
      'updated_by'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UpdatedBy'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('baseline[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Baseline';
  }

}
