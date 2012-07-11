<?php

/**
 * vjGuardADGroup filter form.
 *
 * @package    filters
 * @subpackage vjGuardADGroup *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
abstract class PluginvjGuardADGroupFormFilter extends BasevjGuardADGroupFormFilter
{
  public function setupInheritance()
  {
    parent::setupInheritance();
    unset($this['created_at'],$this['updated_at'], $this['guid'], $this['is_activated']);
  }
}