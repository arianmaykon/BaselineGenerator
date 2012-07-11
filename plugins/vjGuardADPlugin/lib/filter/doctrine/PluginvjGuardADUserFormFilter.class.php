<?php

/**
 * PluginvjGuardADUser filter form.
 *
 * @package    filters
 * @subpackage PluginvjGuardADUser *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
abstract class PluginvjGuardADUserFormFilter extends BasevjGuardADUserFormFilter
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    sfProjectConfiguration::getActive()->loadHelpers('Url');
    unset($this['created_at'], $this['updated_at'], $this['is_super_admin'], $this['username'], $this['guid'], $this['permissions_list']);
  }
}