<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * TrackELinks.
 */
#[ORM\Table(name: 'track_e_links')]
#[ORM\Index(name: 'idx_tel_c_id', columns: ['c_id'])]
#[ORM\Index(name: 'idx_tel_user_id', columns: ['links_user_id'])]
#[ORM\Index(name: 'session_id', columns: ['session_id'])]
#[ORM\Entity]
class TrackELinks
{
    #[ORM\Column(name: 'links_user_id', type: 'integer', nullable: true)]
    protected ?int $linksUserId = null;

    #[ORM\Column(name: 'links_date', type: 'datetime', nullable: false)]
    protected DateTime $linksDate;

    #[ORM\Column(name: 'c_id', type: 'integer', nullable: false)]
    protected int $cId;

    #[ORM\Column(name: 'links_link_id', type: 'integer', nullable: false)]
    protected int $linksLinkId;

    #[ORM\Column(name: 'session_id', type: 'integer', nullable: false)]
    protected int $sessionId;

    #[ORM\Column(name: 'links_id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected int $linksId;

    /**
     * @return int
     */
    public function getLinksUserId()
    {
        return $this->linksUserId;
    }

    /**
     * @return TrackELinks
     */
    public function setLinksUserId(int $linksUserId)
    {
        $this->linksUserId = $linksUserId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLinksDate()
    {
        return $this->linksDate;
    }

    /**
     * @return TrackELinks
     */
    public function setLinksDate(DateTime $linksDate)
    {
        $this->linksDate = $linksDate;

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
     * @return TrackELinks
     */
    public function setCId(int $cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLinksLinkId()
    {
        return $this->linksLinkId;
    }

    /**
     * @return TrackELinks
     */
    public function setLinksLinkId(int $linksLinkId)
    {
        $this->linksLinkId = $linksLinkId;

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
     * @return TrackELinks
     */
    public function setSessionId(int $sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLinksId()
    {
        return $this->linksId;
    }
}
