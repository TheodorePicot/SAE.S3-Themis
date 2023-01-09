<div class="col-auto" style="height: 250px">
    <label class="visually-hidden" for="auteurs"></label>
    <select class="form-select h-100" name="auteurs[]" id="autoSizingSelect" required multiple>
        <?php
        $count = 0;
        foreach ($utilisateurs
                       as $utilisateur):
            $count++?>
            <option value="<?= htmlspecialchars($utilisateur->getLogin()) ?>" <?php if (isset($_SESSION["formData"]["auteurs"]) && in_array($utilisateur->getLogin(), $_SESSION["formData"]["auteurs"])) unset($_SESSION['formData']["auteurs"]);echo "selected" ?>><?= htmlspecialchars($utilisateur->getLogin()) ?></option>

        <?php endforeach; ?>
    </select>
</div>

