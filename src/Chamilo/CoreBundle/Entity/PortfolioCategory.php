<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PortfolioCategory
 * @package Chamilo\CoreBundle\Entity
 * @ORM\Table(
 *  name="portfolio_category",
 *  indexes={
 *      @ORM\Index(name="user", columns={"user_id"})
 *  }
 * )
 * @ORM\Entity()
 */
class PortfolioCategory
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var null
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description = null;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Chamilo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var bool
     * @ORM\Column(name="is_visible", type="boolean", options={"default": true})
     */
    private $isVisible = true;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Chamilo\CoreBundle\Entity\Portfolio", mappedBy="category")
     */
    private $items;

    /**
     * PortfolioCategory constructor.
     */
    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PortfolioCategory
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PortfolioCategory
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     * @return PortfolioCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \Chamilo\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \Chamilo\CoreBundle\Entity\User $user
     * @return PortfolioCategory
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * @param bool $isVisible
     * @return PortfolioCategory
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @param \Chamilo\CoreBundle\Entity\Course|null $course
     * @param \Chamilo\CoreBundle\Entity\Session|null $session
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems(Course $course = null, Session $session = null)
    {
        if ($course) {
            $criteria = Criteria::create()
                ->where(
                    Criteria::expr()->eq('course', $course)
                )
                ->andWhere(
                    Criteria::expr()->eq('session', $session)
                );

            return $this->items->matching($criteria);
        }

        return $this->items;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $items
     * @return PortfolioCategory
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}
