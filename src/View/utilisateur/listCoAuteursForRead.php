<h4>Co-Auteurs</h4>
<?php foreach ($coAuteurs as $coAuteur): ?>
    <?= htmlspecialchars($coAuteur->getLogin()) ?>
<?php endforeach; ?>
