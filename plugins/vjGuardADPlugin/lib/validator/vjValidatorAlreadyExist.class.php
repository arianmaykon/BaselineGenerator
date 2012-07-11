<?php
class vjValidatorAlreadyExist extends sfValidatorBase
{

  protected function configure($options = array(), $messages = array())
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
    $this->addMessage('already_exist', __("`%value%` group already exist. Please choose another name.", array(), 'vjGuardAD'));
    $this->addMessage('not_allowed', __("`%value%` group can't be create. Please choose another name.", array(), 'vjGuardAD'));

    $this->addOption('already_exist');
    $this->addOption('not_allowed');
  }

  /**
   * @see sfValidatorBase
   */
  protected function doClean($value)
  {
    $ad = ad::initAD();
    $infos = $ad->group_info($value);
    if($infos['count'] > 0)
    {
      throw new sfValidatorError($this, 'already_exist', array('value' => $value, 'already_exist' => $this->getOption('already_exist')));
    }
    
    $not_allowed = sfConfig::get('app_ad_group_not_allowed');
    if($not_allowed!==false && in_array($value, $not_allowed))
    {
      throw new sfValidatorError($this, 'not_allowed', array('value' => $value, 'not_allowed' => $this->getOption('not_allowed')));
    }

    return $value;
  }
}
