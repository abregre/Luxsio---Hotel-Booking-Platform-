<?php 

namespace Hotel;

use PDO;
use Hotel\BaseService;

class User extends BaseService
{

  const TOKEN_KEY = 'asfsadf.;asdfsadf';

  private static $currentUserId;

  public function getByEmail($email)
  {
    $params = [
      ':email' => $email,
    ];
    return $this->fetch('SELECT * FROM user WHERE email = :email',$params);
  
  }
  public function getByUserId($userId)
  {
    $params = [
      ':user_id' => $userId,
    ];
    return $this->fetch('SELECT * FROM user WHERE user_id = :user_id',$params);
  
  }


  public function getList()
  {
    return $this->fetchAll('SELECT * FROM user');
  }
  

  public function insert($name, $email, $pass)
  {
    //Hash pass
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    
    //Prepare
    $params = [
      ':name'=>$name,
      ':email'=>$email,
      ':password'=>$hash
    ];

    $rows = $this->execute('INSERT INTO user (name, email, password) VALUES (:name, :email, :password)',$params);

    return $rows == 1;
  }

  public function verifyPass($email, $pass)
  {
    //Retrieve User
    $user = $this->getByEmail($email);
    //Verify Pass 
    return password_verify($pass, $user['password']);
    
  }

  public function genToken($userId, $token = ''){
    
    //Create Token Payload
    $payload = [
      'user_id' => $userId,
      'csrf' => $token?:base64_encode(openssl_random_pseudo_bytes(32))
    ];
    $payloadEncoded= base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', $payloadEncoded, self::TOKEN_KEY);

    return sprintf('%s.%s', $payloadEncoded, $signature);

  }

  public static function getTokenPayload($token)
  {
    //Get Payload and signature
    [$payloadEncoded] = explode('.', $token);

    //Get Payload
    return json_decode(base64_decode($payloadEncoded), true);
  }
  
  public function verifyToken($token)
  {
    //Get payload
    $payload = $this->getTokenPayload($token);
    $userId = $payload['user_id'];
    $csrf = $payload['csrf'];

    //Generate signature and verify
    return $this->genToken($userId, $csrf) == $token;
    
  }
  public static function getCsrf()
  {
    //Get payload
    $token = $_COOKIE['user_token'];
    $payload = self::getTokenPayload($token);
   
    return $payload['csrf'];
  }
  public static function verifyCsrf($csrf)
  {
    return self::getCsrf() == $csrf;
  }

  public static function getCurrentUserId()
  {
    
    return self::$currentUserId;
  }
  public static function setCurrentUserId($userId)
  {
    self::$currentUserId = $userId;
  }


}