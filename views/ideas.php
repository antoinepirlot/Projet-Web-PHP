<div class="page_website">

    <!-- ***************************************************** Post idea ***************************************************** -->
    <div>
        <div class="container-sm mt-5 border border-dark border-2 rounded-3" id="post_ideas">
            <div class="mb-5 mt-5 mx-5">
                <p class="fs-2 bg-light bg-gradient text-danger text-center"> <?php echo $alert ?> </p>
                <form method="post" action="index.php?action=ideas">
                    <textarea name="text_idea" placeholder="Bonjour <?php echo USERNAME ?> poste ton idée ici!"
                              class="form-control bg-light fs-4 border-dark border-dark" rows="6"></textarea>
                    <div class="text-center">
                        <input name="post_idea" value="Publier" type="submit"
                               class="border border-dark text-center btn btn-light btn-outline-warning fs-3 mt-3 mb-2 rounded-pill col-8 text-dark"
                        >
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ***************************************************** And of post idea ***************************************************** -->


    <!--*****************************************************  Filter *****************************************************  -->
    <div class="container-md mt-4">
        <div class="row">
            <!-- **************** Popular**************** -->

            <div class="dropdown col-lg-4 text-center mb-3">
                <button class="filter btn dropdown-toggle fs-3 border border-dark" type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Trie par popularité
                </button>
                <form method="post" action="index.php?action=ideas" class="dropdown-menu">
                    <button name="popularity" type="submit" value="3" class="dropdown-item fs-4">3 idées</button>
                    <button name="popularity" type="submit" value="10" class="dropdown-item fs-4">10 idées</button>
                    <button name="popularity" type="submit" value="all" class="dropdown-item fs-4">Toutes les idées
                    </button>
                </form>
            </div>


            <!--**************** Date **************** -->

            <div class="dropdown col-lg-4 text-center mb-3">
                <button class="filter btn dropdown-toggle fs-3 border border-dark" type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Trie par date ↘
                </button>
                <form method="post" action="index.php?action=ideas" class="dropdown-menu">
                    <button name="date" type="submit" value="3" class="dropdown-item fs-4">3 idées</button>
                    <button name="date" type="submit" value="10" class="dropdown-item fs-4">10 idées</button>
                    <button name="date" type="submit" value="all" class="dropdown-item fs-4">Toutes les idées</button>
                </form>
            </div>


            <!-- **************** Statuts **************** -->
            <div class="dropdown col-lg-4 text-center">
                <button class="filter btn dropdown-toggle fs-3 border border-dark" type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                    Filtrer par idées
                </button>
                <form method="post" action="index.php?action=ideas" class="dropdown-menu">
                    <button name="idea_status" type="submit" value="Submitted" class="dropdown-item fs-4">Soumises
                    </button>
                    <button name="idea_status" type="submit" value="Accepted" class="dropdown-item fs-4">Acceptées
                    </button>
                    <button name="idea_status" type="submit" value="Refused" class="dropdown-item fs-4">Refusées
                    </button>
                    <button name="idea_status" type="submit" value="Closed" class="dropdown-item fs-4">Fermées</button>
                    <button name="idea_status" type="submit" value="all" class="dropdown-item fs-4">Toutes les idées
                    </button>
                </form>
            </div>
        </div>
    </div>


    <!--***************************************************** And of filter *****************************************************  -->


    <!-- ***************************************************** notification ***************************************************** -->
    <?php if ($notification != '') { ?>
        <div class="mt-5 mb-4 text-center "><span
                    class="fs-2 mt-3 py-2 text-light bg-secondary px-2 py-2"> <?php echo $notification ?> </span></div>
    <?php } ?>
    <!-- ***************************************************** and of notification ***************************************************** -->


    <!-- ***************************************************** Ideas ***************************************************** -->

        <?php foreach ($tableIdeas

                       as $i => $idea) { ?>

            <div class="publication_idea container-fluid col-lg-10 border border-dark mt-4 mb-5">


                <!-- ********************  1. idea and member information  ********************  -->
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
                                    <p> <?php echo $idea->getMember()->getFrenchType() ?>
                                        : <?php echo $idea->getMember()->getHtmlUsername() ?> <br>
                                        <!-- end of member information -->

                                        <!-- submitted date -->
                                        <span
                                                class="fs-3 mx-4"> <?php echo $idea->formattedSubmittedDate(); ?> </span>
                                        <!-- end of submitted date -->
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- status of idea -->
                        <p class="col-sm-4 text-sm-end mt-sm-4 text-center"><span
                                    class="fs-3 bg-light btn-lg <?php echo $idea->getStatusColor() ?>"> <?php echo $idea->getFrenchStatus() ?> </span>
                        </p>
                        <!-- end of status of idea -->

                    </div>
                </div>


                <!-- ********************  2. idea ********************  -->


                <div class="fs-3 text-center bg-light mx-5">
                    <?php echo $idea->getHtmlText() ?>
                </div>


                <!-- ********************  3. form & number of votes ********************  -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-8 container-fluid btn-group mb-lg-3">

                            <!-- button vote-->
                            <form method="post" action="index.php?action=ideas">
                                <button name="vote" type="submit" value="<?php echo $idea->getIdeaId() ?>"
                                        class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark mt-3">
                                    Voter
                                </button>
                            </form>
                            <!-- end of button vote-->

                            <!-- button comment-->
                            <form class="mx-2" method="post" action="index.php?action=comments">
                                <a class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark mt-3"
                                   href="index.php?action=comments&&idIdea=<?php echo $idea->getIdeaId() ?>">Répondre</a>
                            </form>
                            <!-- end of button comment-->
                        </div>

                        <!-- number of votes -->
                        <div class="idea_outline col-4 text-end mt-4 fs-3 text-light fw-bolder">
                            <p><?php echo $idea->getNumberOfVotes()?> vote(s)</p>
                        </div>
                        <!-- end of number of votes -->

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

<!-- ***************************************************** And of ideas ***************************************************** -->


