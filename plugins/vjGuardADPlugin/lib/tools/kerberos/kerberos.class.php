<?php

/*
 * This file has been created the 31 déc. 2009 at 17:48:43
 */

/**
 * Description of kerberos
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 */
class kerberos
{
  public static function getInfosFromKerberos() {
    return substr($_SERVER['REMOTE_USER'],0,strpos($_SERVER['REMOTE_USER'],"@"));
  }
}
?>
