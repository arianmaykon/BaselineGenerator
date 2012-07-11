<?php

/**
 * vjGuardADUserGroup form.
 *
 * @package    form
 * @subpackage vjGuardADUserGroup
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginvjGuardADUserGroupForm extends BasevjGuardADUserGroupForm
{
  /*public function setupInheritance()
  {
    parent::setupInheritance();
    $this->widgetSchema['grp_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'vjGroup', 'multiple' => true));
    $this->validatorSchema['grp_id'] = new sfValidatorDoctrineChoice(array('model' => 'vjGroupPermission', 'column' => 'grp_id', 'required' => false));
  }*/
}