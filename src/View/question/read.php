<?php


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
        Date de fin de redaction de proposition : " . htmlspecialchars($question->getDateFinProposition())
    . "</li>"
    . " <li class=''>
        Date de début de vote : " . htmlspecialchars($question->getDateDebutVote())
    . "</li>"
    . "  <li class=''>
        Date de fin de vote : " . htmlspecialchars($question->getDateFinVote())
    . "</li>
        </p>
        </ul>
       </div>";

