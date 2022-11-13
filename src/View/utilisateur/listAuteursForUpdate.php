<p>
    <label for="auteurs">Auteurs</label> :
    <select name="auteurs[]" id="auteurs" multiple>
        <?php foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new \Themis\Model\Repository\AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $question->getIdQuestion())): ?>
                <option value="<?= $loginHTML ?>" selected><?= $loginHTML ?></option>
            <?php else: ?>
                <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</p>