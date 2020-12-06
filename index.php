<?php
// session_start(); 
// include_once("helpers/Middleware.php");
// $middlware = new Middleware();
$mod='home'; 
$act=''; 

	if (isset($_GET['mod'])) {
		$mod=$_GET['mod'];
	}
	if (isset($_GET['act'])) {
		$act=$_GET['act'];
	} else $act='welcome';
switch ($mod) {
	case 'home':{
		include_once('Controller/HomeController.php');
		$homeController= new HomeController();
		// $homeController->Home();
		switch ($act) {
			case 'welcome': {
				$homeController->welcome();
				break;
			}
			case 'search': {
				$homeController->search();
				break;
			}
			case 'add': {
				$homeController->add();
				break;
			}
			case 'index':{
				$homeController->Home();
				
				break;
			}
			case 'post':{
				$homeController->Handle();
				
				break;
			}
			default:{
				echo "Not found!";
				break;
			}
		}
		break;
	}
	
	default:{
		echo "Not found!";
		break;
	}

}
?>