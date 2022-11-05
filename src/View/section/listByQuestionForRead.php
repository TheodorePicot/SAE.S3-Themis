<?php
$count = 1;
foreach ($sections as $section) : ?>

    <h3> Section <?=$count?> </h3>
     <p><?=$section->getTitreSection()?>
     <?=$section->getDescriptionSection()?></p>
<?php
$count++;
endforeach; ?>