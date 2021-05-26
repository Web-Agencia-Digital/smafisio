<?php
/* Adapter mysql */
Class mysql
{

    public $query;
    public $fetchAll;
    public $result;
    public $response;
    public $config;
    public $driver;
    public $host;
    public $port;
    public $user;
    public $pass;
    public $dbname;
    public $rowCount = 0;
    public $con;
    public $lastId;

    public function __construct( $config )
    {
        #array com dados do banco
        $this->config = $config;
        # Recupera os dados de conexao do config
        $this->dbname = $this->config['dbname'];
        $this->driver = $this->config['driver'];
        $this->host = $this->config['host'];
        $this->port = $this->config['port'];
        $this->user = $this->config['user'];
        $this->pass = $this->config['password'];
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $this;
    }

    public function query( $sql = '' )
    {
        $this->query = $sql;
        $this->result = $this->con->query($this->query)  or die(print_r($this->con->errorInfo(), true));
        if( $this->result ){
            $this->rowCount =  $this->result->rowCount();
        }
        return $this;
    }

    public function fetchAll() {
        if( $this->result ){
            return  $this->result->fetchAll(PDO::FETCH_ASSOC);
        }
    }

  public function lastId()
  {
     $this->lastId = $this->con->lastInsertId();
     return $this->lastId;
  }

    public function rowCount()
    {
        return $this->rowCount;
    }

    public function limit( $limit, $offset )
    {
        return "LIMIT " . (int) $limit . "," . (int) $offset;
    }
}
/* end file */