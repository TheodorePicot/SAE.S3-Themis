<?php

foreach ($questions as $question) {
    $questionInHTML = htmlspecialchars($question->getIdQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;
    $hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
    $hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;


    echo '
    <div id="test" class="mx-2 my-5 container-fluid" style="border:2px solid #cecece;">
   
    <p> Question d\'ID ' . " <a href='$hrefRead'>" . $questionInHTML . '</a>' . " <a href='$hrefDelete'>delete</a>" . " <a href='$hrefUpdate'>update</a>" . '</p>
    
    </div>';

}
