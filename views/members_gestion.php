<section>

<!--*************************************************Title***********************************************************-->
    <h1 id="admin_title">Gestion des membres</h1>

<!--*************************************************Table***********************************************************-->
    <h5 class="notification">Il y a <?php echo $nbMembers?> membre(s)</h5><br>

    <h5 class="notification <?php echo $alertType;?>"><?php echo $notification;?></h5><br>

    <div id="admin_table" class="table-responsive">
        <table class="table table-striped w-auto table-bordered">
            <thead>
                <tr>
                    <th>Pseudos</th>
                    <th>Emails</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Décider du sort des membres</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($members as $i => $member){ ?>
                    <tr>

                        <!--Member's username-->
                        <td><span class="line"><?php echo $member->getHtmlUsername();?></span></td>

                        <!--Member's email-->
                        <td><?php echo $member->getHtmlEmail();?></td>

                        <!--Member's type-->
                        <td><?php echo $member->getFrenchType();?></td>
                        <td>

                            <!--Member's status (disabled or active)-->
                            <?php if($member->isDisabled() == 1){
                                #The member is disabled
                                echo "Désactivé";
                            }else{
                                #The member is active
                                echo "Actif";
                            }?>
                        </td>
                        <td>

                            <!--Form-->
                            <?php if($member->getHtmlEmail() != EMAIL){ ?>
                                <!--Not the current member-->
                                <form action="index.php?action=members_gestion" method="post">

                                    <!--Disable-->
                                    <?php if(!$member->isDisabled()){?>
                                        <input type="radio" name="action_on_member" value="disable">Désactiver<br>

                                    <!--Activate-->
                                    <?php }else{?>
                                        <input type="radio" name="action_on_member" value="activation">Activer<br>

                                    <!--Set admin-->
                                    <?php }?>
                                    <?php if($member->getType() == "member"){?>
                                        <input type="radio" name="action_on_member" value="admin">Admin<br>

                                    <!--Set member-->
                                    <?php }else{?>
                                        <input type="radio" name="action_on_member" value="member">Membre<br>
                                    <?php }?>

                                    <input type="hidden" name="member_id" value="<?php echo $member->getId();?>">
                                    <input type="submit" name="form_members_gestion" value="Appliquer les changements">
                                </form>

                            <?php }else{?>
                                <!--This is the current member-->
                                <p class="notification alert-danger">Aucune action n'est autorisée pour votre compte</p>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</section>