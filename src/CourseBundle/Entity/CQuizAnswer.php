<?php

/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CQuizAnswer.
 *
 * @ORM\Table(
 *  name="c_quiz_answer",
 *  indexes={
 *      @ORM\Index(name="c_id", columns={"c_id"}),
 *      @ORM\Index(name="idx_cqa_q", columns={"question_id"}),
 *  }
 * )
 * @ORM\Entity
 */
class CQuizAnswer
{
    /**
     * @var int
     *
     * @ORM\Column(name="iid", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $iid;

    /**
     * @var int
     *
     * @ORM\Column(name="c_id", type="integer", options={"unsigned": true, "default": null})
     */
    protected $cId;

    /**
     * @var int
     *
     * @ORM\Column(name="question_id", type="integer", nullable=false)
     */
    protected $questionId;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="answer", type="text", nullable=false)
     */
    protected string $answer;

    /**
     * @var int
     *
     * @ORM\Column(name="correct", type="integer", nullable=true)
     */
    protected $correct;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    protected $comment;

    /**
     * @var float
     *
     * @ORM\Column(name="ponderation", type="float", precision=6, scale=2, nullable=false, options={"default": 0})
     */
    protected $ponderation;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(name="hotspot_coordinates", type="text", nullable=true)
     */
    protected $hotspotCoordinates;

    /**
     * @var string
     *
     * @ORM\Column(name="hotspot_type", type="string", length=40, nullable=true)
     */
    protected $hotspotType;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="text", nullable=true)
     */
    protected $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="answer_code", type="string", length=10, nullable=true)
     */
    protected $answerCode;

    public function __construct()
    {
        $this->correct = null;
        $this->comment = null;
        $this->ponderation = 0.0;
        $this->hotspotCoordinates = null;
        $this->hotspotType = null;
        $this->destination = null;
        $this->answerCode = null;
    }

    /**
     * Set questionId.
     *
     * @param int $questionId
     *
     * @return CQuizAnswer
     */
    public function setQuestionId($questionId)
    {
        $this->questionId = $questionId;

        return $this;
    }

    /**
     * Get questionId.
     *
     * @return int
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }

    /**
     * Set answer.
     *
     * @param string $answer
     *
     * @return CQuizAnswer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer.
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set correct.
     *
     * @param int $correct
     *
     * @return CQuizAnswer
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;

        return $this;
    }

    /**
     * Get correct.
     *
     * @return int
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return CQuizAnswer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set weight.
     *
     * @param float $weight
     *
     * @return CQuizAnswer
     */
    public function setPonderation($weight)
    {
        $this->ponderation = empty($weight) ? 0.0 : $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return float
     */
    public function getPonderation()
    {
        return $this->ponderation;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return CQuizAnswer
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set hotspotCoordinates.
     *
     * @param string $hotspotCoordinates
     *
     * @return CQuizAnswer
     */
    public function setHotspotCoordinates($hotspotCoordinates)
    {
        $this->hotspotCoordinates = $hotspotCoordinates;

        return $this;
    }

    /**
     * Get hotspotCoordinates.
     *
     * @return string
     */
    public function getHotspotCoordinates()
    {
        return $this->hotspotCoordinates;
    }

    /**
     * Set hotspotType.
     *
     * @param string $hotspotType
     *
     * @return CQuizAnswer
     */
    public function setHotspotType($hotspotType)
    {
        $this->hotspotType = $hotspotType;

        return $this;
    }

    /**
     * Get hotspotType.
     *
     * @return string
     */
    public function getHotspotType()
    {
        return $this->hotspotType;
    }

    /**
     * Set destination.
     *
     * @param string $destination
     *
     * @return CQuizAnswer
     */
    public function setDestination($destination)
    {
        $this->destination = empty($destination) ? null : $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set answerCode.
     *
     * @param string $answerCode
     *
     * @return CQuizAnswer
     */
    public function setAnswerCode($answerCode)
    {
        $this->answerCode = $answerCode;

        return $this;
    }

    /**
     * Get answerCode.
     *
     * @return string
     */
    public function getAnswerCode()
    {
        return $this->answerCode;
    }

    /**
     * Set cId.
     *
     * @param int $cId
     *
     * @return CQuizAnswer
     */
    public function setCId($cId)
    {
        $this->cId = $cId;

        return $this;
    }

    /**
     * Get cId.
     *
     * @return int
     */
    public function getCId()
    {
        return $this->cId;
    }

    /**
     * Get iid.
     *
     * @return int
     */
    public function getIid()
    {
        return $this->iid;
    }
}
