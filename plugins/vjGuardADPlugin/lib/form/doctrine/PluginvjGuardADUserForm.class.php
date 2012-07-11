<?php

/**
 * vjGuardADUser form.
 *
 * @package    form
 * @subpackage vjGuardADUser
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginvjGuardADUserForm extends BasevjGuardADUserForm
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    sfProjectConfiguration::getActive()->loadHelpers('Url');
    unset($this['created_at'],$this['updated_at'], $this['username'], $this['is_super_admin'], $this['permissions_list']);
    if($this->isNew())
      $this->widgetSchema['guid'] = new sfWidgetFormJQueryAutocompleter(array('url' => url_for("@vjGuardADUserAjax")));
    else
      $this->widgetSchema['guid'] = new sfWidgetFormInputHidden(array(), array('value'=> $this->getObject()->getGuid()));
  }
}