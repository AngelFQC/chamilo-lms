<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use Chamilo\CoreBundle\Repository\ChatRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Chat.
 */
#[ORM\Entity(repositoryClass: ChatRepository::class)]
#[ORM\Table(name: 'chat')]
#[ORM\Index(columns: ['to_user'], name: 'idx_chat_to_user')]
#[ORM\Index(columns: ['from_user'], name: 'idx_chat_from_user')]
class Chat
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\Column(name: 'from_user', type: 'integer', nullable: true)]
    protected ?int $fromUser = null;

    #[ORM\Column(name: 'to_user', type: 'integer', nullable: true)]
    protected ?int $toUser = null;

    #[ORM\Column(name: 'message', type: 'text', nullable: false)]
    protected string $message;

    #[ORM\Column(name: 'sent', type: 'datetime', nullable: false)]
    protected DateTime $sent;

    #[ORM\Column(name: 'recd', type: 'integer', nullable: false)]
    protected int $recd = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getFromUser()
    {
        return $this->fromUser;
    }

    /**
     * @return Chat
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
     * @return Chat
     */
    public function setToUser(int $toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return Chat
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * @return Chat
     */
    public function setSent(DateTime $sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * @return int
     */
    public function getRecd()
    {
        return $this->recd;
    }

    /**
     * @return Chat
     */
    public function setRecd(int $recd)
    {
        $this->recd = $recd;

        return $this;
    }
}
