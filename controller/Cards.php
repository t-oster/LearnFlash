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
  
  public function loadCreate($title, $frontHtml, $backHtml, $ajax)
  {
    $cm = new \Manager\CardsManager();
    $c = $cm->createCard($this->getUserManager()->getLoggedInUser(), $title, $frontHtml, $backHtml);
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
