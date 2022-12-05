<div class="col-auto">
    <label class="visually-hidden" for="auteurs"></label>
    <select class="form-select h-100" name="auteurs[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new \Themis\Model\Repository\CoAuteurRepository())->isCoAuteurInProposition($utilisateur->getLogin(), $question->getIdQuestion())): ?>
            <option value="<?= $loginHTML ?>" selected><?= $loginHTML ?></option>
        <?php else: ?>
            <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
        <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>a