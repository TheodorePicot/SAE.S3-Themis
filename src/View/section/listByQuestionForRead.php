<?php
$count = 0;
foreach ($sections as $section) : ?>
    <h6> Section <?=$count?> </h6>
    <p> <?=$section->getTitreSection()?> </p>
    <p> <?=$section->getDescriptionSection()?> </p>
<?php
$count++;
endforeach; ?>