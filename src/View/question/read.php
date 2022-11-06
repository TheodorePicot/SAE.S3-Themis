<?php
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
$hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;
$hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
$hrefReadAll = "frontController.php?action=readAll";
$lienRetourQuestion = "<a href=" . $hrefReadAll . ">Questions : </a>";
?>

<div class="containerPageQuestion">

    <!--    QUESTION + DELETE UPDATE-->
    <div class='container my-5'>
        <p>
        <ul style='list-style: none'>
            <li>
                <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>
            </li>
            <li>
                Description de la question : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
            </li>
            </p>


            <?php require_once __DIR__ . "/../section/listByQuestionForRead.php" ?>


            <div id="containerUpdateDelete">

                <a href='<?= $hrefDelete ?>'>
                    <div id="deleteButton" class="my-1" style='border:1px solid; border-radius: 4px;'>
                        <li>delete</li>
                    </div>
                </a>
                <a href='<?= $hrefUpdate ?>'>
                    <div id="updateButton" class="my-1" style='border:1px solid; border-radius: 4px'>
                        <li>update</li>
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


