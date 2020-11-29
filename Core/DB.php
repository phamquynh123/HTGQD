<?php

class DB{

    var $conn;
    public function __construct(){
        $servername="localhost";
        $username="root";
        $password="";
        $dbname="HTGQD";
        $this->conn=new mysqli($servername,$username,$password,$dbname);
        $this->conn->set_charset("utf8");
        if ($this->conn->connect_error) {
            die("Conection failed: ".$this->conn->connect_error);
        }

    }

}