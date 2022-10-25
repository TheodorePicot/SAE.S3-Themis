<?php
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
$hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;

echo "
        <div class='container-fluid'>
        <p>
        <ul style='list-style: none'>
        <li class=''>
        Question : " . htmlspecialchars($question->getIdQuestion())
    . "</li>"
    . " <li class=''>
        Date de début de proposition : " . htmlspecialchars($question->getDateDebutProposition())
    . "</li>"
    . " <li class=''>
        Date de fin de rédaction de proposition : " . htmlspecialchars($question->getDateFinProposition())
    . "</li>"
    . " <li class=''>
        Date de début de vote : " . htmlspecialchars($question->getDateDebutVote())
    . "</li>"
    . "  <li class=''>
        Date de fin de vote : " . htmlspecialchars($question->getDateFinVote())
    . "</li>
        <li> <a href='$hrefDelete'>delete</a> </li>
        <li> <a href='$hrefUpdate'>update</a> </li>
        </p>
        </ul>
       </div>";

