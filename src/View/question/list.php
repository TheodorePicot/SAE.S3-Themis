<?php

foreach ($questions as $question) {
    $questionInHTML = htmlspecialchars($question->getIdQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;



    echo '
    <div id="test" class="mx-2 my-5 container-fluid" style="border:2px solid #cecece;">
   
    <p> Question d\'ID ' . " <a href='$hrefRead'>" . $questionInHTML . '</a>' . '</p>
    
    </div>';

}
