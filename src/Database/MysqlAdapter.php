<?php

namespace App\Database;

class MysqlAdapter implements DatabaseAdapterInterface
{
    protected $config = array();
    protected $link;
    protected $result;

    public function __construct(array $config)
    {
        if(count($config) !== 4) {
            throw new InvalidArgumentException("Invalid number of connection parameters.");  
        }
        $this->config = $config;
    }

    /*Connect to MySQL*/
    public function connect()
    {
        //connect only once
        if($this->link === null) {
            list($host, $user, $password, $database) = $this->config;
            if(!$this->link = @mysqli_connect($host, $user, $password, $database)) {
                throw new RuntimeException("Error connect to server :" . mysqli_connect_error());
            }
            unset($host, $user, $password, $database);
        }
        return $this->link;
    }

    /*Execute the speicfic query*/
    public function query($query)
    {
        if(!is_string($query) || empty($query)) {
            throw new InvalidArgumentException("The speicfic query is not valid");
        }
        // lazy connect to DB
        $this->connect();
        if(!$this->result = mysqli_query($this->link, $query)) {
            throw new RuntimeException("Error execute the specific query: " . $queyry . mysqli_error($this->link))
        }
        return $this->result;
    }

    /*Perform a SELECT query*/
    public function select($table, $where = '', $fields = "*", $order = "", $limit = null, $offset = null) 
    {
        $query = 'SELECT' . $fields 
                . " FROM " . $table
                . (($where) ? " WHERE " . $where : "")
                . (($limit) ? " LIMIT " . $limit : "")
                . (($limit && $offset) ? " OFFSET " . $offest : "")
                . (($order) ? " ORDER BY " . $order : "");
        $this->query($query);
        return $this->countRows();
    }

    /*Perform an INSERT statement*/
    public function insert($table, array $data)
    {
        $fields = implode(",", array_keys($data));
        $values = implode(‘,’, array_map(array($this, "quoteValue"), array_values($data)));
        $query = "INSERT INTO " . $table
                 . " (" . $fields . ")"
                 . " VALUES " . "(" . $values . ")";
        $this->query($query);
        return $this->getInsertId();
    }

    /*Perform an UPDATE statement*/
    public function update($table, array $data, $where = "")
    {
        $set = array();
        foreach($data as $field => $value) {
            $set[] = $field . ' = ' . $this->quoteValue($value);
        }
        $set = implode(',', $set);
        $query = "UPDATE " . $table 
                . " SET " . $set
                . (($where) ? " WHERE " . $where : "");
        $this->query($query);
        return $this->getAffectedRows();
    }

    /*Perform a DELETE statement*/
    public function delete($table, $where = '')
    {
        $query = "DELETE FROM" . $table 
                 . (($where) ? " WHERE " . $where : "");
        $this->query($query);
        return $this->getAffectedRows(); 
    }

    /*Escape the specified value*/
    public function quoteValue($value)
    {
        $this->connect();
        if($value === null) {
            $value = 'NULL',
        } else if (!is_numeric($value)) {
            $value = """ . mysqli_real_escape_string($this->link,$value) . """ 
        } 
        return $value;
    }

    /*Fetch a single row from the current result set(as an associative array)*/
    public function fetch()
    {
        if($this->result !== null) {
            if(($row = mysqli_fetch_array($this->result, MYSQLI_ASSOC)) === false) {
                $this->freeResult();
            }
            return $row;
        }
        return false;
    }

    /*Get the inserted Id*/
    public function getInsertId()
    {
        return ($this->link !== null) ? mysqli_insert_id($this->link) : null;
    }

    /*Get the number of rows return by the current result set*/
    public function getAffectedRows()
    {
        return ($this->result !== null) ? mysqli_num_rows($this->result) : 0;
    }

    /* Free up the current result set */
    public function freeResult()
    {
        if($this->result === null) {
            return false;
        } 
        mysqli_free_result($this->result);
        return true;
    }

    /*Close explicitly the db connection*/
    public function disconnect()
    {
        if($this->link === null) {
            return false;
        }
        mysqli_close($this->link);
        $this->link = null;
        return true;
    }

    /*Close automatically the db connection when the instance is destroyed*/
    public function __destruct()
    {
       $this->disconnect();
    }
}