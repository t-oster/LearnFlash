<?php
namespace Controller;
/**
 * Description of Cards
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Cards extends BaseController{

  /**
   *
   * @var \Manager\CardsManager
   */
  protected $cm;
  
  public function __construct()
  {
    $this->cm = new \Manager\CardsManager();
  }
  
  public function loadAdd($title = null)
  {
    $this->assignToView("title", $title != null ? $title : "");
  }

  public function loadDefault()
  {
    $cards = $this->cm->getCardsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("cards", $cards);
  }

  private function replaceReferenceWithLink($ref)
  {
    $delim = strpos($ref, "|");
    $title = $delim !==false ? substr($ref, 0, $delim) : $ref;
    $text = $delim !==false ? substr($ref, $delim + 1) : $title;
    $cm = new \Manager\CardsManager();
    $card = $cm->findByTitle($title);
    if ($card == null)
    {
      return '<a class="createlink" href="'.generate_url("cards", "add", array("title" => $title))."\">$text</a>";
    }
    else
    {
      return '<a href="'.generate_url("cards", "show", array("cardId" => $card->getId()))."\">$text</a>";
    }
  }

  private function replaceReferencesWithLinks($txt)
  {
    $begin = strpos($txt, "[[");
    if ($begin !== false)
    {
      $end = strpos($txt, "]]", $begin);
      if ($end !==false)
      {
        $before = substr($txt, 0, $begin);
        $content = substr($txt, $begin + 2, $end-$begin - 2);
        $after = substr($txt, $end+2);
        return $before . $this->replaceReferenceWithLink($content) . $this->replaceReferencesWithLinks($after);
      }
    }
    return $txt;
  }

  private function loadCard($cardId)
  {
    $card = $this->cm->findById($cardId);
    if ($card == null)
    {
      $this->addError("Card with id $cardId doesn't exist");
      $this->redirect();
      $this->stop();
    }
    return $card;
  }
  
  public function loadShow($cardId)
  { 
    $card = $this->loadCard($cardId);
    $this->assignToView("frontHtml", $this->replaceReferencesWithLinks($card->getFrontHtml()));
    $this->assignToView("backHtml", $this->replaceReferencesWithLinks($card->getBackHtml()));
    $this->assignToView("card", $card);
  }
  
  public function loadEdit($cardId)
  {
    $card = $this->loadCard($cardId);
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
