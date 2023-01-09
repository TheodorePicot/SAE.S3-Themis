<?php

use Themis\Controller\ControllerProposition;
use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\AuteurRepository;

?>

    <div class="d-flex align-content-center justify-content-center">
        <h1>Liste des propositions</h1>
    </div>

<?php

if (ConnexionUtilisateur::isConnected() && (new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_REQUEST["idQuestion"]) &&
    ($question->getDateDebutProposition() <= date_create()->format("Y-m-d H:i:s") && date_create()->format("Y-m-d H:i:s") < $question->getDateFinProposition())) : ?>
    <div class="d-flex align-content-center justify-content-center my-3">
        <a class="btn btn-dark text-nowrap"
           href="frontController.php?controller=proposition&action=create&idQuestion=<?= rawurldecode($question->getIdQuestion()) ?>">+
            Ajouter une proposition</a>
    </div>
<?php endif ?>



<?php foreach ($propositions as $proposition) :
    if (ConnexionUtilisateur::isConnected() && (new ControllerProposition())->hasReadAccess($question, $proposition)) :
    $titrePropositionHTML = htmlspecialchars($proposition->getTitreProposition());
    $propositionInURL = rawurlencode($proposition->getIdProposition());
    $questionInURL = rawurlencode($proposition->getIdQuestion());
    $hrefRead = "frontController.php?controller=proposition&action=read&idQuestion=$questionInURL&idProposition=$propositionInURL"; ?>
    <div class="boxProposition overflow-hidden rounded-5 my-3 d-flex align-items-center">
        <a id="containerQuestion" href="<?= $hrefRead ?>">
            <div class="mx-3">
                <h5><?= $titrePropositionHTML ?></h5>
            </div>
        </a>
    </div>
<?php endif; endforeach; ?>