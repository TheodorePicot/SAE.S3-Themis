<?php
foreach ($sections as $section) {

    echo "section d'id : " . $section->getIdSection();
    echo "<p><label for='titreSection" . $section->getIdSection() . "'>Le titre de la section</label> :
    <input type='text' placeholder='' value='". $section->getTitreSection() ."' name='titreSection". $section->getIdSection() ."' id='titreSection" . $section->getIdSection() . "' required/> </p>";

    echo "<p><label for='descriptionSection" . $section->getIdSection(). "'>La description de la section</label> : 
    <textarea placeholder='What is the hell in the frick' name='descriptionSection" . $section->getIdSection() . "' id='descriptionSection" . $section->getIdSection() . "' required rows='5' cols='40'>".
        $section->getDescriptionSection()
    ."</textarea></p>";
}