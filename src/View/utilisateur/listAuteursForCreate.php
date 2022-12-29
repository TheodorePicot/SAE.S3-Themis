<div class="col-auto">
    <label class="visually-hidden" for="auteurs"></label>
    <select class="form-select h-100" name="auteurs[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs
                       as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" <?php if (isset($_SESSION["createQuestion"]["auteurs"]) && in_array($utilisateur->getLogin(), $_SESSION["createQuestion"]["auteurs"])) echo "selected" ?>><?= htmlspecialchars($utilisateur->getLogin()) ?></option>

        <?php endforeach; ?>
    </select>
</div>

