<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use Chamilo\UserBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Portfolio.
 *
 * @package Chamilo\CoreBundle\Entity
 *
 * @ORM\Table(
 *  name="portfolio",
 *  indexes={
 *   @ORM\Index(name="user", columns={"user_id"}),
 *   @ORM\Index(name="course", columns={"c_id"}),
 *   @ORM\Index(name="session", columns={"session_id"}),
 *   @ORM\Index(name="category", columns={"category_id"})
 *  }
 * )
 * Add @ to the next line if api_get_configuration_value('allow_portfolio_tool') is true
 * ORM\Entity(repositoryClass="Chamilo\CoreBundle\Entity\Repository\PortfolioRepository")
 */
class Portfolio
{
    public const TYPE_ITEM = 1;
    public const TYPE_COMMENT = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Chamilo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $user;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\Course")
     * @ORM\JoinColumn(name="c_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $course = null;

    /**
     * @var Session
     *
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\Session")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $session = null;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    protected $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime")
     */
    protected $updateDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_visible", type="boolean", options={"default": true})
     */
    protected $isVisible = true;

    /**
     * @var \Chamilo\CoreBundle\Entity\PortfolioCategory
     *
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\PortfolioCategory", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $category;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Chamilo\CoreBundle\Entity\PortfolioComment", mappedBy="item")
     */
    private $comments;

    /**
     * @var int|null
     *
     * @ORM\Column(name="origin", type="integer", nullable=true)
     */
    private $origin;
    /**
     * @var int|null
     *
     * @ORM\Column(name="origin_type", type="integer", nullable=true)
     */
    private $originType;

    /**
     * @var float|null
     *
     * @ORM\Column(name="score", type="float", nullable=true)
     */
    private $score;

    /**
     * Portfolio constructor.
     */
    public function __construct()
    {
        $this->category = null;
        $this->comments = new ArrayCollection();
    }

    /**
     * Set user.
     *
     * @return Portfolio
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set course.
     *
     * @return Portfolio
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course.
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Get session.
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set session.
     *
     * @return Portfolio
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Portfolio
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Portfolio
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set creationDate.
     *
     * @return Portfolio
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate.
     *
     * @return Portfolio
     */
    public function setUpdateDate(\DateTime $updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate.
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isVisible.
     *
     * @param bool $isVisible
     *
     * @return Portfolio
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible.
     *
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }

    /**
     * Get category.
     *
     * @return PortfolioCategory
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set category.
     *
     * @return Portfolio
     */
    public function setCategory(PortfolioCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    /**
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setOrigin(?int $origin): Portfolio
    {
        $this->origin = $origin;

        return $this;
    }

    public function getOriginType(): ?int
    {
        return $this->originType;
    }

    /**
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setOriginType(?int $originType): Portfolio
    {
        $this->originType = $originType;

        return $this;
    }

    public function getExcerpt(int $count = 380): string
    {
        $excerpt = strip_tags($this->content);
        $excerpt = substr($excerpt, 0, $count);
        $excerpt = substr($excerpt, 0, strripos($excerpt, " "));

        return $excerpt;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): void
    {
        $this->score = $score;
    }
}