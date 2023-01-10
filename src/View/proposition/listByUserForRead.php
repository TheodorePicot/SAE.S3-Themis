<h4>Propositions</h4>
<?php foreach ($propositions as $proposition):
    $questionInURL = rawurlencode($proposition->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;?>
    <a href="<?=$hrefRead?>">
        <?= htmlspecialchars($proposition->getTitreProposition()) ?>
    </a>
<?php endforeach; ?>

