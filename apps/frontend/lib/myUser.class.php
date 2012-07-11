<?php

class myUser extends sfGuardSecurityUser
{
	/**
	 *
	 *
	 */
#	function checkLDAPPassword($username, $password) {
#	public function checkPassword($username, $password) {
	public function checkPassword($password) {
#		$user = LDAP::getUser($username);
#		if ($user->checkPassword($password)) {			
#			return true;
#		} else {
#			return false;
#		}
#		return $this->authenticateOnLdap($username, $password);
	}

	/**
	 * @param string $username
	 * @param string $password
	 */
	// private function authenticateOnLdap($username, $password) {
 //        return Util::getLdap()->authenticate(strtolower($username), $password);
 //    }
}