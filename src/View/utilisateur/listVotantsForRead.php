<h4>Votants</h4>
<?php foreach ($votants as $votant): ?>
    <p><?= htmlspecialchars($votant->getLogin()) ?></p>
<?php endforeach; ?>