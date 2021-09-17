<?php
class Database{
  public $conn;
  private $host;
  private $user;
  private $password;
  private $dbname;

  function __construct(){
    $this->host = DB_HOST;
    $this->user = DB_USER;
    $this->password = DB_PASSWORD;
    $this->dbname = DB_NAME;
  }

  function conn(){
    $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
    $this->conn->set_charset("utf8");
    if(!$this->conn){
      return false;
    }else{
      return $this->conn;
    }
  }

  function fetch($sql, $is_array, $is_count = false){
    $result = mysqli_query($this->conn, $sql);
    if(($result) && (mysqli_num_rows($result) > 0)){
      $arr = array();
      if($is_array){
        if($is_count){
          $arr['count'] = mysqli_num_rows($result);
        }
        $arr['status'] = true;
        while($row = mysqli_fetch_array($result)){
          $arr['data'][] = $row;
        }
      }else{
        $arr = mysqli_fetch_assoc($result);
      }
      return $arr;
    }else{
      // echo $this->dbname;
      // return $sql;
      return false;
    }
  }

  function insert($sql, $insert_id){
    $result = mysqli_query($this->conn, $sql);
    if($result){
      if($insert_id){
        return mysqli_insert_id($this->conn);
      }else{
        return true;
      }
    }else{
      return false;
    }
  }

  function execute($sql){
    $result = mysqli_query($this->conn, $sql);
    if($result){
      return true;
    }else{
      return false;
    }
  }

  function close(){
    mysqli_close($this->conn);
  }
}
?>
