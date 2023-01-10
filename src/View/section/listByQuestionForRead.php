<?php
$count = 1;
foreach ($sections as $section) : ?>
<div class="my-4">    <h3><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
    <p><?= htmlspecialchars($section->getDescriptionSection()) ?>
</div>

    <?php $count++;
endforeach; ?>