<?php
$count = 1;
foreach ($sections as $section) : ?>
<div class="my-4">    <h3><p><?= $count . ". " . htmlspecialchars($section->getTitreSection()) ?></h3>
    <p><?= htmlspecialchars($section->getDescriptionSection()) ?></p>
</div>

    <?php $count++;
endforeach; ?>