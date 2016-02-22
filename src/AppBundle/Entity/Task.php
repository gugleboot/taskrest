<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Task
 *
 * @ORM\Table(name="task")
 * @ORM\Entity
 */
class Task
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string",length=20,  nullable=false)
     * @Assert\Length(max = 20, min=3)
     * @Assert\NotBlank()
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="string",length=100, nullable=false)
     * @Assert\Length(max = 100, min=3)
     *
     */
    private $opis;

    /**
     * @var string
     *
     * @ORM\Column(name="created", type="string", length=16, nullable=false)
     * @Assert\NotBlank()
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="modified", type="string", length=16, nullable=false)
     */
    private $modified;



    /**
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * @param string $nazwa
     * @return Task
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * @param string $opis
     * @return Task
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return Task
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param string $modified
     * @return Task
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
