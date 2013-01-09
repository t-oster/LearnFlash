<?php
namespace Controller;

/**
 * Contains methods useful for Cards and Learn-Controller
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class BaseCards extends BaseController{
  /**
   *
   * @var \Manager\CardsManager
   */
  protected $cm;
  
  public function __construct()
  {
    $this->cm = new \Manager\CardsManager();
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

  protected function replaceReferencesWithLinks($txt)
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

  protected function findCardOrError($cardId)
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

}

?>
