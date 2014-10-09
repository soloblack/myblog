# PHP连接Mysql类文件
-----
```PHP
<?php
class mysql
{
    private $db_servername;
    private $db_username;
    private $db_password;
    private $db_database;
    private $db_coding;
    private $db_showerror;
    private $db_pconn;
    function __construct($servername, $username, $password, $database, $coding, $showerror, $pconn) {
        $this->db_servername = $servername;
        $this->db_username = $username;
        $this->db_password = $password;
        $this->db_database = $database;
        $this->db_coding = $coding;
        $this->db_showerror = $showerror;
        $this->db_pconn = $pconn;
        if (!$this->showerror) {
            error_reporting(0);
        }
        $this->connect();
    }
    function connect() {
        if ($this->pconn) {
            $this->conn = mysql_pconnect($this->db_servername, $this->db_username, $this->db_password);
        } else {
            $this->conn = mysql_connect($this->db_servername, $this->db_username, $this->db_password);
        }
        mysql_select_db($this->db_database, $this->conn) or die($this->error());
        mysql_query(“SET NAME $this->db_coding”);
    }
    function search($table, $where) {
        $this->sql = “SELECT * FROM ‘$table’ $where”;
        return $this->query($this->sql);
    }
    function fetch($sql) {
        $this->result = mysql_fetch_array($sql);
        return $this->result;
    }
    function insert($table, $field, $value) {
        $this->sql = “INSERT INTO ‘$this->database’.’$table’ ($field) VALUES($value);”;
        return $this->query($this->sql);
    }
    function update($table, $field, $value, $where) {
        $this->sql = “UPDATE ‘$this->database’.’$table’ SET ‘$field’ = ‘$value’ $where;”;
        return $this->query($this->sql);
    }
    function delete($table, $where) {
        $this->sql = “DELETE FROM ‘$this->database’.’$table’ $where;”;
        return $this->query($this->sql);
    }
    function query($sql) {
        $this->query = mysql_query($this->sql, $this->conn) or die($this->error());
        return $this->query;
    }
    function num($sql) {
        $this->query = $this->query($this->search($table, ‘’));
        $this->num = mysql_num_rows($this->query);
        return $this->num;
    }
    function error($value = ‘’) {
        if ($this->db_showerror) {
            echo “<br>Error<br />”;
            echo mysql_error() . “<br />”;
            echo $value;
        }
    }
    function check($sql) {
        $check = eregi(‘select|insert|update|delete|\’|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile’, $sql);
        if ($check) {
            exit();
        } else {
            return htmlspecialchars($sql, ENT_QUOTES);
        }
    }
    function __destruct() {
        if (!empty($this->result)) {
            mysql_free_result($this->result) or die($this->error(‘为节省系统资源数据库已被程序自动关闭,请不要重复连接数据库,或者将连接模式改为永久连接’));
        }
        mysql_close($this->conn);
    }
}
?>
```
