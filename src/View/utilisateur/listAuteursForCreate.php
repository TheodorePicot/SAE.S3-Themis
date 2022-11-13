<p>
    <label for="auteurs">Auteurs</label> :
    <select name="auteurs[]" id="auteurs" multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
        <?php endforeach; ?>
    </select>
</p>

