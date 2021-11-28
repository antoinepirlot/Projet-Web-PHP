<?php


class MembersGestionController {
    private $_db;

    public function __construct($db){
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

        if(!empty($_POST["form_members_gestion"])) {
            $member = $this->_db->selectMemberById($_POST["member_id"]);

            if(empty($_POST["action_on_member"])) {
               // Nothing has been checked
                $notification = "Vous devez selectionner un choix pour soumettre la modification";

            } elseif(empty($member)){
                $notification = "Vous essayez de changer les propriétés d'un membre qui n'existe pas, c'est interdit";
                $alertType = "alert-danger";

            } elseif($_SESSION["member"]->getId() == $member->getId()) {
                // The current admin has changed the html script and changed the member_id
                // of another line to match to her/his id, so he/she can't change her/his informations
                $notification = "Vous ne pouvez pas changer vos informations";
                $alertType = "alert-danger";

            } elseif ($_POST["action_on_member"] == "admin" || $_POST["action_on_member"] == "member") {
                // The admin asks to change de type of member to admin
                if ($this->_db->changeMemberType($_POST["member_id"], $_POST["action_on_member"])) {
                    // type changing passed
                    $notification = "Changement effectué";
                    $alertType = "alert-success";

                } else {
                    // type changing failed
                    $notification = "Erreur lors du changement";
                }

            } else {
                //The admin asks a deactivation or activation
                if ($_POST["action_on_member"] == "disable" || $_POST["action_on_member"] == "activation") {
                    if ($this->_db->disableOrActivateMember($_POST["member_id"], $_POST["action_on_member"])) {
                        // Deactivation passed
                        $notification = "Changement effectué";
                        $alertType = "alert-success";

                    } else {
                        // Deactivation or activation failed
                        $notification = "Erreur lors du changement";
                    }

                }else{
                    $notification = "Vous essayez de faire un changement qui n'est pas prévu.";
                    $alertType = "alert-danger";
                }
            }
        }

        $members = $this->_db->selectMembers();
        $nbMembers = $this->_db->countMembers();
        include (VIEWS_PATH ."members_gestion.php");
    }
}
?>