<p>
    <label for="votants">Votants</label> :
    <select name="votants[]" id="votants" multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <?php if ((new \Themis\Model\Repository\VotantRepository)->isParticpantInQuestion($utilisateur->getLogin(), $question->getIdQuestion())): ?>
                <option value="<?= $utilisateur->getLogin() ?>" selected><?= $utilisateur->getLogin() ?></option>
            <?php else: ?>
                <option value="<?= $utilisateur->getLogin() ?>"><?= $utilisateur->getLogin() ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</p>

