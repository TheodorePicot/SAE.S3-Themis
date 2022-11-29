
<div class="col-auto">
    <label class="visually-hidden" for="auteurs"></label>
    <select class="form-select" name="auteurs[]" id="autoSizingSelect" required multiple>
        <?php foreach ($utilisateurs

                       as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>

        <?php endforeach; ?>
    </select>
</div>

