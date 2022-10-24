<?php

foreach ($questions as $question) {
    $titreQuestionHTML = htmlspecialchars($question->getTitreQuestion());
    $questionInURL = rawurlencode($question->getIdQuestion());
    $hrefRead = "frontController.php?action=read&idQuestion=" . $questionInURL;




    echo "<a id='containerQuestion' class = 'container ' href='$hrefRead'>";
        echo "<div id='test' class='my-5' style='border:2px solid #cecece;'>
                <p> $titreQuestionHTML </p>
              </div>
          </a>";
}
