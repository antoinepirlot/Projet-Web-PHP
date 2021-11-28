
<!-- ***************************************************** User information ***************************************************** -->
<div class="container-fluid">
    <div class="container-lg mt-3 mt-lg-5">
        <div class="row">
            <!--*********** Image *********** -->

            <div class="col-md-4 text-sm-end text-center">
                <img src="<?php echo VIEWS_PATH ?>image/profile.png" alt="user_image" id="image_profile">
            </div>

            <!-- *********** member information *********** -->

            <div class="col-md-7 border border-2 border-dark fs-3 pt-3 filter mt-2 mt-sm-0">
                <p> Pseudo : <?php echo USERNAME ?>  </p>
                <p> Adresse mail : <?php echo EMAIL ?></p>
                <p> Statut : <?php echo TYPE ?> </p>
            </div>


        </div>
    </div>

</div>
<!-- ***************************************************** End of user information ***************************************************** -->


<!--  ***************************************************** Buttons ***************************************************** -->
<div class="container-fluid container-lg mt-5">
    <div class="row">
        <!-- ****************** Button my Ideas ****************** -->

        <div class="col-sm-3 text-center">
            <form action="index.php?action=my_ideas" method="post">
                <button class="btn fs-2 btn-secondary btn-lg" type="submit">Mes idées</button>
            </form>
        </div>

        <!--  ****************** Button my comments ****************** -->

        <div class="col-sm-5 text-center mt-3 mb-3 mt-sm-0 mb-sm-0">
            <form action="index.php?action=my_comments" method="post">
                <button class="btn fs-2 btn-secondary btn-lg" type="submit">Mes commentaires</button>
            </form>
        </div>


        <!-- ****************** Button my votes ****************** -->

        <div class="col-sm-3 text-center">
            <form action="index.php?action=my_votes" method="post">
                <button class="btn fs-2 btn-secondary btn-lg" type="submit"> Mes votes</button>
            </form>
        </div>

    </div>
</div>

<!--  ***************************************************** End of buttons ***************************************************** -->



<!--  ***************************************************** Table My Comments ***************************************************** -->
<div class="container-fluid">

    <!-- ****************** the case where the member has not commented any idea or has deleted all comments ****************** -->

    <?php if ($commentsNotDeleted == 0 && $commentsDeleted == 0) { ?>
        <p class="fs-1 mt-5 text-center text-danger"> Vous n'avez commenté sur aucune idée!</p>
    <?php } else if ($commentsNotDeleted == 0 && $commentsDeleted != 0) { ?>
        <p class="fs-1 mt-5 text-center text-danger"> Vous avez supprimé tous vos commentaires!</p>


    <?php } else if ($commentsNotDeleted != 0) { ?>
        <table class="table table-bordered table-hover border-dark mt-5">

            <thead class="fs-4">
            <tr>
                <th></th>
                <th> L'idée</th>
                <th> Mon commentaire</th>
                <th> Supprimer mon commentaire</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($tableMyComments as $i => $my_comment) {
                if (!$my_comment->isDeleted()) { ?> <!-- if the comment is not deleted then it must be displayed -->
                    <tr class="fs-5">
                        <!--button idea -->
                        <td>
                            <form method="post"
                                  action="index.php?action=comments&&idIdea=<?php echo $my_comment->getIdea()->getIdeaId() ?>">
                                <button type="submit"
                                        class="idea_outline btn btn-light btn-outline-warning fs-6 text-dark border border-dark rounded-pill rounded">
                                    Aller vers l'idée
                                </button>
                            </form>
                        </td>
                        <!--end of button idea -->

                        <!-- idea -->
                        <td> <?php echo $my_comment->getIdea()->getText() ?> </td>

                        <!-- comment -->
                        <td> <?php echo $my_comment->getHtmlText() ?></td>

                        <!--button delete comment -->
                        <td>
                            <form method="post"
                                  action="index.php?action=my_comments">
                                <button type="submit" name="removeMyComment"
                                        value="<?php echo $my_comment->getCommentId() ?>"
                                        class="idea_outline btn btn-light fs-6 btn-outline-danger text-dark border border-dark">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                        <!--button delete comment -->
                    </tr>
                <?php }
            } ?>
            </tbody>
        </table>
    <?php } ?>
</div>