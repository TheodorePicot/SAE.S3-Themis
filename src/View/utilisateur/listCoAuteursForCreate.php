<div class="col-auto">
    <select class="form-select h-100" name="coAuteurs[]" id="autoSizingSelect" multiple>
        <?php use Themis\Model\Repository\AuteurRepository;

        foreach ($utilisateurs as $utilisateur) : ?>
            <?php if (!(new AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $_REQUEST["idQuestion"])): ?>
                <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>

