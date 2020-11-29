<?php
// session_start(); 
// include_once("helpers/Middleware.php");
// $middlware = new Middleware();
$mod='home'; 
$act=''; 
// $type='';
if (isset($_GET['mod'])) {
	$mod=$_GET['mod'];
}
if (isset($_GET['act'])) {
	$act=$_GET['act'];
}
switch ($mod) {
	// case 'user':{
	// 	// $middlware->isLogin();
	// 	include_once('controllers/UserController.php');
	// 	$UserController= new UserController();
	// 	switch ($act) {
	// 		case 'list':{
	// 			$UserController->list();
				
	// 			break;
	// 		}
	// 		case 'show':{
	// 			$UserController->show();
				
	// 			break;
	// 		}
	// 		case 'delete':{
	// 			$UserController->delete();
				
	// 			break;
	// 		}
	// 		case 'add':{
	// 			$UserController->create();
				
	// 			break;
	// 		}
	// 		case 'update':{
	// 			$UserController->update();
				
	// 			break;
	// 		}
	// 		case 'upload':{
	// 			$UserController->upload();
				
	// 			break;
	// 		}
	// 		default:{
	// 			echo "Not found!";
	// 			break;
	// 		}

	// 	}
	// 	break;
	// }
	case 'home':{
		include_once('Controller/HomeController.php');
		$homeController= new HomeController();
		// $homeController->Home();
		switch ($act) {
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