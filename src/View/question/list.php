<?php

foreach ($questions as $question) {
    $questionInHTML = htmlspecialchars($question->getIdQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    echo $questionInURL;
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
    $hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
    $hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;


    echo '
    <div class="mx-2">
    <p> Question d\'ID ' . " <a href='$hrefRead'>" . $questionInHTML . '</a>' . " <a href='$hrefDelete'>delete</a>" . " <a href='$hrefUpdate'>update</a>" . '</p>
    </div>';

}
    echo "
<div class='mx-2'>
<a href=frontController.php?action=create>Créer Question</a>
</div>";

