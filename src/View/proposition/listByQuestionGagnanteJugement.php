<?php

use Themis\Model\Repository\JugementMajoritaireRepository;

$count = 1;
$valGagnante = 0;
$hasPrintedAutrePropo = false;

$tab = [
    0 => "A Rejeter",
    1 => "Insuffisant",
    2 => "Passable",
    3 => "Assez Bien",
    4 => "Bien",
    5 => "Très Bien"
];
foreach ($propositions as $proposition) :
$titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
$propositionInURL = rawurlencode($proposition->getIdProposition());
$questionInURL = rawurlencode($proposition->getIdQuestion());
$hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL";?>
    <?php if ($count == 1) :
    $valGagnante = $proposition->getValeurResultat();
    ?>
    <div class="d-flex align-content-center justify-content-center">
        <h1>Proposition(s) gagnante(s)</h1>
    </div>
<?php elseif ($proposition->getValeurResultat() != $valGagnante && !$hasPrintedAutrePropo) :
    $hasPrintedAutrePropo = true; ?>

    <div class="d-flex align-content-center justify-content-center">
        <h1>Les autres propositions</h1>
    </div>
<?php endif;
    $count++ ?>
    <div class="boxProposition overflow-hidden rounded-5 my-3 d-flex align-items-center">
        <a id="containerQuestion" href="<?= $hrefRead ?>">
            <div class="mx-3">
                <h5><?= $titrePropositionHTML ?> - Mention : <?= $tab[$proposition->getValeurResultat()] ?></h5>
            </div>
        </a>
    </div>
<?php endforeach; ?>