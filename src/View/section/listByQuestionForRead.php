<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\SectionLikeRepository;

$questionInURL = rawurlencode($question->getIdQuestion());
$login = htmlspecialchars(ConnexionUtilisateur::getConnectedUserLogin());
$count = 1;
foreach ($sections as $section) :
    $nbVotes = (new SectionLikeRepository())->getNbLikeSection($section->getIdSection());?>

<div class="my-4">    <h3><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
   <?= $parser->text(htmlspecialchars($section->getDescriptionSection())) ?>
        <a class="nav-link"
           href="frontController.php?action=like&controller=section&idSection=<?= $section->getIdSection()?>&idQuestion=<?=$questionInURL?>&login=<?=$login?>">
            <?=$nbVotes?>
            <img class="accountImg" alt="compte" src="assets/img/like.png">
        </a>

</div>

    <?php $count++;
endforeach; ?>