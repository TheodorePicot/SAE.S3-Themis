<div class="col-auto">
    <label class="visually-hidden" for="coAuteurs"></label>
    <select class="form-select h-100" name="coAuteurs[]" id="autoSizingSelect" multiple>
        <?php foreach ($utilisateurs as $utilisateur) : ?>
            <?php if (!(new \Themis\Model\Repository\AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $_GET["idQuestion"])): ?>
                <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>

