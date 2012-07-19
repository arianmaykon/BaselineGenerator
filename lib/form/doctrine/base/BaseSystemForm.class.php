<?php

/**
 * System form base class.
 *
 * @method System getObject() Returns the current form's model object
 *
 * @package    baselinegenerator
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSystemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                          => new sfWidgetFormInputHidden(),
      'name'                        => new sfWidgetFormInputText(),
      'acronym'                     => new sfWidgetFormInputText(),
      'jiraComponent'               => new sfWidgetFormInputText(),
      'dependencies'                => new sfWidgetFormInputText(),
      'svnCopyFolder'               => new sfWidgetFormInputText(),
      'ftpPath'                     => new sfWidgetFormInputText(),
      'releaseUrl'                  => new sfWidgetFormInputText(),
      'testUrl'                     => new sfWidgetFormInputText(),
      'sourceFolderCompressionType' => new sfWidgetFormChoice(array('choices' => array('zip' => 'zip', 'tar.gz' => 'tar.gz'))),
      'created_at'                  => new sfWidgetFormDateTime(),
      'updated_at'                  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                        => new sfValidatorString(array('max_length' => 255)),
      'acronym'                     => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'jiraComponent'               => new sfValidatorString(array('max_length' => 30)),
      'dependencies'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'svnCopyFolder'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ftpPath'                     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'releaseUrl'                  => new sfValidatorString(array('max_length' => 255)),
      'testUrl'                     => new sfValidatorString(array('max_length' => 255)),
      'sourceFolderCompressionType' => new sfValidatorChoice(array('choices' => array(0 => 'zip', 1 => 'tar.gz'), 'required' => false)),
      'created_at'                  => new sfValidatorDateTime(),
      'updated_at'                  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'System', 'column' => array('jiraComponent')))
    );

    $this->widgetSchema->setNameFormat('system[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'System';
  }

}
