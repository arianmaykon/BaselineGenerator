<?php

/*
 * This file has been created the 27 nov. 2009 at 11:57:19
 */

/**
 * Description of ad
 *
 * @author    Jean-Philippe MORVAN <jp.morvan@ville-villejuif.fr>
 */
class ad
{

  public static function initAD() {
    return new adLDAP(sfConfig::get('app_ad_options'));
  }

  public static function getGroupAuthorized() {
    return sfConfig::get('app_ad_group_authorize');
  }

  public static function getMasterOu() {
    return sfConfig::get('app_ad_master_ou');
  }

  public static function getSecureGroupName() {
    return sfConfig::get('app_ad_secure_group_name');
  }

  public static function getGroupDn($group_name) {
    $ad = self::initAD();
    return $ad->group_info($group_name, array('distinguishedname'));
  }

  public static function getDnFromGroupAuthorized() {
    $dn = ad::getGroupDn(self::getGroupAuthorized());
    return $dn[0]['dn'];
  }

  public static function getOusFromGroupAuthorized() {
    $tOu = explode("OU=", self::getMasterOu());
    foreach ($tOu as $id => $ou) {
      $tOu[$id] = trim(strtr($ou, ",", " "));
    }
    array_shift($tOu);
    return array_reverse($tOu);
  }

  public static function user_info_field($user_info, $field)
  {
    if($user_info==NULL || !is_array($user_info) || !isset($user_info[0][$field])) return false;
    return $user_info[0][$field][0];
  }

  public static function createGroupInADAndReturnGuid($name, $desc) {
    if($desc=="")
      $desc = $name;
    $attributes =
      array(
        "group_name" => $name,
        "description" => $desc,
        "container" => self::getOusFromGroupAuthorized(),
      );
    $ad = self::initAD();
    $ad->group_create($attributes);
    $guid = $ad->group_info($name, array("objectguid"));
    return bin2hex($guid[0]['objectguid'][0]);
  }

  public static function getUsers($string, $users, $empty=false) {
    $liste = array();
    foreach($users as $user){
      if($empty===false){
        if(eregi($string, $user)){
          $liste[] = $user;
        }
      }else{
        $liste[] = $user;
      }
    }
    return $liste;
  }

  public static function getDisplayname($username) {
    $ad = self::initAD();
    $user_info = $ad->user_info($username, array("displayname"));
    return self::user_info_field($user_info,"displayname");
  }


  


  public static function getFromList($string, $empty=false) {
    $ad = self::initAD();
    $liste = self::getUsers($string, $ad->all_users(), $empty);
    $l = array();
    foreach($liste as $el){
      $info = $ad->user_info($el,array("displayname","objectguid","samaccountname"));
      $guid = bin2hex(self::user_info_field($info, "objectguid"));
      $samaccountname = self::user_info_field($info, "samaccountname");
      $dn = self::user_info_field($info, "displayname");
      $l[$guid] = array("dn" => $dn, "samaccountname" => $samaccountname);
    }
    return $l;
  }

  public static function setDnList($string, $empty=false) {
    $liste = ad::getFromList($string, $empty);
    $return = array();
    foreach ($liste as $guid => $t) {
      $return[$guid]= $t["dn"];
    }
    return $return;
  }

  public static function isUsernameAndGuidCorrect($username, $guid) {
    $ad = self::initAD();
    $user_info = $ad->user_info($username, array("objectguid"));
    $objectguid = bin2hex(self::user_info_field($user_info,"objectguid"));
    if($objectguid==$guid) return true;
    return false;
  }

  public static function getFromGuid($guid, $type="samaccountname") {
    foreach (self::getFromList("",true) as $id => $u) {
      if($id == $guid) return $u[$type];
    }
    return false;
  }
}
?>
