<div id='containerListeQuestion' class = 'container my-5'>

<?php foreach ($questions as $question) :
    $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
?>
    <a id='containerQuestion' class = 'container ' href='<?=$hrefRead?>'>
       <div id='test' style='border:1px solid; border-radius: 5px' class='my-1'>
                <p> <?=$titreQuestionHTML?> </p>
       </div>
    </a>
<?php endforeach; ?>
</div>
