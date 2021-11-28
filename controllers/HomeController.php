<?php 
class HomeController {
		
	public function __construct(){

	}
	
	public function run(){
	    if(!empty($_SESSION)){
	       header("Location: index.php?action=ideas");
	       die();
        }

	    include(VIEWS_PATH.'home.php');
	}
}
?>