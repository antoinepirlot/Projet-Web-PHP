<?php


class ProfileController {


    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
    }

    public function run(){
        if(empty($_SESSION["authenticated"])){
            header("Location: index.php?action=home");
            die();
        }

        include(VIEWS_PATH."profile.php");
    }
}

?>