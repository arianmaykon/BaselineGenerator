<?php

require_once dirname(__FILE__).'/../lib/vjGuardADGroupGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/vjGuardADGroupGeneratorHelper.class.php';

/**
 * vjGuardADGroup actions.
 *
 * @package    vjGuardADPlugin
 * @subpackage vjGuardADGroup
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class vjGuardADGroupActions extends autoVjGuardADGroupActions
{  
  public function executeActivate(sfWebRequest $request) {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
    $obj = $this->getRoute()->getObject();
    $obj->setIsActivated(true);
    if($obj->trySave())
      $this->getUser()->setFlash('notice', __('Group activated.', array(), 'vjGuardAD'));
    else
      $this->getUser()->setFlash('error', __('Group not activated.', array(), 'vjGuardAD'));
    $this->redirect("@vjGuardADGroup");
  }
  public function executeDesactivate(sfWebRequest $request) {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
    $obj = $this->getRoute()->getObject();
    $obj->setIsActivated(false);
    if($obj->trySave())
      $this->getUser()->setFlash('notice', __('Group deactivated.', array(), 'vjGuardAD'));
    else
      $this->getUser()->setFlash('error', __('Group not deactivated.', array(), 'vjGuardAD'));
    $this->redirect("@vjGuardADGroup");
  }

}
