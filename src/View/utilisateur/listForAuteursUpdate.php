<p>
    <label for="auteurs">Auteurs</label> :
    <select name="auteurs[]" id="auteurs" multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <?php if ((new \Themis\Model\Repository\AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $question->getIdQuestion())): ?>
                <option value="<?= $utilisateur->getLogin() ?>" selected><?= $utilisateur->getLogin() ?></option>
            <?php else: ?>
                <option value="<?= $utilisateur->getLogin() ?>"><?= $utilisateur->getLogin() ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</p>