
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


<!-- ***************************************************** My Ideas ***************************************************** -->


<!-- ********************  1. user image &  submitted date ********************  -->


<?php  if(count($tableMyIdeas)==0) { ?> <!-- if the member has not posted any idea -->
    <p class="fs-1 mt-5 text-center text-danger"> Vous n'avez posté aucune idée! </p>
<?php } else {


    foreach ($tableMyIdeas as $i => $idea) {?>
    <div class="container-fluid col-lg-10 border border-dark mt-5 publication_idea">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 container-fluid">
                    <div class="row">

                        <!-- image -->
                        <div class="col-2 col-sm-1">
                            <p>
                                <img src="<?php echo VIEWS_PATH ?>image/user.png" alt="user_image" class="user_image"/>
                            </p>
                        </div>
                        <!-- end of image -->

                        <!-- submitted date -->
                        <div class="idea_outline text-light fs-2 fw-bolder text-start col mt-3">
                            <p class="fs-3"> <?php echo $idea->formattedSubmittedDate() ?> </p>
                        </div>
                        <!-- end of submitted date -->
                    </div>
                </div>

                <!-- status of idea -->
                <p class="col-sm-4 text-sm-end mt-sm-4 text-center"><span
                            class="fs-3 bg-light btn-lg <?php echo $idea->getStatusColor() ?>"> <?php echo $idea->getFrenchStatus() ?>  </span>
                </p>
                <!-- end of status of idea -->

            </div>
        </div>

        <!-- ******************** 2. idea ******************** -->


        <div class="fs-3 text-center bg-light mx-5">
            <?php echo $idea->getHtmlText() ?>
        </div>


        <!--******************** 3. form & number of votes ******************** -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-8 container-fluid btn-group mb-lg-3">
                    <!-- button comment -->
                    <form class="mx-2" method="post" action="index.php?action=comments">
                        <a class="idea_outline btn btn-light fs-4 btn-outline-warning text-dark border border-dark mt-3"
                           href="index.php?action=comments&&idIdea=<?php echo $idea->getIdeaId()?>">Commentaires</a>
                    </form>
                    <!-- end of button comment -->
                </div>

                <div class="idea_outline col-4 text-end mt-4 fs-3 text-light fw-bolder">
                    <p> <?php echo $idea->getNumberOfVotes() ?> vote(s)</p>
                </div>
            </div>
        </div>
    </div>

<?php } }?>
<!-- ***************************************************** And of ideas ***************************************************** -->


