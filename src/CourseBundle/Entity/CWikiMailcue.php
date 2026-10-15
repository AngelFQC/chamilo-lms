<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'c_wiki_mailcue')]
#[ORM\Index(name: 'course', columns: ['c_id'])]
#[ORM\Index(name: 'user', columns: ['user_id'])]
#[ORM\Index(name: 'c_id', columns: ['c_id', 'iid'])]
#[ORM\Entity]
class CWikiMailcue
{
    #[ORM\Column(name: 'iid', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $iid = null;

    #[ORM\Column(name: 'c_id', type: 'integer')]
    protected int $cId;

    #[ORM\Column(name: 'type', type: 'text', nullable: false)]
    protected string $type;

    #[ORM\Column(name: 'group_id', type: 'integer', nullable: true)]
    protected ?int $groupId = null;

    #[ORM\Column(name: 'session_id', type: 'integer', nullable: true)]
    protected ?int $sessionId = null;

    #[ORM\Column(name: 'user_id', type: 'integer')]
    protected int $userId;

    /**
     * @return CWikiMailcue
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return CWikiMailcue
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @return CWikiMailcue
     */
    public function setSessionId(int $sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @return CWikiMailcue
     */
    public function setCId(int $cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCId()
    {
        return $this->cId;
    }

    /**
     * @return CWikiMailcue
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function getIid(): ?int
    {
        return $this->iid;
    }
}
