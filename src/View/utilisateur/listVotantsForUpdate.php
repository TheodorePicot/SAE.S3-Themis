<div class="col-auto">
    <label  class="visually-hidden" for="votants"></label>
    <select class="form-select" name="votants[]" id="autoSizingSelect" required multiple>
        <?php use Themis\Model\Repository\VotantRepository;

        foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new VotantRepository)->isParticpantInQuestion($utilisateur->getLogin(), $question->getIdQuestion())):
                echo "test"?>
                <option value="<?= $loginHTML ?>"selected><?= $loginHTML ?></option>
            <?php else: ?>
                <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>