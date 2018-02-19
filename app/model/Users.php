<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Users extends \Kdyby\Doctrine\Entities\BaseEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="integer", options={"default" : 0})
     */
    protected $role = 0;

    /**
     * @ORM\OneToMany(targetEntity="\App\Model\Articles", mappedBy="user", cascade={"persist"})
     * @var Articles[]|\Doctrine\Common\Collections\ArrayCollection
     */
    protected $articles;

    function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function addArticle(Articles $article)
    {
        $this->articles->add( $article );
    }

    public function addUser($id, $password)
    {
        $this->id = $id;
        $this->password = $this->hashPassword($password);
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}