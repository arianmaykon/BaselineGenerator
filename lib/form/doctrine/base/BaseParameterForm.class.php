<?php

/**
 * Parameter form base class.
 *
 * @method Parameter getObject() Returns the current form's model object
 *
 * @package    baselinegenerator
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseParameterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'jiraBaseUrl'             => new sfWidgetFormInputText(),
      'svnBaseUrl'              => new sfWidgetFormInputText(),
      'ftpHost'                 => new sfWidgetFormInputText(),
      'ftpUser'                 => new sfWidgetFormInputText(),
      'ftpPassword'             => new sfWidgetFormInputText(),
      'ftpPort'                 => new sfWidgetFormInputText(),
      'testBaselineMailBody'    => new sfWidgetFormTextarea(),
      'releaseBaselineMailBody' => new sfWidgetFormTextarea(),
      'availabilityMailBody'    => new sfWidgetFormTextarea(),
      'created_at'              => new sfWidgetFormDateTime(),
      'updated_at'              => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'jiraBaseUrl'             => new sfValidatorString(array('max_length' => 255)),
      'svnBaseUrl'              => new sfValidatorString(array('max_length' => 255)),
      'ftpHost'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ftpUser'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ftpPassword'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ftpPort'                 => new sfValidatorInteger(array('required' => false)),
      'testBaselineMailBody'    => new sfValidatorString(array('required' => false)),
      'releaseBaselineMailBody' => new sfValidatorString(array('required' => false)),
      'availabilityMailBody'    => new sfValidatorString(array('required' => false)),
      'created_at'              => new sfValidatorDateTime(),
      'updated_at'              => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('parameter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Parameter';
  }

}
