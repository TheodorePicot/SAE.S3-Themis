<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;
use Themis\Model\Repository\SectionLikeRepository;
use Themis\Model\Repository\SectionPropositionRepository;

$idPropositionInURL = rawurlencode($proposition->getIdProposition());
$hrefDelete = "frontController.php?controller=proposition&action=delete&idProposition=$idPropositionInURL&idQuestion={$question->getIdQuestion()}";
$hrefUpdate = "frontController.php?controller=proposition&action=update&idProposition=$idPropositionInURL";
?>


<!-- QUESTION + PROPOSITION + DELETE UPDATE -->


<div class='container-fluid'>


    <div class="d-flex align-content-center justify-content-center my-5">
        <h1 style=""> <?= htmlspecialchars($proposition->getTitreProposition()) ?>
            - Proposition de <?= htmlspecialchars($proposition->getLoginAuteur()) ?></h1>
    </div>

    <div class="row my-5">
        <div class="container-fluid col-md-11">
            <div class="d-flex align-content-center justify-content-center">
                <h2>Plan de la question</h2>
            </div>

            <div class="my-4 mx-5">
                <?php
                $count = 1;
                foreach ($sections

                as $section) : ?>
                <div class="my-4">
                    <h4>Titre de la section <?= $count ?></h4>
                    <div class="shadowBox card card-body border-0 ">
                        <?= htmlspecialchars($section->getDescriptionSection()) ?>
                    </div>

                    <div class="my-5">
                        <h4 class="my-3">Proposition pour la section <?= $count ?> : </h4>
                        <div class="shadowBoxProposition card card-body border-0">
                            <?php $sectionProposition = (new SectionPropositionRepository())->selectByPropositionAndSection($idPropositionInURL, $section->getIdSection()) ?>
                            \ <?= htmlspecialchars($sectionProposition->getTexteProposition()) ?>
                            <?php $questionInURL = rawurlencode($question->getIdQuestion());
                            $login = htmlspecialchars(ConnexionUtilisateur::getConnectedUserLogin());
                            $idSectionPropositionInURL = $sectionProposition->getIdSectionProposition();
                            $nbVotes = (new SectionLikeRepository())->getNbLikeSection($sectionProposition->getIdSectionProposition()); ?>
                        </div>
<!--                        --><?php //if (ConnexionUtilisateur::isConnected() && (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $question->getIdQuestion())) : ?>
                        <div class="my-1">
                            <a class="nav-link"
                               href="frontController.php?action=like&controller=section&idSectionProposition=<?= $idSectionPropositionInURL ?>&idQuestion=<?= $questionInURL ?>&login=<?= $login ?>&idProposition=<?= $idPropositionInURL ?>">
                                <img class="likeImg" alt="compte" src="assets/img/like.png">
                                <?= $nbVotes ?> <small class="text-muted">like(s)</small>
                            </a>
                        </div>
<!--                        --><?php //endif ?>

                    </div>

                    <?php $count++;
                    endforeach; ?>
                </div>
            </div>

            <div class="d-flex align-content-center justify-content-center">
                <button class="btn btn-dark my-4 mx-5" type="button" data-bs-toggle="collapse"
                        data-bs-target="#coAuteurs" aria-expanded="false"
                        aria-controls="coAuteurs">Co-Auteurs
                </button>
            </div>


            <div class="collapse multi-collapse col-6 offset-3  " id="coAuteurs">
                <div class="card card-body">
                    <?php require_once __DIR__ . "/../utilisateur/listCoAuteursForRead.php" ?>
                </div>
            </div>


            <?php if (ConnexionUtilisateur::isConnected() &&
                ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdQuestion())
                    || (new CoAuteurRepository())->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition())) || ConnexionUtilisateur::isAdministrator()) : ?>
                <div class="my-2 d-flex align-content-center justify-content-center my-5">
                    <?php if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdQuestion()) &&
                        ConnexionUtilisateur::isUser($proposition->getLoginAuteur()) || ConnexionUtilisateur::isAdministrator()) : ?>
                        <a class="btn btn-primary text-nowrap" href='<?= $hrefDelete ?>'
                           onclick="return confirm('êtes-vous sûr de vouloir continuer ?');"> Supprimer</a>
                    <?php endif ?>
                    <a class="btn btn-primary text-nowrap mx-3" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
                </div>
            <?php endif ?>
        </div>
    </div>

</div>

