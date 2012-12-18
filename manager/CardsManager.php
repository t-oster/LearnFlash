<?php
namespace Manager;
/**
 * Description of CardsManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class CardsManager {
  /**
   *
   * @var \Doctrine\ORM\EntityManager
   */
  protected $em;
  
  public function __construct()
  {
    global $entityManager;
    $this->em = $entityManager;
  }
  
  public function createCard(\Model\User $owner, $title, $frontHtml, $backHtml)
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
    $this->em->commit();
    return $c;
  }
  
  public function getCardsByUser(\Model\User $u)
  {
    return $this->em->getRepository("\Model\Card")->findBy(array("owner" => $u));
  }
}

?>
