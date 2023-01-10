<h4>Questions</h4>
<?php foreach ($questions as $question):
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;?>
    <a href="<?=$hrefRead?>">
<?= htmlspecialchars($question->getTitreQuestion()) ?>
    </a>
<?php endforeach; ?>

