<?php

class Signature{

  private $secret;

  function __construct($sharedSecret){
    $this->secret = $sharedSecret;
  }

  private function validateRequest($request){
    if(!(is_array($request) && array_key_exists("signature",$request))) return false;
    $signature = $request['signature'];
    if(!(array_key_exists('signed',$signature)&&array_key_exists('token',$signature)&&array_key_exists('nonce',$signature)))return false;
    return true;
  }

  private function recreateToken($request, $keys){
      $signingString = "";
      foreach ($keys as $key) {
        $signingString .= @$request[$key];
      }
      $signingString .= $request['signature']['nonce'] . $this->secret;
      return sha1($signingString);
  }

  public function validateSignature($request){
      if (!($this->validateRequest($request)))return false;
      $keys = preg_split("/,/",$request['signature']['signed']);
      return $request['signature']['token'] == $this->recreateToken($request,$keys);
  }

  public function generateSignature(&$requestArray,$nonce){
      $signed = $signingString ="";
      foreach ($requestArray as $k => $v) {
        $signed .= $k;
        $signingString .= $v;
      }
      $token = sha1($signingString . $nonce . $this->secret);
      $requestArray['signature'] = array(
                                        "nonce" => $nonce,
                                        "signed" => $signed,
                                        "token" => $token
                                  );
  }
}
