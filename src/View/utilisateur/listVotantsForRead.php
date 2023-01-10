<div class="my-4">

    <?php use Themis\Model\Repository\VotantRepository;

    foreach ($votants as $votant): ?>
     <?= htmlspecialchars($votant->getLogin()) ?>

    <?php endforeach; ?>

    <?php if (count($votants) == 0 ): ?>

            Il n'y a pas de votants dont le pseudo contient '<?=$_REQUEST['searchValue']?>'

    <?php endif ?>

    <?php if (count((new VotantRepository())->selectAllByQuestion($question->getidQuestion())) > 10): ?>

            ...

    <?php endif ?>

</div>
