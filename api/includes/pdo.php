<?php
class _PDO {
  protected $conn = null;

  /* Construct */
  public function __construct ($dbname = MYSQL_NAME) {
    $this->connect($dbname);
  }

  /* Connect */
  private function connect ($dbname) {
    try {
      $DSN = 'mysql:host='.MYSQL_HOST.';dbname='.$dbname.'';
      $this->conn = new PDO($DSN, MYSQL_USER, MYSQL_PWD);
    } 
    catch (Exception $e) {
      res(500, 'SQL Connect Error');
    }
  }

  /* Disconnect */
  private function disconnect () {
    $this->conn = null;
  }

  /* Create SQL PDO Insert */
  private function makeSQLInsert ($name, $insert) {
    foreach ($insert as $key => $value) {
      $i[] = $key;
      $v[] = ":".$key;
    }

    $i = implode(',', $i);
    $v = implode(',', $v);

    return array(
      'sql' => "INSERT INTO $name ($i) VALUES ($v)",
      'insert' => $insert
    );
  }

  /* Create SQL PDO Update */
  private function makeSQLUpdate ($name, $update, $where) {
    $data = array();

    foreach ($update as $key => $value) {
      if(is_array($value)){
        $i[] = $key.'='.$key.$value[0].':'.$key;
        $data[$key] = $value[1];
      }
      else {
        $i[] = $key."=:".$key;
        $data[$key] = $value;
      }
    }

    foreach ($where as $keyWhere => $valueWhere) {
      $v[] = $keyWhere."=:where_".$keyWhere;
      $data['where_'.$keyWhere] = $valueWhere;
    }

    $i = implode(',', $i);
    $v = implode(',', $v);

    return array(
      'sql' => "UPDATE $name SET $i WHERE $v",
      'update' => $data
    );
  }

  /* Run */
  public function run ($sql, array $data = []) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute((array)$data);
      $this->disconnect();
    } 
    catch (Exception $e) {
      res(500, 'SQL Error');
    }
  }

  /* Select Data */
  public function select ($sql, $data, $fetchAll = false) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $stmt->execute((array)$data);
      $result = $fetchAll ? $stmt->fetchAll() : $stmt->fetch();
      $this->disconnect();
      return $result;
    } 
    catch (Exception $e) {
      res(500, 'SQL Error');
    }
  }

  /* Create Data */
  public function create ($name, $insert) {
    try {
      $make = $this->makeSQLInsert($name, $insert);
      $stmt = $this->conn->prepare($make['sql']);
      $stmt->execute((array)$make['insert']);
      $this->disconnect();
    } 
    catch (Exception $e) {
      res(500, 'SQL Error');
    }
  }
  
  /* Update Data */
  public function update ($name, $update, $where) {
    try {
      $make = $this->makeSQLUpdate($name, $update, $where);
      $stmt = $this->conn->prepare($make['sql']);
      $stmt->execute((array)$make['update']);
      $this->disconnect();
    } 
    catch (Exception $e) {
      res(500, 'SQL Error');
    }
  }

  /* Delete Data */
  public function delete ($sql, $data) {
    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute((array)$data);
      $this->disconnect();
    } 
    catch (Exception $e) {
      res(500, 'SQL Error');
    }
  }
}