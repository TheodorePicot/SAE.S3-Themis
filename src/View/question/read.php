<?php
$questionInURL = rawurlencode($question->getIdQuestion());
$hrefDelete = "frontController.php?action=delete&idQuestion=" . $questionInURL;
$hrefUpdate = "frontController.php?action=update&idQuestion=" . $questionInURL;
$hrefReadAll = "frontController.php?action=readAll";


echo "<div class='container text-center my-5' >";


$lienRetourQuestion = "<a href=".$hrefReadAll.">Questions : </a>";

echo "
       
        <p>
        <ul style='list-style: none'>
        <li class=''>
      ". $lienRetourQuestion .htmlspecialchars($question->getIdQuestion())
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
        <div id='containerDeleteUpdate'>
        <li> <a href='$hrefDelete'>delete</a> </li>
        <li> <a href='$hrefUpdate'>update</a> </li>
        </div>
        </p>
        </ul>
      ";

echo "</div>";

