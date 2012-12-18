<?php
namespace Model;

/**
 * Description of User
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 * @Entity
 */
class User {
  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   * @var int
   */
  protected $id;
  /**
   * @Column(type="string")
   * @var string
   */
  protected $name;
  /**
   * @Column(type="string")
   * @var string
   */
  protected $login;
  /**
   * @Column(type="string")
   * @var string
   */
  protected $email;
  /**
   * @Column(type="string")
   * @var string
   */
  protected $passwordHash;
  /**
   * @OneToMany(targetEntity="Card", mappedBy="owner")
   *
   * @var Card[]
   */
  protected $cards;
  /**
   * @OneToMany(targetEntity="Tag", mappedBy="owner")
   *
   * @var Tags[]
   */
  protected $tags;
  
  public function __construct() {
    $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
  }
  
  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getLogin() {
    return $this->login;
  }

  public function setLogin($login) {
    $this->login = $login;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  private function hashPassword($password) {
    return md5($this->getLogin().":".$password);
  }
  
  public function checkPassword($password) {
    return $this->passwordHash == $this->hashPassword($password);
  }

  public function setPassword($password) {
    $this->passwordHash = $this->hashPassword($password);
  }
  
  public function getCards() {
    return $this->cards;
  }

  public function getTags() {
    return $this->tags;
  }

}

?>
