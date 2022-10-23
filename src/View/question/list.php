<?php

foreach ($questions as $question) {
    $questionInHTML = htmlspecialchars($question->getTitreQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;

    echo "<a href='$hrefRead'>";
    echo "<div id='test' class='mx-2 my-5 container-fluid' style='border:2px solid #cecece;'>
            <p> Question d\'ID . $questionInHTML </p>
          </div>
          </a>";


}
