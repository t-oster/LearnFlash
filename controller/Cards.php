<?php
namespace Controller;
/**
 * Description of Cards
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Cards extends BaseCards{
  
  public function loadAdd($title = null)
  {
    $this->assignToView("title", $title != null ? $title : "");
  }

  public function loadDefault()
  {
    $cards = $this->cm->getCardsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("cards", $cards);
  }
  
  public function loadShow($cardId)
  { 
    $card = $this->findCardOrError($cardId);
    $this->assignToView("frontHtml", $this->replaceReferencesWithLinks($card->getFrontHtml()));
    $this->assignToView("backHtml", $this->replaceReferencesWithLinks($card->getBackHtml()));
    $this->assignToView("card", $card);
  }
  
  public function loadEdit($cardId)
  {
    $card = $this->findCardOrError($cardId);
    $this->assignToView("card", $card);
    $stringTags = "";
    foreach ($card->getTags() as $t)
    {
      $stringTags .= ($stringTags == "" ? "" : ", ") . $t->getName();
    }
    $this->assignToView("stringTags", $stringTags);
  }
  
  public function loadUpdate($cardId, $title, $frontHtml, $backHtml, $ajax, $tags)
  {
    $c = $this->cm->updateCard($cardId, $title, $frontHtml, $backHtml, explode(",",$tags));
    if ($ajax)
    {
      echo json_encode($c);
      $this->dontRender();
    }
    else
    {
      if ($c instanceof \Model\Card)
      {
        $this->addInfo("Card '".$c->getTitle()."' successfully updated");
        $this->redirect(null, "show", array("cardId" => $cardId));
      }
      else
      {
        $this->addError("Error: $c");
        $this->redirect(null, "edit", array("cardId" => $cardId));
      }
    }
  }
  
  public function loadCreate($title, $frontHtml, $backHtml, $ajax, $tags)
  {
    $cm = new \Manager\CardsManager();
    $c = $cm->createCard($this->getUserManager()->getLoggedInUser(), $title, $frontHtml, $backHtml, explode(",",$tags));
    if ($ajax)
    {
      echo json_encode($c);
      $this->dontRender();
    }
    else
    {
      if ($c instanceof \Model\Card)
      {
        $this->addInfo("Card '".$c->getTitle()."' successfully created");
        $this->redirect();
      }
      else
      {
        $this->addError("Error: $c");
        $this->redirect(null, "add");
      }
    }
  }
  
  public function loadDelete($cardId, $ajax)
  {
    $result = $this->cm->deleteById($cardId);
    if ($ajax)
    {
      echo json_encode($result);
      $this->dontRender();
    }
    else
    {
      if ($result == true)
      {
        $this->addInfo("Sucessfully deleted");
      }
      else 
      {
        $this->addError("Error: $result");
      }
      $this->redirect();
    }
  }
}

?>
