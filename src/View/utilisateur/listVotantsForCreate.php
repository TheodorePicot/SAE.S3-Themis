<p>
    <label for="votants">Votants</label> :
    <select name="votants[]" id="votants" multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>"><?= htmlspecialchars($utilisateur->getLogin()) ?></option>
        <?php endforeach; ?>
    </select>
</p>

