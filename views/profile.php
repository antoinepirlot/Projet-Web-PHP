
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