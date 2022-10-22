<?php
echo "<p>
        Question : " . htmlspecialchars($question->getIdQuestion()) .
        " Date de début de proposition : " . htmlspecialchars($question->getDateDebutProposition()) .
        " Date de fin de redaction de proposition : " . htmlspecialchars($question->getDateFinProposition()) .
        " Date de début de vote : " . htmlspecialchars($question->getDateDebutVote()) .
        " Date de fin de vote : " . htmlspecialchars($question->getDateFinVote()) .
      "</p>";