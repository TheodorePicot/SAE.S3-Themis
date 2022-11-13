<h4>Auteurs</h4>
<?php foreach ($auteurs as $auteur): ?>
    <p><?= htmlspecialchars($auteur->getLogin()) ?></p>
<?php endforeach; ?>