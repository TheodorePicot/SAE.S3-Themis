<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\VotantRepository;

$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=$questionInURL";
$hrefUpdate = "frontController.php?action=update&idQuestion=$questionInURL";
$hrefCreateProposition = "frontController.php?controller=proposition&action=create&idQuestion=$questionInURL";
$hrefPropositions = "frontController.php?controller=proposition&action=readByQuestion&idQuestion=$questionInURL";
$hrefVoter = "frontController.php?controller=vote&action=showPropositionsVote&idQuestion=$questionInURL";
//$hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
$hrefReadAll = "frontController.php?action=readAll";
$lienRetourQuestion = "<a href=" . $hrefReadAll . ">Questions : </a>";
$date = date_create();

?>

<div class="container-fluid">

    <!--    QUESTION + DELETE UPDATE-->

    <div class="d-flex align-content-center justify-content-center my-5">
        <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?> - <?= $question->getLoginOrganisateur() ?></h1>
    </div>

    <div class="row my-5 my-4 gy-4 container-fluid">
        <div class="container-fluid col-md-12 col-lg-8">
            <div class="shadowBox card card-body border-0 rounded-4">
                <div class="mx-2">
                    <?= $parser->text(htmlspecialchars($question->getDescriptionQuestion())) ?>
                </div>
            </div>

            <div class="d-flex align-content-center justify-content-center my-3">
                <h2 class="my-3"> Plan de la question</h2>
            </div>

            <div class="my-3">
                <?php require_once __DIR__ . "/../section/listByQuestionForRead.php" ?>
            </div>

            <a class="btn btn-dark" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button"
               aria-expanded="false" aria-controls="multiCollapseExample1">Auteurs</a>
            <button class="btn btn-dark" type="button" data-bs-toggle="collapse"
                    data-bs-target="#multiCollapseExample2" aria-expanded="false"
                    aria-controls="multiCollapseExample2">Votants
            </button>
            <!--                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">Toggle both elements</button>-->

            <div class="row my-4">
                <div class="collapse multi-collapse col-sm-12 col-lg-6 <?= isset($_REQUEST["hasSearchedAuteurs"]) ? "show" : "" ?>"
                     id="multiCollapseExample1">
                    <div class="card card-body">
                        <div class="row">
                            <div class="d-flex align-content-center justify-content-center">
                                <h4>Auteurs</h4>
                            </div>
                            <form method="post" class="d-flex">
                                <input required class="form-control me-2" type="search" name="searchValue"
                                       placeholder="auteurs"
                                       aria-label="Search">
                                <input type="hidden" name="hasSearchedAuteurs" value="true">
                                <button class="btn btn-dark text-nowrap" name='action'
                                        value='readAllAuteursBySearchValue'
                                        type="submit">Rechercher
                                </button>
                            </form>
                        </div>
                        <?php require_once __DIR__ . "/../utilisateur/listAuteursForRead.php" ?>
                    </div>
                </div>

                <div class="collapse multi-collapse col-sm-12 col-lg-6 my-3 my-lg-0 <?= isset($_REQUEST["hasSearchedVotants"]) ? "show" : "" ?>"
                     id="multiCollapseExample2">
                    <div class="card card-body">
                        <div class="row">
                            <div class="d-flex align-content-center justify-content-center">
                                <h4>Votants</h4>
                            </div>
                            <form method="post" class="d-flex">
                                <input required class="form-control me-2" type="search" name="searchValue"
                                       placeholder="votants"
                                       aria-label="Search">
                                <input type="hidden" name="hasSearchedVotants" value="true">
                                <button class="btn btn-dark text-nowrap" name='action'
                                        value='readAllVotantsBySearchValue'
                                        type="submit">Rechercher
                                </button>
                            </form>
                        </div>
                        <?php require_once __DIR__ . "/../utilisateur/listVotantsForRead.php" ?>
                    </div>
                </div>
            </div>

            <?php if (ConnexionUtilisateur::isUser($question->getLoginOrganisateur()) || ConnexionUtilisateur::isAdministrator()) : ?>
                <div class="my-4">
                    <a class="btn btn-dark text-nowrap" href="<?= $hrefDelete ?>"
                       onclick="return confirm('Are you sure?');"> Supprimer</a>
                    <?php if (date_create()->format("Y-m-d H:i:s") < $question->getDateDebutProposition() || ConnexionUtilisateur::isAdministrator()) : ?>
                        <a class="btn btn-dark text-nowrap" href="<?= $hrefUpdate ?>"> Mettre à jour</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>


        <!--    CALENDRIER -->

        <div class="container d-flex containerTime col-md-12 col-lg-3 mx-3">
            <div class="">
                <h2> Calendrier</h2>
                <ul class="sessions">
                    <li>
                        <div class="time">
                            <b><?= htmlspecialchars(date("d-M-y G:i", strtotime($question->getDateDebutProposition()))) ?></b>
                        </div>
                        <?php if ($date->format("Y-m-d H:i:s") < $question->getDateFinProposition() && $date->format("Y-m-d H:i:s") >= $question->getDateDebutProposition()): ?>
                            <mark>Date de début de proposition</mark>
                        <?php else : ?>
                            <p>Date de début de proposition</p>
                        <?php endif ?>

                    </li>
                    <li>
                        <div class="time">
                            <b><?= htmlspecialchars(date("d-M-y G:i", strtotime($question->getDateFinProposition()))) ?></b>
                        </div>
                        <?php if ($date->format("Y-m-d H:i:s") < $question->getDateDebutVote() && $date->format("Y-m-d H:i:s") >= $question->getDateFinProposition()) : ?>
                            <mark>Date de fin de rédaction de proposition</mark>
                        <?php else : ?>
                            <p> Date de fin de rédaction de proposition </p>
                        <?php endif ?>

                    </li>
                    <li>
                        <div class="time">
                            <b><?= htmlspecialchars(date("d-M-y G:i", strtotime($question->getDateDebutVote()))) ?></b>
                        </div>
                        <?php if ($date->format("Y-m-d H:i:s") < $question->getDateFinVote() && $date->format("Y-m-d H:i:s") >= $question->getDateDebutVote()) : ?>
                            <mark>Date de début de vote</mark>
                        <?php else : ?>
                            <p> Date de début de vote </p>
                        <?php endif ?>
                    </li>
                    <li>
                        <div class="time">
                            <b><?= htmlspecialchars(date("d-M-y G:i", strtotime($question->getDateFinVote()))) ?></b>
                        </div>
                        <?php if ($date->format("Y-m-d H:i:s") > $question->getDateFinVote()) : ?>
                            <mark>Date de fin de vote</mark>
                        <?php else : ?>
                            <p>Date de fin de vote </p>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid col-md-12 col-lg-10 my-5">

            <?php

            if ($date->format("Y-m-d H:i:s") < $question->getDateFinVote())
                require_once __DIR__ . "/../proposition/listByQuestion.php";
            else
                require_once __DIR__ . "/../proposition/listByQuestionGagnante.php";
            ?>

        </div>

        <?php if (ConnexionUtilisateur::isConnected() && (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting()) &&
                (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $question->getIdQuestion()) &&
                $date->format("Y-m-d H:i:s") < $question->getDateFinVote() && $date->format("Y-m-d H:i:s") >= $question->getDateDebutVote())) : ?>
            <div class="d-flex align-content-center justify-content-center my-3">
                <a class="btn btn-dark text-nowrap w-25"
                   href="frontController.php?controller=vote&action=vote&idQuestion=<?= $question->getIdQuestion() ?>">Voter</a>
            </div>

        <?php endif ?>
    </div>
</div>


