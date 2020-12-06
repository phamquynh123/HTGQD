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

	public function find($column, $value) {
		$query="SELECT *
  		FROM " . $this->table_name . "
 		WHERE " . $column . " = " . $value ;
		$result= $this->conn-> query($query);
		$data=array();

		while ($row= $result->fetch_assoc() ){
			$data[]=$row;
		}
		return $data;
	}


	function insert($data){
		$field="";
		$values="";
		foreach ($data as $key => $value) {
			$field .=$key. ',' ;
			$values .='"'.$value. '",' ;	
		}
		$field=trim($field ,',');
		$values=trim($values ,',');
		$query='INSERT INTO '. $this->table_name.'('.$field.')' . ' VALUES ( '.$values .' )';
		// echo $query; die;
		$result = $this->conn->query($query);
		return $result;
	}

	public function update($data){
		$abc="";
		foreach ($data as $key => $value) {
			$abc .= $key." = '".$value ." ' ,";
		}
		$abc=trim($abc, ' , ');
		$query =" UPDATE  $this->table_name SET $abc WHERE id = ".$data['id'] ;
		$result = $this->conn->query($query);
		return $result;
	}

}


?>