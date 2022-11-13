<p>
    <label for="votants">Votants</label> :
    <select name="votants[]" id="votants" multiple>
        <?php foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new \Themis\Model\Repository\VotantRepository)->isParticpantInQuestion($utilisateur->getLogin(), $question->getIdQuestion())): ?>
                <option value="<?= $loginHTML ?>" selected><?= $loginHTML ?></option>
            <?php else: ?>
                <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</p>

