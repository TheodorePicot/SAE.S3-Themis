<?php
$idPropositionInURL = rawurlencode($proposition->getIdProposition());
$hrefDelete = "frontController.php?controller=proposition&action=delete&idProposition=" . $idPropositionInURL;
$hrefUpdate = "frontController.php?controller=proposition&action=update&idProposition=" . $idPropositionInURL;
?>
<div class="containerQuestionRead d-flex">
    <!--    QUESTION + PROSITION + DELETE UPDATE-->
    <div class='container my-5'>
        <ul style='list-style: none'>
            <li>
                <h1> <?= htmlspecialchars($question->getTitreQuestion()) ?></h1>
            </li>
            <li>
                Description de la question : <?= htmlspecialchars($question->getDescriptionQuestion()) ?>
            </li>

            <p>
            <h4>TitreProposition : </h4>
            <p><?= $proposition->getTitreProposition() ?></p>
            </p>

            <h3>Sections</h3>

            <?php
            $count = 1;
            foreach ($sections as $section) : ?>
                <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
                <p><?= htmlspecialchars($section->getDescriptionSection()) ?></p>

                <p><?= (new \Themis\Model\Repository\SectionPropositionRepository)->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection())->getTexteProposition() ?></p>
                <?php $count++;
            endforeach; ?>


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
            </div>
        </ul>
    </div>
</div>
