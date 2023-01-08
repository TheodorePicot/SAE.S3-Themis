<div class="my-4">

    <?php use Themis\Model\Repository\AuteurRepository;


    foreach ($auteurs as $auteur): ?>
        <p><?= htmlspecialchars($auteur->getLogin()) ?></p>

    <?php endforeach; ?>

    <?php if (count($auteurs) == 0): ?>
        <p>
            Il n'y a pas d'auteurs dont le pseudo contient '<?= $_REQUEST['searchValue'] ?>'
        </p>
    <?php endif ?>

    <?php if (count((new AuteurRepository())->selectAllByQuestion($question->getidQuestion())) > 10): ?>
        <p>
            ...
        </p>
    <?php endif ?>

</div>

