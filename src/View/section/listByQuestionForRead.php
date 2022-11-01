<?php
foreach ($sections as $section) {

    echo "section d'id : " . $section->getIdSection();
    echo "<p> Titre : " . $section->getTitreSection()."</p>";
    echo "<p> Description : " . $section->getDescriptionSection()."</p>";

}