<div id='containerListeQuestion' class ='container-fluid my-5'>

<?php foreach ($questions as $question) :
    $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
?>

    <a id='containerQuestion' class = container-fluid' href='<?=$hrefRead?>'>
       <div id ="question" class="box my-2" style=' border-radius: 10px'>
                <h5><p> <?=$titreQuestionHTML?> </p></h5>
       </div>
    </a>

<?php endforeach;?>
</div>
