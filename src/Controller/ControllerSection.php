<?php

namespace Themis\Controller;

use Themis\Controller\AbstractController;
use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\SectionLike;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionLikeRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\VotantRepository;

class ControllerSection extends AbstractController{

    public function like(): void
    {
        $like = new SectionLike($_REQUEST["login"], $_REQUEST["idSection"]);
        $question = (new QuestionRepository())->select($_REQUEST["idQuestion"]);
        $idQuestion = $question->getIdQuestion();
        if (!(new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion)){
            (new FlashMessage)->flash("pasLeDroitLike", "Les like sont réservés aux votants", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=read&controller=question&idQuestion=$idQuestion");
        }
        if ((new SectionLikeRepository())->votantHasAlreadyLikedForSection($_REQUEST["login"], $_REQUEST["idSection"])){
            (new SectionLikeRepository())->delete($_REQUEST["login"], $_REQUEST["idSection"]);
            (new FlashMessage)->flash("DisLikeSuccess", "Votre dislike a bien été pris en compte", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&controller=question&idQuestion=$idQuestion");
        }
        else{
            (new SectionLikeRepository())->create($like);
            (new FlashMessage)->flash("LikeSuccess", "Votre like a bien été pris en compte", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&controller=question&idQuestion=$idQuestion");
        }


    }

}
