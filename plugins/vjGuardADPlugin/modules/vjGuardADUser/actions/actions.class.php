<?php

require_once dirname(__FILE__).'/../lib/vjGuardADUserGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/vjGuardADUserGeneratorHelper.class.php';

/**
 * vjGuardADUser actions.
 *
 * @package    vjGuardADPlugin
 * @subpackage vjGuardADUser
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class vjGuardADUserActions extends autoVjGuardADUserActions
{
  public function executeAjax(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $users = ad::setDnList($request->getParameter('q'));
    return $this->renderText(json_encode($users));
  }
}
