<?php


class CommentsController
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function run()
    {
        if (empty($_SESSION["authenticated"])) {
            header("Location: index.php?action=home");
            die();
        }

        # ************ redirection in case of error ************ #

        // if the user removes the idea_id from the URL
        if (empty($_GET['idIdea'])) {
            header("Location: index.php");
            die();
        }

        //if the user changes the idea_id and introduces an id that does not exist
        if (!$this->_db->existIdea($_GET['idIdea'])) {
            header("Location: index.php");
            die();
        }
        # ************************************************* #



        $notification = "";

        $ideaOfAuthor = $this->_db->selectIdeaById($_GET['idIdea']);
        $member = $this->_db->selectMemberByEmail(EMAIL);


        # ************ Post a comment ************ #
        if (!empty($_POST['post_comment'])) {
            if (empty($_POST['text'])) {
                $notification = "Veuillez introduire du texte !";
            } else {
                $this->_db->addComment($_POST['post_comment'], $member->getId(), htmlspecialchars($_POST['text']));
                $notification = "Votre commentaire à été publié !";
            }
        }
        # *********************************** #


        # ************ delete a comment ************ #
        if (!empty($_POST['removeComment'])) {
            $this->_db->removeComment($_POST['removeComment']);
            $notification = "Votre commentaire a été supprimé !";
        }
        # ****************************************** #


        # **************** vote for an idea **************** #
        if (!empty($_POST['vote'])) {
            if ($ideaOfAuthor->getStatus() == 'Closed') { //When the status of an idea is closed, members cannot vote anymore for that idea
                $notification = " L'idée est fermée ! Vous ne pouvez pas voter !";

            } else if ($ideaOfAuthor->getMember()->getId() == $member->getId()) {//member cannot vote for his own idea
                $notification = " Vous ne pouvez pas voter sur votre propre idée!";

            } else if ($this->_db->alreadyVoted($ideaOfAuthor->getIdeaId(), $member->getId())) {//member can vote only one time for an idea
                $notification = 'Vous avez déjà voté sur cette idée! ';

            } else {
                $this->_db->insertVote($member->getId(), $_POST['vote']);
                $notification = "Vous avez bien voter sur l'idée!";
            }

        }
        # ********************************************** #





        $tableComments = $this->_db->selectCommentsByIdea($_GET['idIdea']);



        include(VIEWS_PATH . "comments.php");

    }
}

?>