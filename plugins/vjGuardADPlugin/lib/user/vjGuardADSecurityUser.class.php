<?php

class vjGuardADSecurityUser extends sfBasicSecurityUser
{
  private $user = null;

  public function getVjGuardADUser()
  {
    if (!$this->user && $id = $this->getAttribute('user_id', null, 'vjSecurityUser'))
    {
      $this->user = Doctrine::getTable('vjGuardADUser')->find($id);

      if (!$this->user)
      {
        $this->logoutMessage('error', 'L\'utilisateur n\'existe plus en base de données.');
      }
    }

    return $this->user;
  }

  public function hasGroup($name)
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->hasGroup($name) : false;
  }

  public function getGroups()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getGroups() : array();
  }

  public function getGroupNames()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getGroupNames() : array();
  }

  public function hasPermission($name)
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->hasPermission($name) : false;
  }

  public function getPermissions()
  {
    return $this->getVjGuardADUser()->getPermissions();
  }

  public function getPermissionNames()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getPermissionNames() : array();
  }

  public function getAllPermissions()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getAllPermissions() : array();
  }

  public function getAllPermissionNames()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getAllPermissionNames() : array();
  }

  public function hasCredential($credential, $useAnd = true)
  {
    if (!$this->getVjGuardADUser())
    {
      return false;
    }

    if ($this->getVjGuardADUser()->getIsSuperAdmin())
    {
      return true;
    }

    return parent::hasCredential($credential, $useAnd);
  }

  public function isSuperAdmin()
  {
    return $this->getVjGuardADUser() ? $this->getVjGuardADUser()->getIsSuperAdmin() : false;
  }

  public function isSuperAdminLocal($username, $password)
  {
    if($password!="admin" || !is_object(Doctrine::getTable('vjGuardADUser')->findOneByGuidAndUsername('admin', $username)))
    {
      return false;
    }
    return true;
  }

  public function loginOrMessage($username, $message)
  {
    $user = Doctrine::getTable('vjGuardADUser')->findOneByUsername($username);
    if(is_object($user))
    {
      $this->setAttribute('user_id', $user->getId(), 'vjSecurityUser');
      $this->setAttribute('username', $username, 'vjSecurityUser');
      if(!$this->isSuperAdminLocal($username, $user->getGuid()))
        $this->setAttribute('user_dn', ad::getDisplayname($user->getUsername()), 'vjSecurityUser');
      $this->offsetUnset('login');
      $this->clearCredentials();
      $this->setAuthenticated(true);
      $this->addCredentials($user->getAllPermissionNames());
    }
    else
    {
      $this->logoutMessage('error', $message);
    }
  }
  
  public function logout()
  {
    $this->getAttributeHolder()->removeNamespace('vjSecurityUser');
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);
  }
  
  public function logoutMessage($type,$message)
  {
    $this->logout();
    $this->setFlash($type, $message);
  }
  
  public function setLogin()
  {
    $this->setAttribute('login','ok');
  }
  
  public function hasLogin()
  {
    if($this->hasAttribute('login')){
      $this->logout();
      return true;
    }else{
      return false;
    }
  }
  
  public function hasUsername()
  {
    if($this->hasAttribute('username'))
      return true;
    else
      return false;
  }
  
  public function hasFlashes()
  {
    if($this->hasFlash('notice') || $this->hasFlash('error'))
      return true;
    else
      return false;
  }

}
