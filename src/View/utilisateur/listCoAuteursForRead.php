<h4>Co-Auteurs</h4>
<?php foreach ($coAuteurs as $coAuteur): ?>
    <p><?= htmlspecialchars($coAuteur->getLogin()) ?></p>
<?php endforeach; ?>
