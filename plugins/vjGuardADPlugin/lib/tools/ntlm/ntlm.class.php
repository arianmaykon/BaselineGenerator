<?php

class NTLM{

  public function __construct()
  {
    ini_set('display_errors',1);
    error_reporting(E_ALL | E_STRICT);
  }

  public function __destruct()
  {
    ini_set('display_errors',0);
  }
 
  public function getInfosFromNTLM() {
   
    if (!empty($_SERVER['HTTP_VIA'])) {
      echo "HTTP_VIA";
      return 2;
    }
   
    $header = apache_request_headers();
    $auth = isset($header['Authorization']) ? $header['Authorization'] : null;
   
    if (is_null($auth)) {
      return $this->unAuthorized();
    }
   
    if ($auth && (substr($auth,0,4) == 'NTLM')) {
   
      $c64 = base64_decode(substr($auth,5));
      $state = ord($c64{8});
   
      switch ($state) {
   
        case 1:
          $chrs = array(0,2,0,0,0,0,0,0,0,40,0,0,0,1,130,0,0,0,2,2,2,0,0,0,0,0,0,0,0,0,0,0,0);
          $ret = "NTLMSSP";
          foreach ($chrs as $chr) {
            $ret .= chr($chr);
          }
          return $this->unAuthorized(trim(base64_encode($ret)));
          break;
   
        case 3:
          $l = ord($c64{31}) * 256 + ord($c64{30});
          $o = ord($c64{33}) * 256 + ord($c64{32});
          $domain = str_replace("\0","",substr($c64,$o,$l));
          
          $l = ord($c64{39}) * 256 + ord($c64{38});
          $o = ord($c64{41}) * 256 + ord($c64{40});
          $user = str_replace("\0","",substr($c64,$o,$l));
          return $user;
   
          break;
      }
   
    }
  }
 
  public function unAuthorized($msg=null) {
    $ntlm = 'WWW-Authenticate: NTLM';
    if ($msg) {
      $ntlm .= ' '.$msg;
    }
    header('HTTP1.0 401 Unauthorized');
    header($ntlm);
   
    return 1;
  }
}
?>