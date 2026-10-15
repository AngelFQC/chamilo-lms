<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrackEAccess.
 */
#[ORM\Table(name: 'track_e_access')]
#[ORM\Index(name: 'access_user_id', columns: ['access_user_id'])]
#[ORM\Index(name: 'access_c_id', columns: ['c_id'])]
#[ORM\Index(name: 'session_id', columns: ['session_id'])]
#[ORM\Index(name: 'user_course_session_date', columns: ['access_user_id', 'c_id', 'session_id', 'access_date'])]
#[ORM\Entity]
class TrackEAccess
{
    #[ORM\Column(name: 'access_id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected int $accessId;

    #[ORM\Column(name: 'access_user_id', type: 'integer', nullable: true)]
    protected ?int $accessUserId = null;

    #[ORM\Column(name: 'access_date', type: 'datetime', nullable: false)]
    protected DateTime $accessDate;

    #[ORM\Column(name: 'c_id', type: 'integer', nullable: false)]
    protected int $cId;

    #[ORM\Column(name: 'access_tool', type: 'string', length: 30, nullable: true)]
    protected ?string $accessTool = null;

    #[ORM\Column(name: 'session_id', type: 'integer', nullable: false)]
    protected int $sessionId;

    #[ORM\Column(name: 'user_ip', type: 'string', length: 45, nullable: false)]
    protected string $userIp;

    /**
     * @return int
     */
    public function getAccessUserId()
    {
        return $this->accessUserId;
    }

    /**
     * @return TrackEAccess
     */
    public function setAccessUserId(int $accessUserId)
    {
        $this->accessUserId = $accessUserId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getAccessDate()
    {
        return $this->accessDate;
    }

    /**
     * @return TrackEAccess
     */
    public function setAccessDate(DateTime $accessDate)
    {
        $this->accessDate = $accessDate;

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
     * @return TrackEAccess
     */
    public function setCId(int $cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessTool()
    {
        return $this->accessTool;
    }

    /**
     * @return TrackEAccess
     */
    public function setAccessTool(string $accessTool)
    {
        $this->accessTool = $accessTool;

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
     * @return TrackEAccess
     */
    public function setSessionId(int $sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserIp()
    {
        return $this->userIp;
    }

    /**
     * @return TrackEAccess
     */
    public function setUserIp(string $userIp)
    {
        $this->userIp = $userIp;

        return $this;
    }

    /**
     * @return int
     */
    public function getAccessId()
    {
        return $this->accessId;
    }
}
