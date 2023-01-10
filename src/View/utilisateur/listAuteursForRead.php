<div class="my-4">

    <?php use Themis\Model\Repository\AuteurRepository;


    foreach ($auteurs as $auteur): ?>
     <?= htmlspecialchars($auteur->getLogin()) ?>

    <?php endforeach; ?>

    <?php if (count($auteurs) == 0): ?>

            Il n'y a pas d'auteurs dont le pseudo contient '<?= $_REQUEST['searchValue'] ?>'

    <?php endif ?>

    <?php if (count((new AuteurRepository())->selectAllByQuestion($question->getidQuestion())) > 10): ?>

            ...

    <?php endif ?>

</div>

