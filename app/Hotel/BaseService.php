<?php

namespace Hotel;

use PDO;
use Support\Configuration\Configuration;

class BaseService
{
  private static $pdo;

  public function __construct()
  {
    $this->initPDO();
  }

  protected function initPDO()
  {
    //Check if PDO has been init
    if (!empty(self::$pdo)){
      return;
     }
    //DB config
    $config = Configuration::getInstance();
    $dbConfig = $config->getConfig()['database'];
    //DB connection
    try{
    self::$pdo = new PDO(sprintf('mysql:host=%s;dbname=%s;charset=UTF8', $dbConfig['host'], $dbConfig['dbname'] ), $dbConfig['username'], $dbConfig['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
    } 
    catch (\PDOException $ex){
      throw new \Exception(sprintf('Could not connect to db. Error: %s', $ex->getMessage()));
    }
  }

  protected function execute($sql,$params)
  {
    //Prepare stmt
    $stmt = $this->getPdo()->prepare($sql);
    //Execute
    $result = $stmt->execute($params);
      if(!$result){
     throw new Exception($stmt->errorInfo()[2]);
    }
    return $result;
  }


  // FetchAll
  protected function fetchAll($sql, $params = [] , $type= PDO::FETCH_ASSOC)
  {
    //Prepare stmt
    $stmt = $this->getPdo()->prepare($sql);
    //Execute
    $result = $stmt->execute($params);
     if(!$result){
       //Check if valid query
     throw new Exception($stmt->errorInfo()[2]);
    }
    return $stmt->fetchAll($type);
    
  }


  // Fetch
  protected function fetch($sql, $params = [] , $type= PDO::FETCH_ASSOC)
  {
    //Prepare stmt
    $stmt = $this->getPdo()->prepare($sql);
     //Execute
    $result = $stmt->execute($params);
    if (!$result) {
      throw new Exception($statement->errorInfo()[2]);
    }
    return $stmt->fetch($type);
  }

  protected function getPdo()
  {
    return self::$pdo;
  }

  public function clearData($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
}