<?php

use Themis\Lib\ConnexionUtilisateur;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;

?>
<div class="col-auto">
    <label class="visually-hidden" for="coAuteurs"></label>
    <select class="form-select h-100" name="coAuteurs[]" id="autoSizingSelect" <?php if((new CoAuteurRepository())->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $proposition->getIdQuestion())) echo "disabled"?> multiple>
        <?php foreach ($utilisateurs as $utilisateur):
            $loginHTML = htmlspecialchars($utilisateur->getLogin()); ?>
            <?php if ((new CoAuteurRepository())->isCoAuteurInProposition($utilisateur->getLogin(), $proposition->getIdProposition())): ?>
               <option value="<?= $loginHTML ?>" selected><?= $loginHTML ?></option>
            <?php elseif (!(new AuteurRepository)->isParticpantInQuestion($utilisateur->getLogin(), $proposition->getIdQuestion())): ?>
                <option value="<?= $loginHTML ?>"><?= $loginHTML ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>