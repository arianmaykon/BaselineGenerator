<?php

class vjGuardADSetSuperAdminTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArgument('username', sfCommandArgument::REQUIRED, 'Username of the user');

    $this->namespace        = 'vjGuardAD';
    $this->name             = 'set-super-admin';
    $this->briefDescription = 'Make a user super-admin';

    $this->detailedDescription = <<<EOF
Make a user super-admin. You have to give the username of the user.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    if(!$user=Doctrine::getTable('vjGuardADUser')->findOneByUsername($arguments['username']))
    {
      $error = <<<EOF
The user doesn't exist in the database !
EOF;
      $this->logBlock(array('', $error, ''), 'ERROR');
    }
    else
    {
      $user->setIsSuperAdmin(true);
      $user->save();
      $admin=Doctrine::getTable('vjGuardADUser')->findOneByUsername('admin');
      $admin->delete();
      $log = <<<EOF
The user %s is now a super administrator
EOF;
      $this->logSection('vjGuardAD', sprintf($log, $arguments['username']));
    }
  }
}
