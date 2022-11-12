<h4>Votants</h4>
<?php foreach ($votants as $votant): ?>
    <p><?= $votant->getLogin() ?></p>
<?php endforeach; ?>