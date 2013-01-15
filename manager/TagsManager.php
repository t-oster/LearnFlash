<?php
namespace Manager;

/**
 * Description of TagsManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class TagsManager extends BaseManager
{

  public function findByCard($cardId)
  {
    $c = $this->em->getRepository("\Model\Card")->find($cardId);
    return $c->getTags();
  }
  
  public function findByName($name, \Model\User $owner = null)
  {
    if ($owner == null)
    {
      $owner = $this->um->getLoggedInUser();
    }
    $query = $this->em->createQuery('SELECT t FROM \Model\Tag t WHERE LOWER(t.name) = :name and t.owner = :owner');
    $query->setParameter("owner", $owner);
    $query->setParameter("name", strtolower($name));
    return $query->getOneOrNullResult();
  }

  public function getTagsByUser(\Model\User $u = null)
  {
    if ($u == null)
    {
      $u = $this->um->getLoggedInUser();
    }
    return $this->em->getRepository("\Model\Tag")->findBy(array("owner" => $u));
  }

  public function createTag($name, $color)
  {
    $tag = new \Model\Tag();
    $tag->setName($name);
    $tag->setOwner($this->um->getLoggedInUser());
    $tag->setColor($color);
    $this->em->persist($tag);
    return $tag;
  }
  
  public function deleteById($tagId)
  {
    $tag = $this->findById($tagId);
    if ($tag != null)
    {
      foreach ($tag->getCards() as $c)
      {
        $c->removeTag($tag);
      }
      $this->em->flush();
    }
    return parent::deleteById($tagId);
  }
  
  public function updateTag($tagId, $name, $color)
  {
    $tag = $this->findById($tagId);
    if ($tag == null)
    {
      return "Tag with id $tagId doesn't exist";
    }
    $tag->setName($name);
    $tag->setColor($color);
    $this->em->flush();
    return true;
  }

  public function getModelClassname()
  {
    return "\Model\Tag";
  }
}

?>
