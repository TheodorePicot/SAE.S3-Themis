<div class="col-auto">
    <label class="visually-hidden" for="coAuteurs"></label>
    <select class="form-select h-100" name="coAuteurs[]" id="autoSizingSelect" multiple>
        <?php foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new \Themis\Model\Repository\CoAuteurRepository())->isCoAuteurInProposition($utilisateur->getLogin(), $proposition->getIdProposition())): ?>
               <option value="<?= $loginHTML ?>" selected><?= $loginHTML ?></option>
            <?php elseif (!(new \Themis\Model\Repository\AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $proposition->getIdQuestion())): ?>
                <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>