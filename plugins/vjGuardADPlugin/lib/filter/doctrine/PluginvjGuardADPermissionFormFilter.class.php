<?php

/**
 * vjGuardADPermission filter form.
 *
 * @package    filters
 * @subpackage vjGuardADPermission *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
abstract class PluginvjGuardADPermissionFormFilter extends BasevjGuardADPermissionFormFilter
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    unset($this['created_at'],$this['updated_at']);
  }
}