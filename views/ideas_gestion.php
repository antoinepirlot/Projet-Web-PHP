<section>

<!--*************************************************Title***********************************************************-->
    <h1 id="admin_title">Gestion des idées</h1>

<!--*************************************************Table***********************************************************-->
    <h5 class="notification">Il y a <?php echo $nbIdeas;?> idée(s)</h5><br>

    <h5 class="notification <?php echo $alertType;?>"><?php echo $notification;?></h5><br>

    <?php if($nbIdeas > 0){?>
        <div id="admin_table" class="table-responsive">
            <table class="table table-striped w-auto table-bordered">
                <thead>
                    <tr>
                        <th>Membre</th>
                        <th>Idées</th>
                        <th>Date de soumission</th>
                        <th>Date d'acceptation</th>
                        <th>Date de refus</th>
                        <th>Date de fermeture</th>
                        <th>Statut</th>
                        <th>Changer le statut</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($ideas as $i => $idea) { ?>
                        <tr>
                            <td><?php echo $idea->getMember()->getHtmlUsername();?></td>
                            <td><?php echo $idea->getHtmlText();?></td>
                            <td><?php echo $idea->formattedSubmittedDate();?></td>
                            <td><?php echo $idea->formattedAcceptedDate();?></td>
                            <td><?php echo $idea->formattedRefusedDate();?></td>
                            <td><?php echo $idea->formattedClosedDate();?></td>
                            <td><?php echo $idea->getFrenchStatus();?></td>
                            <td>
                                <?php if($idea->getStatus() != "Closed"){?>
                                    <!--The idea isn't closed-->
                                    <form action="index.php?action=ideas_gestion" method="post">

                                        <!-- Button to accept the idea-->
                                        <?php if($idea->getStatus() != "Accepted"){?>
                                        <input type="radio" name="new_status" value="Accepted">Accepter<br>
                                        <?php }?>

                                        <!-- Button to refuse the idea-->
                                        <?php if($idea->getStatus() != "Refused"){?>
                                        <input type="radio" name="new_status" value="Refused">Refuser<br>
                                        <?php }?>

                                        <!-- Button to submit the idea-->
                                        <?php if($idea->getStatus() != "Submitted"){?>
                                        <input type="radio" name="new_status" value="Closed">Fermer<br>
                                        <?php }?>

                                        <input type="hidden" name="idea_id" value="<?php echo $idea->getIdeaId();?>">
                                        <input type="submit" name="form_ideas_gestion" value="Appliquer les changements">
                                    </form>

                                <?php }else{?>
                                    <!-- The idea is closed-->
                                    <p class="notification alert-info">Cette idée est fermée, elle ne peut plus être ouverte</p>
                                <?php }?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php }?>
</section>