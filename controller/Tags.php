<?php
namespace Controller;

/**
 * Description of Learn
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Tags extends BaseController
{

  /**
   *
   * @var \Manager\TagsManager
   */
  private $tm;

  public function __construct()
  {
    $this->tm = new \Manager\TagsManager();
  }

  public function loadDefault()
  {
    $u = $this->getUserManager()->getLoggedInUser();
    $this->assignToView("tags", $this->tm->getTagsByUser($u));
  }

  public function loadDelete($tagId)
  {
    $tag = $this->tm->findById($tagId);
    $result = $this->tm->deleteById($tagId);
    if ($result === true)
    {
      $this->addInfo("Tag '".$tag->getName()."' successfully deleted.");
      $this->redirect();
    }
    else
    {
      $this->addError($result);
      $this->redirect(null, "show", array("tagId" => $tagId));
    }
  }

  public function loadShow($tagId)
  {
    $this->assignToView("tag", $this->tm->findById($tagId));
  }
}

?>
