<?php
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
    $hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;
    $hrefCreateSection = "frontController.php?action=created&controller=section&idQuestion=$questionInURL";
    $hrefReadAll = "frontController.php?action=readAll";
    $lienRetourQuestion = "<a href=".$hrefReadAll.">Questions : </a>";
?>

<div class='container text-center my-5'>
    <ul style='list-style: none'>
        <li>
            <?= htmlspecialchars($question->getTitreQuestion()) ?>
        </li>
        <li>
            Description de la question : <?=htmlspecialchars($question->getDescriptionQuestion())?>
        </li>
         <li>
            Date de début de proposition : <?=htmlspecialchars($question->getDateDebutProposition())?>
        </li>
         <li>
            Date de fin de rédaction de proposition : <?=htmlspecialchars($question->getDateFinProposition())?>
        </li>
         <li>
            Date de début de vote : <?=htmlspecialchars($question->getDateDebutVote())?>
        </li>
        <li>
            Date de fin de vote : <?=htmlspecialchars($question->getDateFinVote())?>
        </li>
    </ul>

    <?php require_once __DIR__ . "/../section/listByQuestionForRead.php" ?>

    <div id='containerDeleteUpdate'>
        <ul style='list-style: none'>
            <li> <a href='<?=$hrefDelete?>'>delete</a> </li>
            <li> <a href='<?=$hrefUpdate?>'>update</a> </li>
        </ul>
    </div>

</div>


