<?php
namespace Controller;
/**
 * Description of Cards
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Cards extends BaseController{
  
  public function loadDefault()
  {
    $cm = new \Manager\CardsManager();
    $cards = $cm->getCardsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("cards", $cards);
  }
  
  public function loadShow($cardId)
  {
    $cm = new \Manager\CardsManager();
    $card = $cm->findById($cardId);
    $this->assignToView("card", $card);
  }
  
  public function loadEdit($cardId)
  {
    $cm = new \Manager\CardsManager();
    $card = $cm->findById($cardId);
    $this->assignToView("card", $card);
    $stringTags = "";
    foreach ($card->getTags() as $t)
    {
      $stringTags .= ($stringTags == "" ? "" : ", ") . $t->getName();
    }
    $this->assignToView("stringTags", $stringTags);
  }
  
  public function loadUpdate($cardId, $title, $frontHtml, $backHtml, $ajax, $tags = null)
  {
    $cm = new \Manager\CardsManager();
    $c = $cm->updateCard($cardId, $title, $frontHtml, $backHtml, explode(",",$tags));
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
  
  public function loadCreate($title, $frontHtml, $backHtml, $ajax, $tags = null)
  {
    $cm = new \Manager\CardsManager();
    $c = $cm->createCard($this->getUserManager()->getLoggedInUser(), $title, $frontHtml, $backHtml, $tags);
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
    $cm = new \Manager\CardsManager();
    $result = $cm->deleteById($cardId);
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
