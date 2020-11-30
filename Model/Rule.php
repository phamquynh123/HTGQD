<?php

include_once('Model/Model.php');

class Rule extends Model{
	var $table_name='rule';
	var $primery_key='id';
	var $primery_pulseIds='pulseIds';
	var $primery_symptomId='symptomId';
	var $primery_wpulsesymptom='wpulsesymptom'; // Khả năng
	var $primery_wsymptompulse='wsymptompulse'; // Tầm quan trọng
}