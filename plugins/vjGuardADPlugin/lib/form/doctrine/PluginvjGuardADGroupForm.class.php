<?php

/**
 * PluginvjGuardADGroup form.
 *
 * @package    form
 * @subpackage PluginvjGuardADGroup
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginvjGuardADGroupForm extends BasevjGuardADGroupForm
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    unset($this['created_at'],$this['updated_at'], $this['guid'], $this['is_activated']);
    if(!$this->isNew())
      $this->widgetSchema['name'] = new sfWidgetFormInputHidden(array(), array('value'=> $this->getObject()->getName()));
    else
      $this->validatorSchema['name'] = new vjValidatorAlreadyExist();
  }
}