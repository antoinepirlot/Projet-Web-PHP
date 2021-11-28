<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH?>css/styles.css" media="all">
    <title>Moda Young</title>
    <!--*******************************************Fonts*************************************************************-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!--Font Title website-->
    <link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">
    <!--introduction, notofication , form-->
    <link href="https://fonts.googleapis.com/css2?family=El+Messiri&family=Special+Elite&display=swap" rel="stylesheet">
    <!--section idea : user name; buttons; number of votes-->
    <link href="https://fonts.googleapis.com/css2?family=Domine&family=El+Messiri&family=Noto+Serif+SC:wght@300&display=swap"
          rel="stylesheet">
    <!--logo & footer-->
    <link href="https://fonts.googleapis.com/css2?family=Domine&family=El+Messiri&family=New+Tegomin&family=Noto+Serif+SC:wght@300&display=swap"
          rel="stylesheet">
    <!--title page Comment-->
    <link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <?php if (!empty($_SESSION["authenticated"])) {?>
            <div class=" container-fluid" id="nav_color">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="navbar-brand"><img src="<?php echo IMAGES_PATH?>logo.png" id="logo-image" alt="logo"/>
                        <span class="text-warning fs-1" id="logo-title">Moda Young</span>
                    </div>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        </ul>
                        <div class="d-flex">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <?php if(TYPE == "Admin") {?>
                                    <li class="nav-item">
                                        <a class="nav-link active text-warning fs-3" aria-current="page" href="index.php?action=members_gestion">Gestion des membres</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active text-warning fs-3" aria-current="page" href="index.php?action=ideas_gestion">Gestion des idées</a>
                                    </li>
                                <?php }?>
                                <li class="nav-item">
                                    <a class="nav-link text-light fs-3" href="index.php?action=ideas">Les idées</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light fs-3" href="index.php?action=profile">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light fs-3" href="index.php?action=logout">Se déconnecter</a>
                                </li>
                            </ul>
                        </div>
                    </div>


                </nav>
            </div>
        <?php }?>
    </header>
