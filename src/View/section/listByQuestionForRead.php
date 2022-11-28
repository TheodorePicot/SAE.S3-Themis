<?php
$count = 1;
foreach ($sections as $section) : ?>
    <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
    <p><?= htmlspecialchars($section->getDescriptionSection()) ?></p>
<?php $count++;
endforeach; ?>