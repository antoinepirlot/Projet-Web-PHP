<?php


class IdeasGestionController {
    private $_db;
    public function __construct($db) {
        $this->_db = $db;
    }

    public function run(){
        //Redirection if not connected or not admin
        if(empty($_SESSION)){
            // Not loged in
            header("Location: index.php?action=home");
            die();

        } elseif($_SESSION["member"]->getType() != "admin"){
            // Loged in but not an admin
            header("Location: index.php?action=ideas");
            die();
        }

        $notification = "";
        $alertType = "alert-warning";

        if(!empty($_POST["form_ideas_gestion"])){
            if(empty($_POST["new_status"])) {
                // Nothing has been checked
                $notification = "Vous devez sélectionner un choix pour pouvoir soumettre le changement";

            }else{
                $newStatus = $_POST["new_status"];
                $statusDateName = "";
                $idea = $this->_db->selectIdeaById($_POST["idea_id"]);

                if(empty($idea)){
                    // The idea doesn't exist
                    $notification = "Vous essayez de changer le statut d'une idée qui n'existe pas, c'est interdit!";
                    $alertType = "alert-danger";

                } elseif($idea->getStatus() == "Closed") {
                    // Closed idea's status can't be changed
                    // the admin changed the html script with the inspect mode
                    $notification = "Vous ne pouvez pas changer le statut d'une idée fermée";

                } elseif($idea->getStatus() == "Submitted" && $newStatus == "Closed") {
                    // Submitted idea's status has to be changed to accepted or refused before being closed
                    // the admin changed the html script with the inspect mode
                    $notification = "Vous ne pouvez pas fermée une idée qui est soumise";

                } else {
                    // The idea's status can be changed
                    if ($newStatus == "Accepted")
                        $statusDateName = "accepted_date";

                    elseif ($newStatus == "Refused")
                        $statusDateName = "refused_date";

                    else
                        $statusDateName = "closed_date";

                    if ($this->_db->changeIdeaStatus($idea->getIdeaId(), $statusDateName, $newStatus)) {
                        // The idea's status changed
                        $notification = "Changement effectué";
                        $alertType = "alert-success";

                    } else {
                        // The idea's status didn't change due to an error
                        $notification = "Erreur lors du changement";
                        $alertType = "alert-danger";
                    }
                }
            }
        }

        $ideas = $this->_db->selectIdeas();
        $nbIdeas = $this->_db->countIdeas();

        include (VIEWS_PATH . "ideas_gestion.php");
    }
}
?>