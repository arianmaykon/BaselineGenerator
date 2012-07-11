<?php

/**
 * vjGuardADPermission form.
 *
 * @package    form
 * @subpackage vjGuardADPermission
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginvjGuardADPermissionForm extends BasevjGuardADPermissionForm
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    unset($this['created_at'],$this['updated_at']);
  }
}