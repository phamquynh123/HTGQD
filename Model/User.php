<?php
include_once('Model/Model.php');

class User extends Model{
	var $table_name = 'users';
	var $primery_key = 'id';
	var $primery_name = 'name';
	var $primery_phone = 'phone';
	var $primery_cmnd = 'cmnd';
	var $primery_address = 'address';
}