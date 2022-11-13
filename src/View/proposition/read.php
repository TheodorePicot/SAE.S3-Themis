<?php
$questionInURL = rawurlencode($question->getIdQuestion());


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

                <h3>Sections</h3>

                <?php
                $count = 1;
                foreach ($sections as $section) : ?>
                    <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
<!--                    <p>--><?//= htmlspecialchars($section->getDescriptionSection()) ?><!--</p>-->

                    <?php
                    foreach ($sectionsProposition as $sectionProposition) : ?>
                        <p><?= htmlspecialchars($sectionProposition->getTexteProposition()) ?></p>
                    <?php endforeach; ?>
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
