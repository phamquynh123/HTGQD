<?php 
include_once('Core/DB.php');

class Model
{
	private $conn;
	var $table_name='';
	var $primery_key='';
	public function __construct(){
		$connection = new DB();
		$this->conn = $connection->conn;
	}
	public function All(){
		$data=array();
			//Câu lênh truy vấn cơ sở dữ liệu
		$query="SELECT * from ".$this->table_name;
		// ." ORDER BY ".$this->primery_key." desc"
			//Thực thi câu lệnh truy vấn cơ sở dữ liệu
			// var_dump($query);
			// die;
		$result=$this->conn->query($query);
		while ($row=$result->fetch_assoc()){
			$data[]= $row;
		}
		// var_dump($data);
		// 	die;
		return $data;
	}
	
	public function detail($input){

		$query = "SELECT * from ".$this->table_name." WHERE ".$this->primery_key ." = '".$input."' ";


		$result = $this->conn->query($query);

		$product = $result->fetch_assoc();
		return $product;
	}

	public function whereIn($pulseIds) {
		$data=array();
			
		$query="SELECT *
  		FROM " . $this->table_name . "
 		WHERE pulseIds IN (" . $pulseIds . ")";
		
		$result=$this->conn->query($query);

		while ($row=$result->fetch_assoc()){
			$data[]= $row;
		}

		return $data;
	}

	public function where($pulseId) {
		$data=array();
			
		$query="SELECT *
  		FROM " . $this->table_name . "
 		WHERE pulseIds = " . $pulseId ;
		
		$result=$this->conn->query($query);

		return $result->fetch_assoc();
	}
}


?>