<?php
namespace Controller;
/**
 * Description of Cards
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Cards extends BaseCards{
  
  public function loadDoExport($selection, $format, $unlearned = false, $tagIds = null)
  {
    $cards = $this->cm->findCards(null, $selection == "all" ? null : $tagIds, $unlearned);
    $text = $this->cm->exportFile($cards, $format);
    //TODO: set headers so, that this appears as download
    header("Content-Length: ".strlen($text));
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=export.".($format == "json" ? "js" : "csv"));
    header("Content-Type: text/plain");
    header("Content-Transfer-Encoding: binary");
    echo $text;
    $this->dontRender();
  }
  
  public function loadDoImport($format, $tags)
  {
    $path = $_FILES['file']['tmp_name'];
    $count = $this->cm->importFile($path, explode(",", $tags), $format);
    $this->addInfo($count." cards imported");
    $this->redirect();
  }
  
  public function loadExport($tag = null)
  {
    $tm = new \Manager\TagsManager();
    $tags = $tm->getTagsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("tags", $tags);
    $this->assignToView("tag", $tag);
  }
  
  public function loadImport()
  {
    $tm = new \Manager\TagsManager();
    $this->assignToView("tags", $tm->getTagsByUser());
  }
  
  public function loadAdd($title = null)
  {
    $this->assignToView("title", $title != null ? $title : "");
    $tm = new \Manager\TagsManager();
    $this->assignToView("tags", $tm->getTagsByUser());
  }

  public function loadDefault()
  {
    $cards = $this->cm->getCardsByUser();
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
    $tm = new \Manager\TagsManager();
    $this->assignToView("tags", $tm->getTagsByUser());
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
    $c = $cm->createCard(null, $title, $frontHtml, $backHtml, explode(",",$tags));
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
