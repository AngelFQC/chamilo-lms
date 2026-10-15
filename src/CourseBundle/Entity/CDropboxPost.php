<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * CDropboxPost.
 */
#[ORM\Table(name: 'c_dropbox_post')]
#[ORM\Index(name: 'course', columns: ['c_id'])]
#[ORM\Index(name: 'dest_user', columns: ['dest_user_id'])]
#[ORM\Index(name: 'session_id', columns: ['session_id'])]
#[ORM\Entity]
class CDropboxPost
{
    #[ORM\Column(name: 'iid', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $iid = null;

    #[ORM\Column(name: 'feedback_date', type: 'datetime', nullable: false)]
    protected DateTime $feedbackDate;

    #[ORM\Column(name: 'feedback', type: 'text', nullable: true)]
    protected ?string $feedback = null;

    #[ORM\Column(name: 'cat_id', type: 'integer', nullable: false)]
    protected int $catId;

    #[ORM\Column(name: 'session_id', type: 'integer', nullable: false)]
    protected int $sessionId;

    #[ORM\Column(name: 'c_id', type: 'integer')]
    protected int $cId;

    #[ORM\Column(name: 'file_id', type: 'integer')]
    protected int $fileId;

    #[ORM\Column(name: 'dest_user_id', type: 'integer')]
    protected int $destUserId;

    /**
     * @return CDropboxPost
     */
    public function setFeedbackDate(DateTime $feedbackDate)
    {
        $this->feedbackDate = $feedbackDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getFeedbackDate()
    {
        return $this->feedbackDate;
    }

    /**
     * @return CDropboxPost
     */
    public function setFeedback(string $feedback)
    {
        $this->feedback = $feedback;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @return CDropboxPost
     */
    public function setCatId(int $catId)
    {
        $this->catId = $catId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCatId()
    {
        return $this->catId;
    }

    /**
     * @return CDropboxPost
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
     * @return CDropboxPost
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
     * @return CDropboxPost
     */
    public function setFileId(int $fileId)
    {
        $this->fileId = $fileId;

        return $this;
    }

    /**
     * @return int
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * @return CDropboxPost
     */
    public function setDestUserId(int $destUserId)
    {
        $this->destUserId = $destUserId;

        return $this;
    }

    /**
     * @return int
     */
    public function getDestUserId()
    {
        return $this->destUserId;
    }
}
