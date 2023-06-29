<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "watch_store";
  
    public $conn;
  
    public function __construct() {
      $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
      if ($this->conn->connect_error) {
        die("Connection failed: " . $this->conn->connect_error);
      }
    }
  
    public function query($sql) {
      return $this->conn->query($sql);
    }
  
    public function escape($value) {
      return $this->conn->real_escape_string($value);
    }
  
    public function insert($table, $data) {
      $keys = array_keys($data);
      $values = array_values($data);
      $keys = array_map(array($this, "escape"), $keys);
      $values = array_map(array($this, "escape"), $values);
      $keys = implode(",", $keys);
      $values = "'" . implode("','", $values) . "'";
      $sql = "INSERT INTO " . $table . " (" . $keys . ") VALUES (" . $values . ")";
      $this->query($sql);
    }
    
    public function delete($table, $where) {
      $sql = "DELETE FROM $table WHERE $where";
      $result = $this->query($sql);
      return $result;
   }

   public function update($table, $data, $where) {
    $set = [];
    foreach ($data as $column => $value) {
      $set[] = "$column = '$value'";
    }
    $set = implode(', ', $set);
    $sql = "UPDATE $table SET $set WHERE $where";
    return $this->query($sql);
   
  }
  
  public function select($sql) {
    $result = $this->query($sql);
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

public function search($table, $field, $keyword, $joinTable1 = null, $joinCondition1 = null, $joinTable2 = null, $joinCondition2 = null, $joinTable3 = null, $joinCondition3 = null, $joinTable4 = null, $joinCondition4 = null) {
  if ($joinTable1 !== null && $joinCondition1 !== null && $joinTable2 !== null && $joinCondition2 !== null && $joinTable3 !== null && $joinCondition3 !== null && $joinTable4 !== null && $joinCondition4 !== null) {
      $sql = "SELECT $table.*, $joinTable1.*, $joinTable2.*, $joinTable3.*, $joinTable4.*
              FROM $table
              JOIN $joinTable1 ON $joinCondition1
              JOIN $joinTable2 ON $joinCondition2
              JOIN $joinTable3 ON $joinCondition3
              JOIN $joinTable4 ON $joinCondition4
              WHERE $table.$field LIKE '%$keyword%'
              OR $joinTable1.$field LIKE '%$keyword%'
              OR $joinTable2.$field LIKE '%$keyword%'
              OR $joinTable3.$field LIKE '%$keyword%'
              OR $joinTable4.$field LIKE '%$keyword%'";
  } elseif ($joinTable1 !== null && $joinCondition1 !== null && $joinTable2 !== null && $joinCondition2 !== null && $joinTable3 !== null && $joinCondition3 !== null) {
      $sql = "SELECT $table.*, $joinTable1.*, $joinTable2.*, $joinTable3.*
              FROM $table
              JOIN $joinTable1 ON $joinCondition1
              JOIN $joinTable2 ON $joinCondition2
              JOIN $joinTable3 ON $joinCondition3
              WHERE $table.$field LIKE '%$keyword%'
              OR $joinTable1.$field LIKE '%$keyword%'
              OR $joinTable2.$field LIKE '%$keyword%'
              OR $joinTable3.$field LIKE '%$keyword%'";
  } elseif ($joinTable1 !== null && $joinCondition1 !== null && $joinTable2 !== null && $joinCondition2 !== null) {
      $sql = "SELECT $table.*, $joinTable1.*, $joinTable2.*
              FROM $table
              JOIN $joinTable1 ON $joinCondition1
              JOIN $joinTable2 ON $joinCondition2
              WHERE $table.$field LIKE '%$keyword%'
              OR $joinTable1.$field LIKE '%$keyword%'
              OR $joinTable2.$field LIKE '%$keyword%'";
  } elseif ($joinTable1 !== null && $joinCondition1 !== null) {
      $sql = "SELECT $table.*, $joinTable1.*
              FROM $table
              JOIN $joinTable1 ON $joinCondition1
              WHERE $table.$field LIKE '%$keyword%'
              OR $joinTable1.$field LIKE '%$keyword%'";
  } else {
      $sql = "SELECT * FROM $table WHERE $field LIKE '%$keyword%'";
  }
  $result = $this->conn->query($sql);
  return $result;
}




    public function close() {
      $this->conn->close();
    }
  }


?>
<?php
$uploads_dir = 'uploads';
if (!is_dir($uploads_dir)) {
    mkdir($uploads_dir);
}

?>