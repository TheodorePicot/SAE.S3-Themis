<h4>Auteurs</h4>
<?php foreach ($coAteurs as $coAuteur): ?>
    <p><?= htmlspecialchars($coAuteur->getLogin()) ?></p>
<?php endforeach; ?>