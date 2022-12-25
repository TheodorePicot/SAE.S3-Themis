<h4>Questions</h4>
<?php foreach ($questions as $question):
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;?>
    <a href="<?=$hrefRead?>">
    <p><?= htmlspecialchars($question->getTitreQuestion()) ?></p>
    </a>
<?php endforeach; ?>

