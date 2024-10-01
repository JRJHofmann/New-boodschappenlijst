<?php
class Database {
    public $connection;
    public $statement;

    public function __construct($config){

        $dsn = 'mysql:' . http_build_query($config, '',';');
        $this->connection = new PDO($dsn, 'root', 'root', [
            
        ]);
    }

    public function Query($query, $param =[]) {
    
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($param);

        return $this;
    }

    public function fetch(){
        return $this->statement->fetch();
    }
}
