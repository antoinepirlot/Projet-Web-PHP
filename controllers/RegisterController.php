<?php


class RegisterController
{
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function run() {
        if(!empty($_SESSION)){
            header("Location: index.php?action=ideas");
            die();
        }

        $notification = "";

        #Verify if the form completed by the user is correct
        if(!empty($_POST["form_register"])) {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];

            if(empty($username) && empty($email) && empty($password)) {
                // The user didn't enter data in the form
                $notification = "Veuillez remplir le formulaire d'inscription pour vous inscrire!";

            }elseif (empty($email) && empty($username)) {
                // The user only enter a password in the form
                $notification = "Veuillez entrez un email et un pseudo!";

            } elseif (empty($username) && empty($password)) {
                // The user only entered an email in the form
                $notification = "Veuillez entrer un pseudo et un mot de passe";

            } elseif (empty($password) && empty($email)) {
                // The user only entered a username
                $notification = "Veuillez entrez un email et un mot de passe";

            } elseif (empty($email)) {
                // The user didn't enter an email in the form
                $notification = "Veuillez entrez un email";

            } elseif (empty($username)) {
                // The user didn't enter a username in the form
                $notification = "Veuillez entrez un pseudo";

            } elseif (empty($password)) {
                // The user didn't enter a password in the form
                $notification = "Veuillez entrer un mot de passe";

            } elseif (strlen($password) < 8) {
                //The password length is < 8 /!\SECURITY CONCERN/!\
                $notification = "Votre mot de passe doit comporter au moins 8 caractères";

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // The user didn't entered a valid email
                $notification = "Veuillez entrer un email valide (vous devez réécrire votre mot de passe)";

            } elseif (strlen($username) > 30) {
                // Everything in the form is completed
                // the username length exceeds varchar(30)
                $notification = "Le pseudo est trop long, il doit faire maximum 30 caractères.";

            } else {
                //The form is completed
                $emailExists = $this->_db->emailExists($email);
                $usernameExists = $this->_db->usernameExists($username);

                if ($emailExists && $usernameExists) {
                    // The member already exists
                    $notification = "Ce membre existe déjà";

                } elseif ($emailExists) {
                    // This email already exists in the DB
                    $notification = "Cet email existe déjà veuillez en choisir un autre";

                } elseif ($usernameExists) {
                    // This username already exists in the DB
                    $notification = "Ce pseudo existe déjà, choisissez en un autre";

                } else {
                    // The member doesn't exist, he/she can be created
                    if($this->_db->register($username, $email, $password)) {
                        $member = $this->_db->selectMemberByEmail($email);
                        $_SESSION['member'] = $member;
                        $_SESSION["authenticated"] = "ok";
                        header("Location: index.php?action=ideas");
                        die();
                    }else{
                        $notification = "Une erreur s'est produite.";
                    }
                }
            }
        }

        include (VIEWS_PATH."register.php");
    }
}
?>