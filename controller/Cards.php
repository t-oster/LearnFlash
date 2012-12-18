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
  
  public function loadCreate($title, $frontHtml, $backHtml)
  {
    $cm = new \Manager\CardsManager();
    $c = $cm->createCard($this->getUserManager()->getLoggedInUser(), $title, $frontHtml, $backHtml);
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

?>
