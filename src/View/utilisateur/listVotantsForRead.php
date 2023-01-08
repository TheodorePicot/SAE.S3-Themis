<div class="my-4">

    <?php use Themis\Model\Repository\VotantRepository;

    foreach ($votants as $votant): ?>
        <p><?= htmlspecialchars($votant->getLogin()) ?></p>

    <?php endforeach; ?>

    <?php if (count($votants) == 0 ): ?>
        <p>
            Il n'y a pas de votants dont le pseudo contient '<?=$_REQUEST['searchValue']?>'
        </p>
    <?php endif ?>

    <?php if (count((new VotantRepository())->selectAllByQuestion($question->getidQuestion())) > 10): ?>
        <p>
            ...
        </p>
    <?php endif ?>

</div>
