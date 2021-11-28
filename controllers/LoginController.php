<?php


class LoginController
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function run()
    {
        if(!empty($_SESSION)){
            header("Location: index.php?action=ideas");
            die();
        }

        $notification = "";
        if (!empty($_POST['form_login'])) {

            $email = $_POST["email"];
            $password = $_POST["password"];

            if (empty($email) && empty($password)) {
                //The user didn't entered any login information in the form
                $notification = "Veuillez entrer votre email et votre mot de passe pour vous connecter";

            } else if (empty($email)) {
                // The user didn't entered his/her email in the form
                $notification = "Veuillez entrer votre email";

            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // The email entered isn't a valid email
                $notification = "Veuillez entrez un email valide";

            } else if (!$this->_db->emailExists($email)) {
                // The email isn't in the db
                $notification = "Email inexistant, veuillez vous inscrire!";

            } else if (empty($password)) {
                // The user didn't entered his/her password in the form
                $notification = "Veuillez entrer votre mot de passe";

            } else if (!$this->_db->memberLogin($email, $password)) {
                // Connection failed due to incorrect password
                $notification = "Mot de passe incorrect";

            } else {
                // The user entered correct login informations
                $member = $this->_db->selectMemberByEmail($email);
                if ($member->isDisabled()){
                    $notification = "Votre compte a été désactivé.";

                }else {
                    // This account isn't disabled, the member can be connected to the website
                    $_SESSION["authenticated"] = "ok";
                    $_SESSION["member"] = $member;
                    // Redirects to the ideas page
                    header("Location: index.php?action=ideas");
                    die();
                }
            }
        }

        include(VIEWS_PATH . "login.php");
    }
}
?>