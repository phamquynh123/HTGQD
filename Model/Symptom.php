<?php

include_once('Model/Model.php');

class Symptom extends Model{
	var $table_name='symptom';
	var $primery_key='id';
	var $primery_name='name';
}