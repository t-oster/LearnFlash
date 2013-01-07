<?php
namespace Manager;
/**
 * Description of CardsManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class CardsManager extends BaseManager{
  
  public function setTags(\Model\Card $c, array $itags)
  {
    //remove all empty tags, create 2 arrays
    //containing trimmed tag and lower-case trimmed tag
    $ltags = array();
    $tags = array();
    foreach ($itags as $t)
    {
      $t = trim($t);
      if ($t != "")
      {
        $ltags []= strtolower($t);
        $tags [] = $t;
      }
    }
    $this->em->beginTransaction();
    //find all tags, which have to be removed
    $toRemove = array();
    foreach ($c->getTags() as $t)
    {
      if (!in_array(strtolower($t->getName()), $ltags))
      {
        $toRemove []= $t;
      }
    }
    foreach ($toRemove as $t)
    {
      $c->removeTag($t);
    }
    //find all tags which have to be added
    $newtags = array();
    foreach ($tags as $t)
    {
      foreach ($c->getTags() as $tt)
      {
        if (strtolower($tt->getName()) == strtolower($t))
        {
          continue 2;
        }
      }
      //not found
      $newtags []= $t;
    }
    $tm = new TagsManager();
    foreach ($newtags as $t)
    {
      //try to find existing tag
      $tag = $tm->findByName($c->getOwner(), strtolower($t));
      if ($tag == null)
      {
        $tag = $tm->createTag($t, $c->getOwner(), "#00ff00");
      }
      $c->addTag($tag);
    }
    $this->em->flush();
    $this->em->commit();
  }

  public function createCard(\Model\User $owner, $title, $frontHtml, $backHtml, $tags = null)
  {
    $this->em->beginTransaction();
    $c = new \Model\Card();
    $c->setOwner($owner);
    $owner->getCards()->add($c);
    $c->setTitle($title);
    $c->setFrontHtml($frontHtml);
    $c->setBackHtml($backHtml);
    $this->em->persist($c);
    $this->em->flush();
    if ($c->getTitle() == "")
    {
      $c->setTitle("#".$c->getId());
    }
    if ($tags != null)
    {
      $this->setTags($c, $tags); 
    }
    $this->em->flush();
    $this->em->commit();
    return $c;
  }
  
  public function updateCard($cardId, $title, $frontHtml, $backHtml, $tags = null)
  {
    $c = $this->findById($cardId);
    $c->setTitle($title);
    $c->setFrontHtml($frontHtml);
    $c->setBackHtml($backHtml);
    if ($tags != null)
    {
      $this->setTags($c, $tags);
    }
    $this->em->flush();
    return $c;
  }

  public function findByTitle($title)
  {
    return $this->em->getRepository("\Model\Card")->findOneBy(array("title" => $title));
  }

  public function getCardsByUser(\Model\User $u)
  {
    return $this->em->getRepository("\Model\Card")->findBy(array("owner" => $u));
  }

  public function getModelClassname()
  {
    return "\Model\Card";
  }

  public function deleteById($id)
  {
    $c = $this->findById($id);
    foreach ($c->getTags() as $t)
    {
      $c->removeTag($t);
    }
    return parent::deleteById($id);
  }
}

?>
