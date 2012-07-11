<?php

/**
 * vjGuardADAuth form.
 *
 * @package    form
 * @subpackage vjGuardADAuth
 */
class vjGuardADAuthFormLogin extends BaseForm
{
  public function configure()
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
    sfValidatorBase::setDefaultMessage('required', __('Required.', array(), 'vjGuardAD'));
    sfValidatorBase::setDefaultMessage('invalid', __('Invalid.', array(), 'vjGuardAD'));
    $this->setWidgets(array(
      'login'                 => new sfWidgetFormInputText(),
      'password'              => new sfWidgetFormInputPassword()
    ));
    $this->widgetSchema->setNameFormat('login[%s]');
    $this->widgetSchema->setLabels(array(
      'login'    => __('Login', array(), 'vjGuardAD'),
      'password'   => __('Password', array(), 'vjGuardAD'),
    ));

    $this->setValidators(array(
      'login'                 => new sfValidatorString(array('required' => true)),
      'password'              => new sfValidatorString(array('required' => true)),
    ));


    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}