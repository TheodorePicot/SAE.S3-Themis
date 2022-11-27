<?php
$count = 1;
foreach ($sections as $section) : ?>
    <h2><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h2>
    <p class=""><?= htmlspecialchars($section->getDescriptionSection()) ?></p>
<?php $count++;
endforeach; ?>