<?php
$count = 1;
foreach ($sections as $section) : ?>

<!--    <h3> Section --><?//=$count?><!-- </h3>-->
   <h3>  <p><?=$count.". ".$section->getTitreSection()?> </h3>
     <?=$section->getDescriptionSection()?></p>
<?php
$count++;
endforeach; ?>