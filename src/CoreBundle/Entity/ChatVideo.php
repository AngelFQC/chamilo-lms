<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chat.
 */
#[ORM\Table(name: 'chat_video', options: ['row_format' => 'DYNAMIC'])]
#[ORM\Index(name: 'idx_chat_video_to_user', columns: ['to_user'])]
#[ORM\Index(name: 'idx_chat_video_from_user', columns: ['from_user'])]
#[ORM\Index(name: 'idx_chat_video_users', columns: ['from_user', 'to_user'])]
#[ORM\Index(name: 'idx_chat_video_title', columns: ['title'], options: ['lengths' => [255]])]
#[ORM\Entity]
class ChatVideo
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    protected ?int $id = null;

    #[ORM\Column(name: 'from_user', type: 'integer', nullable: false)]
    protected int $fromUser;

    #[ORM\Column(name: 'to_user', type: 'integer', nullable: false)]
    protected int $toUser;

    #[ORM\Column(name: 'title', type: 'text', nullable: false)]
    protected string $title;

    #[ORM\Column(name: 'datetime', type: 'datetime', nullable: false)]
    protected DateTime $datetime;

    /**
     * @return int
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * @return ChatVideo
     */
    public function setFromUser(int $fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    /**
     * @return int
     */
    public function getToUser()
    {
        return $this->toUser;
    }

    /**
     * @return ChatVideo
     */
    public function setToUser(int $toUser)
    {
        $this->toUser = $toUser;

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
     * @return ChatVideo
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @return ChatVideo
     */
    public function setDatetime(DateTime $datetime)
    {
        $this->datetime = $datetime;

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
