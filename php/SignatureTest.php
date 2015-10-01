  <?php

  include "Signature.php";

  class TestSignature{

  private $sharedKey;

  function __construct(){
    $this->sharedKey = "TWFGC9YBBsj8FaQ%N4v6hmfzjXK6yqR6rEsvHfkLfwIUKCk@ngvWZ7CqBfC7G4I";
  }


  private function emulateRequest($method){
    $json = <<<JSON
  {
      "frontend": "9aho8o1bv2r7uqdtbpt7kq0l91",
      "signature": {
          "signed": "frontend",
          "nonce": "2GgVoa6pnjtZ4ozEKALjkuP1TAmSD9RJ",
          "token": "039957036d03477b557356a0897683165c33efdb"
      }
  }
JSON;

  $get = json_decode($json,true);

    $post = array(
      'user_id' => 12345,
      'email' => "mail@email.com",
      'phone' => "+919876543210",
  //12345mail@email.com+919876543210F6LAN4jmikVPqNllhwnHnEvtXH0obTY4TWFGC9YBBsj8FaQ%N4v6hmfzjXK6yqR6rEsvHfkLfwIUKCk@ngvWZ7CqBfC7G4I :: ee593183227fba4e5563f0b6543e35b036d2480a
  );
    return $$method;
  }

  public function TestShouldGenerateValidSignature(){
    $sign = new Signature($this->sharedKey);
    $post =$this->emulateRequest('post');
    $nonce = "F6LAN4jmikVPqNllhwnHnEvtXH0obTY4";
    $sign->generateSignature($post, $nonce);
    return @$post['signature']['token'] == "ee593183227fba4e5563f0b6543e35b036d2480a";

  }

  public function TestShouldValidateSignature(){
    $sign  =  new Signature($this->sharedKey);
    return $sign->validateSignature($this->emulateRequest('get')) == true; //accepts array with signature structure as mandatory
  }

  public static function main(){
    $test = new TestSignature();
    echo "\n-----------------------------------------------------------------\nExecuting Tests\n-----------------------------------------------------------------\n";
    echo $test->TestShouldGenerateValidSignature()? "\nPASS" : "\nFAIL";
    echo $test->TestShouldValidateSignature()? "\nPASS" : "\nFAIL";
    echo "\n";
  }

}

TestSignature::main();

?>
