<?php


class MyCommentsController
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

        $notification='';

        # ********** remove my comment ********** #
        if(!empty($_POST['removeMyComment'])){
            $this->_db-> removeComment($_POST['removeMyComment']);
        }



        $member = $this->_db->selectMemberByEmail(EMAIL);
        $commentsDeleted = $this->_db->countDeletedComment($member->getId()); #number of comments deleted
        $commentsNotDeleted = $this->_db->countNotDeletedComment($member->getId()); # number of comments not deleted
        $tableMyComments = $this->_db->myComments($member->getId());

        include (VIEWS_PATH.'my_comments.php');
    }

}
?>