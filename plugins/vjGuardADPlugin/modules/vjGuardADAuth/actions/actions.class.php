<?php

class vjGuardADAuthActions extends sfActions
{
  public function preExecute()
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('I18N'));
  }

  public function executeLogin(sfWebRequest $request)
  {
    $this->group_authorize = ad::getGroupAuthorized();
    $ad = new adLDAP(sfConfig::get('app_ad_options'));
    $user = $this->getUser();
    
    if(!$user->isAuthenticated()){
      $this->form = new vjGuardADAuthFormLogin();
      if($request->isMethod('post')){
        $this->form->bind($request->getParameter('login'));
        if ($this->form->isValid()){
          $tLogin = $request->getParameter('login');
          if($ad->authenticate($tLogin['login'],$tLogin['password']) || $user->isSuperAdminLocal($tLogin['login'],$tLogin['password'])){
            $this->login=$tLogin['login'];
            $this->password = $tLogin['password'];
          }else{
            $user->logoutMessage("error",__('Incorrect login or password.', array(), 'vjGuardAD'));
          }
        }
      }else{
        if(sfConfig::get('app_ad_ntlm_active') && !$user->hasFlashes())
        {
          $this->redirect("@vjGuardADAuthLoginNtlm");
        }
        if(sfConfig::get('app_ad_kerberos_active') && !$user->hasFlashes())
        {
          $this->login = kerberos::getInfosFromKerberos();
          $this->password = null;

        }
      }
      if($this->login!=""){
        if($ad->user_ingroup($this->login,$this->group_authorize) || $user->isSuperAdminLocal($this->login,$this->password)){
          $user->loginOrMessage($this->login, "Votre compte ne dispose pas des autorisations suffisantes pour se connecter");
          $this->redirect('@homepage');
        }else{
          $user->logoutMessage("error",__('Access denied!', array(), 'vjGuardAD'));
        }
      }
    }else{
      $this->redirect('@homepage');
    }
  }
  
  public function executeNtlm(sfWebRequest $request)
  {
    $ntlm = new NTLM();
    $this->login = $ntlm->getInfosFromNTLM();
    $this->group_authorize = ad::getGroupAuthorized();
    $ad = new adLDAP(sfConfig::get('app_ad_options'));
    $user = $this->getUser();

    if(!$user->isAuthenticated()){
      if($this->login!=""){
        if(!$user->hasLogin()){
          $this->msg = "Authentification en cours pour ".$this->login." ...";
          $user->setLogin();
          unset($ntlm);
          $this->redirect('@vjGuardADAuthLoginNtlm');
        }else{
          $this->msg = "Authentification accomplie !";
          if($ad->user_ingroup($this->login,$this->group_authorize)){
            $this->msg .= "<br />Connexion en cours";
            $user->loginOrMessage($this->login, __('Access denied!', array(), 'vjGuardAD'));
            unset($ntlm);
            $this->redirect('@homepage');
          }else{
            $user->logoutMessage("error",__('Access denied!', array(), 'vjGuardAD'));
            unset($ntlm);
            $this->redirect('@vjGuardADAuthLogin');
          }
        }
      }
    }else{
      unset($ntlm);
      $this->redirect('@homepage');
    }
  }
  
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->logoutMessage("notice",__('Disconnected.', array(), 'vjGuardAD'));
    $this->redirect('@vjGuardADAuthLogin');
  }

  public function executeSecure()
  {
    $this->getResponse()->setStatusCode(403);
  }
}
