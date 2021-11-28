<?php


class MyVotesController
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

        $member =  $this->_db->selectMemberByEmail(EMAIL);
        $voteTable = $this->_db->selectMyVotes($member->getId());


        include (VIEWS_PATH.'my_votes.php');
    }
}

?>