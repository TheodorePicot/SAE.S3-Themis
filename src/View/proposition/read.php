<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\SectionPropositionRepository;

$idPropositionInURL = rawurlencode($proposition->getIdProposition());
$hrefDelete = "frontController.php?controller=proposition&action=delete&idProposition=$idPropositionInURL&idQuestion={$question->getIdQuestion()}";
$hrefUpdate = "frontController.php?controller=proposition&action=update&idProposition=$idPropositionInURL";
?>


<!--    QUESTION + PROPOSITION + DELETE UPDATE-->
<div class="d-flex align-content-center justify-content-center">
    <h1> Proposition pour : <?= htmlspecialchars($question->getTitreQuestion()) ?> - <?= $proposition->getLoginAuteur() ?></h1>
</div>

<div class='container-fluid'>
    <div class="row my-5 gy-4">
        <div class="container-fluid col-md-11">

            <div class="shadowBox card card-body border-0 col-md-10" style="background: #C7B198;">
                Description de la question : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
            </div>

            <div class="my-4">
                <h2>Titre de la proposition</h2>
                <p><?= $proposition->getTitreProposition() ?></p>
            </div>

            <h2>Sections</h2>

            <div class="my-4">
                <?php
                $count = 1;
                foreach ($sections

                as $section) : ?>
                <div class="my-4">

                    <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
                    <div class="shadowBox card card-body border-0 col-md-10" style="background: #C7B198;">
                        <?= htmlspecialchars($section->getDescriptionSection()) ?>
                    </div>

                    <div class="my-4">
                        <h4>Proposition pour la section <?= $count ?> : </h4>
                        <p><?= (new SectionPropositionRepository)->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection())->getTexteProposition() ?></p>
                        <?php $count++;
                        endforeach; ?>
                    </div>
                </div>
            </div>


            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                    data-bs-target="#coAuteurs" aria-expanded="false"
                    aria-controls="coAuteurs">Co-Auteurs
            </button>
            <div class="collapse multi-collapse col-6" id="coAuteurs">
                <div class="card card-body">
                    <?php require_once __DIR__ . "/../utilisateur/listCoAuteursForRead.php" ?>
                </div>
            </div>

            <?php if (ConnexionUtilisateur::isConnected() &&
                ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdQuestion())
                    || (new CoAuteurRepository())->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdProposition())) || ConnexionUtilisateur::isAdministrator()) : ?>
                <div class="">
                    <?php if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdQuestion())  &&
                        ConnexionUtilisateur::isUser($proposition->getLoginAuteur()) || ConnexionUtilisateur::isAdministrator()) : ?>
                        <a class="btn btn-dark text-nowrap" href='<?= $hrefDelete ?>'
                           onclick="return confirm('Are you sure?');"> Supprimer</a>
                    <?php endif ?>
                    <a class="btn btn-dark text-nowrap" href='<?= $hrefUpdate ?>'> Mettre à jour</a>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

