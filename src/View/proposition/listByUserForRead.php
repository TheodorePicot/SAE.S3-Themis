<h4>Propositions</h4>
<?php foreach ($propositions as $proposition):
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;?>
    <a href="<?=$hrefRead?>">
        <p><?= htmlspecialchars($proposition->getTitreProposition()) ?></p>
    </a>
<?php endforeach; ?>

