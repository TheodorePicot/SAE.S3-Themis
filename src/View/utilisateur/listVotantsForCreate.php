<div class="col-auto">
<label  class="visually-hidden" for="votants"></label>
    <select class="form-select h-100" name="votants[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" <?php if (isset($_SESSION["formData"]["createQuestion"]["votants"]) && in_array($utilisateur->getLogin(), $_SESSION["formData"]["createQuestion"]["votants"])) echo "selected" ?>><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
        <?php endforeach; ?>
    </select>
</div>