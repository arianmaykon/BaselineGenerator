<?php

class superAdminTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArgument('name', sfCommandArgument::OPTIONAL, 'Username of super admin', 'admin');

    $this->namespace        = 'vjGuardAD';
    $this->name             = 'create-super-admin';
    $this->briefDescription = 'Create a super-admin "local" for the application';

    $this->detailedDescription = <<<EOF
Create a super-admin "local" for the application.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    if(Doctrine::getTable('vjGuardADUser')->findOneByGuid('admin'))
    {
      $error = <<<EOF
The super administrator already exist ! You can't create a new one !
EOF;
      $this->logBlock(array('', $error, ''), 'ERROR');
    }
    else
    {
      $user = new vjGuardADUser();
      $user->setGuid('admin');
      $user->setUsername($arguments['name']);
      $user->setIsSuperAdmin(true);
      $user->save();
      $log = <<<EOF
Add user %s as a super administrator. Remove it when you've added a real user from Active Directory !
Login : %s
Password : admin
EOF;
      $this->logSection('vjGuardAD', sprintf($log, $arguments['name'], $arguments['name']));
    }
  }
}
