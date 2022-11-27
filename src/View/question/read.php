<?php
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=$questionInURL";
$hrefUpdate = "frontController.php?action=update&idQuestion=$questionInURL";
$hrefCreateProposition = "frontController.php?controller=proposition&action=create&idQuestion=$questionInURL";
$hrefPropositions = "frontController.php?controller=proposition&action=readByQuestion&idQuestion=$questionInURL";
$hrefVoter = "frontController.php?controller=vote&action=showPropositionsVote&idQuestion=$questionInURL";
//$hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
$hrefReadAll = "frontController.php?action=readAll";
$lienRetourQuestion = "<a href=" . $hrefReadAll . ">Questions : </a>";
?>

<div class="container-fluid">

    <!--    QUESTION + DELETE UPDATE-->

    <div class="d-flex align-content-center justify-content-center">
        <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>
    </div>

    <div class="row my-5 my-4 gy-4 container-fluid">

        <div class="container-fluid col-md-12 col-lg-8">
            <div class="card card-body border-0 rounded-4" style="background: #C7B198;">
                Description : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>

            </div>

            <div class="my-5">
                <?php require_once __DIR__ . "/../section/listByQuestionForRead.php" ?>
            </div>

            <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
               aria-expanded="false" aria-controls="multiCollapseExample1">Auteurs</a>
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#multiCollapseExample2" aria-expanded="false"
                    aria-controls="multiCollapseExample2">Votants
            </button>
            <!--                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>-->


            <div class="row my-4">
                <div class="collapse multi-collapse col-6" id="multiCollapseExample1">
                    <div class="card card-body">
                        <?php require_once __DIR__ . "/../utilisateur/listAuteursForRead.php" ?>
                    </div>
                </div>

                <div class="collapse multi-collapse col-6" id="multiCollapseExample2">
                    <div class="card card-body">
                        <?php require_once __DIR__ . "/../utilisateur/listVotantsForRead.php" ?>
                    </div>
                </div>
            </div>

            <div class="my-4">
                <a class="btn btn-dark text-nowrap" href='<?= $hrefDelete ?>'> Supprimer</a>
                <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
                <a class="btn btn-dark text-nowrap" href='<?= $hrefVoter ?>'> Voter</a>
            </div>
        </div>


        <!--    CALENDRIER -->
        <div class="container d-flex containerTime col-md-12 col-lg-3 mx-3">
            <div class="wrapper">
                <h2> Calendrier</h2>
                <ul class="sessions">
                    <li>
                        <div class="time"><b><?= htmlspecialchars($question->getDateDebutProposition()) ?></b></div>
                        <p> Date de début de proposition </p>
                    </li>
                    <li>
                        <div class="time"><b><?= htmlspecialchars($question->getDateFinProposition()) ?></b></div>
                        <p> Date de fin de rédaction de proposition </p>
                    </li>
                    <li>
                        <div class="time"><b><?= htmlspecialchars($question->getDateDebutVote()) ?></b></div>
                        <p>Date de début de vote</p>
                    </li>
                    <li>
                        <div class="time"><b><?= htmlspecialchars($question->getDateFinVote()) ?></b></div>
                        <p>Date de fin de vote</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container-fluid col-md-12 col-lg-10 my-5">

            <?php require_once __DIR__ . "/../proposition/listByQuestion.php" ?>
        </div>

    </div>
</div>


