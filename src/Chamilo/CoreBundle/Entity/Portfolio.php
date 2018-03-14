<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use Chamilo\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Portfolio
 * @package Chamilo\CoreBundle\Entity
 * @ORM\Table(
 *  name="portfolio",
 *  indexes={
 *   @ORM\Index(name="user", columns={"user_id"}),
 *   @ORM\Index(name="course", columns={"c_id"}),
 *   @ORM\Index(name="session", columns={"session_id"})
 *  }
 * )
 * @ORM\Entity()
 */
class Portfolio
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
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Chamilo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @var Course
     *
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\Course")
     * @ORM\JoinColumn(name="c_id", referencedColumnName="id")
     */
    private $course = null;

    /**
     * @var Session
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\Session")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id")
     */
    private $session = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     * @ORM\Column(name="update_date", type="datetime")
     */
    private $updateDate;

    /**
     * @var bool
     * @ORM\Column(name="is_visible", type="boolean", options={"default": true})
     */
    private $isVisible = true;

    /**
     * Set user
     * @param \Chamilo\UserBundle\Entity\User $user
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set course
     *
     * @param \Chamilo\CoreBundle\Entity\Course|null $course
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setCourse(Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @return \Chamilo\CoreBundle\Entity\Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param \Chamilo\CoreBundle\Entity\Session|null $session
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setSession(Session $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setCreationDate(\DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setUpdateDate(\DateTime $updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set isPublic
     *
     * @param bool $isVisible
     * @return \Chamilo\CoreBundle\Entity\Portfolio
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isPublic
     * @return bool
     */
    public function isVisible()
    {
        return $this->isVisible;
    }
}
