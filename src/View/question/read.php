<?php
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=$questionInURL";
$hrefUpdate = "frontController.php?action=update&idQuestion=$questionInURL";
$hrefCreateProposition = "frontController.php?controller=proposition&action=create&idQuestion=$questionInURL";
$hrefPropositions = "frontController.php?controller=proposition&action=readByQuestion&idQuestion=$questionInURL";

//$hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
$hrefReadAll = "frontController.php?action=readAll";
$lienRetourQuestion = "<a href=" . $hrefReadAll . ">Questions : </a>";
?>

<div class="containerQuestionRead d-flex">

    <!--    QUESTION + DELETE UPDATE-->
    <div class='container my-5'>
        <ul style='list-style: none'>
            <li>
                <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>
            </li>
            <li>
<!--                <div class="card card-body">-->
                    Description de la question : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
<!--                </div>-->
            </li>

            <?php require_once __DIR__ . "/../section/listByQuestionForRead.php" ?>

            <p>
                <a class="btn btn-primary" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Auteurs</a>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Votants</button>
<!--                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>-->
            </p>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <?php require_once __DIR__ . "/../utilisateur/listAuteursForRead.php" ?>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            <?php require_once __DIR__ . "/../utilisateur/listVotantsForRead.php" ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="containerButtonReadQuestion" class="d-flex">

                <a href='<?= $hrefDelete ?>'>
                    <div id="deleteButton" class="my-2" style='border:1px solid; border-radius: 4px;'>
                        <li>Supprimer</li>
                    </div>
                </a>
                <a href='<?= $hrefUpdate ?>'>
                    <div id="updateButton" class="my-2" style='border:1px solid; border-radius: 4px'>
                        <li>Mettre à jour</li>
                    </div>
                </a>
                <a href='<?= $hrefCreateProposition ?>'>
                    <div id="propositionButton" class="my-2" style='border:1px solid; border-radius: 4px'>
                        <li>Créer une Proposition</li>
                    </div>
                </a>
                <a href='<?= $hrefPropositions ?>'>
                    <div id="propositionButton" class="my-2" style='border:1px solid; border-radius: 4px'>
                        <li>Les soumissions</li>
                    </div>
                </a>
            </div>
        </ul>
    </div>

    <!--    CALENDRIER -->
    <div class="containerTime">
        <div class="wrapper">
            <h2> Calendrier</h2>
            <ul class="sessions">
                <li>
                    <div class="time"><b><?= htmlspecialchars($question->getDateDebutProposition()) ?></b></div>
                    <p> Date de début de proposition</p>
                </li>
                <li>
                    <div class="time"><b><?= htmlspecialchars($question->getDateFinProposition()) ?></b></div>
                    <p> Date de fin de rédaction de proposition</p>
                </li>
                <li>
                    <div class="time"><b><?= htmlspecialchars($question->getDateDebutVote()) ?></b></div>
                    <p>Date de début de vote </p>
                </li>
                <li>
                    <div class="time"><b><?= htmlspecialchars($question->getDateFinVote()) ?></b></div>
                    <p>Date de fin de vote</p>
                </li>
            </ul>
        </div>
    </div>


</div>


