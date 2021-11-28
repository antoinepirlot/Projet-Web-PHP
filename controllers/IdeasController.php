<?php


class IdeasController
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


        # **************** Post an idea **************** #
        $alert = '';
        if (!empty($_POST['post_idea'])) {
            if (empty($_POST['text_idea'])) {
                $alert = "Veuillez introduire une idée!";
            } else {
                $member = $this->_db->selectMemberByEmail(EMAIL);
                $this->_db->insertIdea($_POST['text_idea'], $member->getId());
            }
        }
        # ******************************************** #


        # **************** vote for an idea **************** #
        $notification = '';

        if (!empty($_POST['vote'])) {
            $idea = $this->_db->selectIdeaById($_POST['vote']);
            $member = $this->_db->selectMemberByEmail(EMAIL);

            if ($idea->getStatus() == 'Closed') { //When the status of an idea is closed, members cannot vote anymore for that idea
                $notification = " L'idée est fermée ! Vous ne pouvez pas voter !";

            } else if ($idea->getMember()->getId() == $member->getId()) {//member cannot vote for his own idea
                $notification = " Vous ne pouvez pas voter pour votre propre idée!";

            } else if ($this->_db->alreadyVoted($idea->getIdeaId(), $member->getId())) {//member can vote only one time for an idea
                $notification = 'Vous avez déjà voté pour cette idée! ';

            } else { // vote for an idea
                $member = $this->_db->selectMemberByEmail(EMAIL);
                $this->_db->insertVote($member->getId(), $_POST['vote']);
                $notification = "Vous avez bien voter pour l'idée!";
            }
        }
        # ************************************************ #


        # **************** Filter Idea **************** #
        if (!empty($_POST['idea_status'])) { // filter by Status
            $tableIdeas = $this->_db->selectIdeasByStatus($_POST['idea_status']);
        } else if (!empty($_POST['date'])) { //filter by date
            $tableIdeas = $this->_db->selectIdeasByDate($_POST['date']);
        } else if (!empty($_POST['popularity'])) { //filter by popularity
            $tableIdeas = $this->_db->selectIdeasByPopularity($_POST['popularity']);
        } else {
            $tableIdeas = $this->_db->selectIdeasByPopularity(3); // default ideas display (3 most popular idea)
        }
        # ************************************************ #




        include(VIEWS_PATH . 'ideas.php');

    }
}


?>