<?php

foreach ($questions as $question) {
    $questionInHTML = htmlspecialchars($question->getIdQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;




    echo "<a id='containerQuestion' class = container href='$hrefRead'>";
    echo "<div id='test' class='my-5' style='border:2px solid #cecece;'>
            <p> Question d'ID . $questionInHTML </p>
          </div>
          </a>";
}
