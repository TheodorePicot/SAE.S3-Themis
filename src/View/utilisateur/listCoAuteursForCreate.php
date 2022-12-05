<div class="col-auto">
    <label class="visually-hidden" for="coAuteurs"></label>
    <select class="form-select h-100" name="coAuteurs[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs

                       as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>

        <?php endforeach; ?>
    </select>
</div>

