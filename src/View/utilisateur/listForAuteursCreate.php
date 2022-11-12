<p>
    <label for="auteurs">Auteurs</label> :
    <select name="auteurs[]" id="auteurs" multiple>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <option value="<?= $utilisateur->getLogin() ?>"><?= $utilisateur->getLogin() ?></option>
        <?php endforeach; ?>
    </select>
</p>

