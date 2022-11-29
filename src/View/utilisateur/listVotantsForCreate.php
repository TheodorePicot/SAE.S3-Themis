<div class="col-auto">
<label  class="visually-hidden" for="votants"></label>
    <select class="form-select" name="votants[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
        <?php endforeach; ?>
    </select>
</div>

