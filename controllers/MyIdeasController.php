<?php


class MyIdeasController
{
    private $_db;
    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        if(empty($_SESSION["authenticated"])){
            header("Location: index.php?action=home");
            die();
        }

        $member_id = $this->_db->selectMemberByEmail(EMAIL)->getId();
        $tableMyIdeas = $this->_db->selectIdeaByMemberId($member_id);


        include (VIEWS_PATH.'my_ideas.php');
    }
}

?>