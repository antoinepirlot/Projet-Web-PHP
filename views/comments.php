<div class="page_website">
    <h1 class="text-center display-1 mt-5 text-decoration-underline" id="title_pageComments"> Commentaires</h1>


    <!-- ***************************************************** notification ***************************************************** -->
    <?php if ($notification != '') { ?>
        <div class="mt-5 mb-4 text-center "><span
                    class="fs-3 mt-3 py-2 text-light bg-secondary px-2 py-2"> <?php echo $notification ?> </span></div>
    <?php } ?>
    <!-- ***************************************************** End of notification ***************************************************** -->




    <!-- ***************************************************** Ideas ***************************************************** -->


    <!-- ********************  1. idea and member information  ********************  -->

    <div class="container-fluid col-lg-10 border border-dark mt-5 mb-2 publication_idea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 container-fluid">
                    <div class="row">

                        <!-- image -->
                        <div class="col-2 col-sm-1">
                            <p><img
                                        src="<?php echo VIEWS_PATH ?>image/user.png" class="user_image"
                                        alt="user image"/>
                            </p>
                        </div>
                        <!-- end of image -->


                        <div class="idea_outline text-light fs-3 fw-bolder text-start col">
                            <!-- member information -->
                            <p> <?php echo $ideaOfAuthor->getMember()->getFrenchType() ?>
                                : <?php echo $ideaOfAuthor->getMember()->getHtmlUsername() ?> <br>
                                <!-- end of member information -->

                                <!-- submitted date -->
                                <span
                                        class="fs-3 mx-4"> <?php echo $ideaOfAuthor->formattedSubmittedDate(); ?> </span>
                                <!-- end of submitted date -->
                            </p>
                        </div>

                    </div>

                </div>
                <p class="col-sm-4 text-sm-end mt-sm-4 text-center"><span
                            class="fs-3 bg-light btn-lg <?php echo $ideaOfAuthor->getStatusColor() ?>"> <?php echo $ideaOfAuthor->getFrenchStatus() ?> </span>
                </p>
            </div>
        </div>

        <!-- ********************  2. idea ********************  -->
        <div class="fs-3 text-center bg-light mx-5 py-3">
            <?php echo $ideaOfAuthor->getHtmlText() ?>

        </div>


        <!-- ********************  3. form & number of votes ********************  -->
        <div class="container-fluid">
            <div class="row">

                <!-- button vote-->
                <div class="col-6 container-fluid btn-group mb-lg-3">
                    <form action="index.php?action=comments&&idIdea=<?php echo $ideaOfAuthor->getIdeaId() ?> "
                          method="post">
                        <button name="vote" type="submit" value="<?php echo $ideaOfAuthor->getIdeaId() ?>"
                                class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark mt-3">
                            Voter
                        </button>
                    </form>
                </div>
                <!-- enf of button vote-->

                <!-- number of votes -->
                <div class="idea_outline col-6 text-end mt-4 fs-3 text-light fw-bolder">
                    <p><?php echo $ideaOfAuthor->getNumberOfVotes() ?> vote(s)</p>
                </div>
                <!-- end of number of votes -->

            </div>
        </div>
    </div>

    <!-- ***************************************************** And of ideas ***************************************************** -->




    <!-- ***************************************************** Comments ***************************************************** -->
    <?php foreach ($tableComments as $i => $comment) { ?>
        <div class="container-fluid col-lg-9 border border-dark mt-1 mb-3 post_comment">
            <!-- ************ 1. user name ************ -->
            <span class="idea_outline text-dark col-sm-8 fs-3 fw-bolder text-start "><img
                        src="<?php echo VIEWS_PATH ?>image/user.png" class="user_image" alt="user image" /><?php echo $comment->getMember()->getFrenchType() ?>: <?php echo $comment->getMember()->getHtmlUsername() ?>
        </span>
            <!-- ************ end of user name ************ -->


            <!-- ************ 2 comment ************ -->


            <!-- /!\ if the comment is posted after the closure of the idea -->
            <?php if ($comment->isAfterIdeaClosed($ideaOfAuthor)) { ?>
                <div class="text-center mx-5 mb-2">
                    <span class="text-white bg-secondary fs-3">Ce commentaire a été posté après la date de fermeture de l'idée</span>
                </div>
            <?php } ?>
            <!-- /!\ ******************** /!\ -->

            <!-- comment -->
            <div class="fs-3 text-center bg-light mx-5 mt-3 py-3">
                <?php echo $comment->getHtmlText() ?>
            </div>

            <!-- ************ 2 end of comment ************ -->



            <!-- ************ 3 delete button & creation date of the comment ************ -->

            <div class="container-fluid ">
                <div class="row">

                    <!-- creation date of the comment -->
                    <div class="col-sm-6 mt-3 mb-3 text-center text-sm-start">
                        <span class="text-secondary fs-3 bg-light rounded-pill px-3"><?php echo $comment->formattedCreationDate(); ?></span>
                    </div>
                    <!-- end of creation date of the comment -->


                    <!-- delete button : the button appears if the comment is not deleted and if it is the comment of the user who is connected -->
                    <div class="col-sm text-end mt-2 mb-2">
                        <?php if ($comment->getMember()->getHtmlEmail() == EMAIL && !$comment->isDeleted()) { ?>
                            <form method="post"
                                  action="index.php?action=comments&&idIdea=<?php echo $ideaOfAuthor->getIdeaId() ?> ">
                                <!--action: To return to the same page where there is the idea after removing the idea-->
                                <button type="submit" name="removeComment"
                                        value="<?php echo $comment->getCommentId() ?>"
                                        class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark">
                                    Supprimer
                                </button>
                            </form>
                        <?php } ?>
                    <!--end of delete button -->


                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
    <!-- ***************************************************** End of comments ***************************************************** -->


    <!-- ***************************************************** Post a comment ***************************************************** -->

    <div class="container-fluid col-lg-9 border border-dark mb-5 post_comment">
        <div class="fs-3 mt-5">
            <form method="post" action="index.php?action=comments&&idIdea=<?php echo $ideaOfAuthor->getIdeaId() ?>">
                <div class="mx-5">
                    <textarea name="text" class="form-control fs-4 bg-light" rows="3"
                              placeholder="Ajoute un commentaire..."></textarea>
                </div>
                <!-- button post comment  -->
                <div class="container-fluid text-end mb-3">
                    <button name="post_comment" type="submit" value="<?php echo $ideaOfAuthor->getIdeaId() ?>"
                            class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark mt-3">
                        Répondre
                    </button>
                </div>
                <!-- end of button post comment  -->
            </form>
        </div>
    </div>
</div>
<!-- ***************************************************** End of post a comment ***************************************************** -->
