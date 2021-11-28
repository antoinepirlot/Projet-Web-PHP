<div id="home">
    <div class="container">
        <div class="col-lg-8">
        <!-- ***************************************************** website Title ***************************************************** -->
            <h1 class="text-center mb-5 pt-5 display-1" id="title_website"><a href="index.php"
                                                                              class="text-decoration-none text-light">
                    ModaYoung </a></h1>
        <!-- ***************************************************** end of website Title  *****************************************************  -->


        <!-- ***************************************************** notification *****************************************************  -->

            <p id="notice" class="fs-1 text-danger text-center"> <?php echo $notification ?></p>

        <!-- *****************************************************  end of notification ***************************************************** -->

            <div class="formHome container border border-dark border-4 rounded-3 text-dark fs-2 pt-3">

        <!-- ***************************************************** form loin  *****************************************************  -->
                <form method="post" action="index.php?action=login">

                    <!-- mail -->

                    <div class="mb-3">
                        <label class="form-label">Adresse mail:</label>
                        <input name="email" type="text" class="form-control form-control-lg border border-dark border-2"
                               placeholder="example@gmail.com">
                    </div>

                    <!-- end of mail -->

                    <!-- password -->

                    <div class="mb-3">
                        <label class="form-label">Mot de passe:</label>
                        <input name="password" type="password"
                               class="form-control form-control-lg border border-dark border-2"
                               placeholder="**********">
                    </div>

                    <!-- end of password -->

                    <!-- button login-->

                    <div class="text-center">
                        <input name="form_login" value="Se connecter" type="submit"
                               class="btn btn-lg btn-light bg-gradient fs-2 btn-outline-warning text-dark border border-dark rounded-pill">
                    </div>

                    <!-- end of button login-->
                </form>
        <!-- ***************************************************** end of form login ***************************************************** -->


        <!-- ***************************************************** redirection to the register form  ***************************************************** -->
                <div class="pt-3 mb-3">
                    <form action="index.php?action=register" method="post">
                        <p>Pas encore inscrit?
                            <!-- button register -->
                            <input type="submit" value="S'inscrire"
                                   class="btn btn-lg btn-light btn-outline-warning text-dark bg-gradient fs-3 border border-dark rounded-pill">
                            <!-- end of button register -->
                        </p>
                    </form>
                </div>
        <!-- ***************************************************** end of redirection to the register form ***************************************************** -->

            </div>
        </div>


    </div>
</div>