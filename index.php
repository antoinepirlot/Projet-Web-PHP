<?php

    function loadClass($className) {
        require_once("models/" . $className . ".class.php");
    }
    spl_autoload_register("loadClass");

    session_start();

    $db=Db::getInstance();

    //constants
	define("VIEWS_PATH", "views/");
	define("CONTROLLERS_PATH", "controllers/");
	define("IMAGES_PATH", VIEWS_PATH."image/");


	if(!empty($_SESSION)){
	    $member = $db->selectMemberById($_SESSION['member']->getId());

	    if($member->isDisabled())
            // The member has been disabled while she/he was loged in
            $_GET["action"] = "logout";

	    elseif ($member->getType() != $_SESSION["member"]->getType())
            // The member's type has changed to admin or member while he/she was loged in
            $_SESSION["member"] = $member;

        define("USERNAME", $member->getHtmlUsername());
        define("EMAIL", $member->getHtmlEmail());
        define("TYPE", $member->getFrenchType());
    }

############################################## APPEL DU HEADER #########################################################
	include(VIEWS_PATH."header.php");

	if(empty($_GET["action"]))
	    $_GET["action"] = "home";

    // Redirects to the chosen view
	switch ($_GET["action"]){
        case "login": // Redirects to the login page
            require_once (CONTROLLERS_PATH."LoginController.php");
            $controller = new LoginController($db);
            break;

        case "logout": // Redirects to the LogoutController then Home page to disconnect the member
            require_once (CONTROLLERS_PATH."LogoutController.php");
            $controller = new LogoutController();
            break;

        case "register": // Redirects to the registration page
            require_once(CONTROLLERS_PATH . "RegisterController.php");
            $controller = new RegisterController($db);
            break;

        case "ideas": // redirects to the ideas page
            require_once (CONTROLLERS_PATH."IdeasController.php");
            $controller = new IdeasController($db);
            break;

        case "comments":// redirects to the comments page
            require_once (CONTROLLERS_PATH."CommentsController.php");
            $controller = new CommentsController($db);
            break;

        case "profile": // redirects to the profile page
            require_once (CONTROLLERS_PATH."ProfileController.php");
            $controller = new ProfileController();
            break;

        case "my_comments": // redirects to the comments page
            require_once (CONTROLLERS_PATH."MyCommentsController.php");
            $controller = new MyCommentsController($db);
            break;

        case "my_votes": // redirects to the votes page
            require_once (CONTROLLERS_PATH."MyVotesController.php");
            $controller = new MyVotesController($db);;
            break;

        case "my_ideas": // redirects to the member ideas
            require_once (CONTROLLERS_PATH."MyIdeasController.php");
            $controller = new MyIdeasController($db);
            break;

        case "members_gestion": // redirects to the member gestion page
            require_once (CONTROLLERS_PATH."MembersGestionController.php");
            $controller = new MembersGestionController($db);
            break;

        case "ideas_gestion": // redirects to the members' ideas' gestion page
            require_once (CONTROLLERS_PATH."IdeasGestionController.php");
            $controller = new IdeasGestionController($db);
            break;

        default: // Redirects to the Home page by default
            require_once(CONTROLLERS_PATH."HomeController.php");
            $controller = new HomeController();
            break;
    }
    $controller->run();

############################################## APPEL DU FOOTER #########################################################
    include(VIEWS_PATH."footer.php");
?>