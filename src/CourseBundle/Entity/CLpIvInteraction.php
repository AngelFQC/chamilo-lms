<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CLpIvInteraction.
 */
#[ORM\Table(name: 'c_lp_iv_interaction')]
#[ORM\Index(name: 'course', columns: ['c_id'])]
#[ORM\Index(name: 'lp_iv_id', columns: ['lp_iv_id'])]
#[ORM\Entity]
class CLpIvInteraction
{
    #[ORM\Column(name: 'iid', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $iid = null;

    #[ORM\Column(name: 'c_id', type: 'integer')]
    protected int $cId;

    #[ORM\Column(name: 'order_id', type: 'integer', nullable: false)]
    protected int $orderId;

    #[ORM\Column(name: 'lp_iv_id', type: 'integer', nullable: false)]
    protected int $lpIvId;

    #[ORM\Column(name: 'interaction_id', type: 'string', length: 255, nullable: false)]
    protected string $interactionId;

    #[ORM\Column(name: 'interaction_type', type: 'string', length: 255, nullable: false)]
    protected string $interactionType;

    #[ORM\Column(name: 'weighting', type: 'float', precision: 10, scale: 0, nullable: false)]
    protected float $weighting;

    #[ORM\Column(name: 'completion_time', type: 'string', length: 16, nullable: false)]
    protected string $completionTime;

    #[ORM\Column(name: 'correct_responses', type: 'text', nullable: false)]
    protected string $correctResponses;

    #[ORM\Column(name: 'student_response', type: 'text', nullable: false)]
    protected string $studentResponse;

    #[ORM\Column(name: 'result', type: 'string', length: 255, nullable: false)]
    protected string $result;

    #[ORM\Column(name: 'latency', type: 'string', length: 16, nullable: false)]
    protected string $latency;

    #[ORM\Column(name: 'description', type: 'text', nullable: true)]
    protected ?string $description = null;

    /**
     * @return CLpIvInteraction
     */
    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setLpIvId(int $lpIvId)
    {
        $this->lpIvId = $lpIvId;

        return $this;
    }

    /**
     * @return int
     */
    public function getLpIvId()
    {
        return $this->lpIvId;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setInteractionId(string $interactionId)
    {
        $this->interactionId = $interactionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getInteractionId()
    {
        return $this->interactionId;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setInteractionType(string $interactionType)
    {
        $this->interactionType = $interactionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getInteractionType()
    {
        return $this->interactionType;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setWeighting(float $weighting)
    {
        $this->weighting = $weighting;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeighting()
    {
        return $this->weighting;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setCompletionTime(string $completionTime)
    {
        $this->completionTime = $completionTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getCompletionTime()
    {
        return $this->completionTime;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setCorrectResponses(string $correctResponses)
    {
        $this->correctResponses = $correctResponses;

        return $this;
    }

    /**
     * @return string
     */
    public function getCorrectResponses()
    {
        return $this->correctResponses;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setStudentResponse(string $studentResponse)
    {
        $this->studentResponse = $studentResponse;

        return $this;
    }

    /**
     * @return string
     */
    public function getStudentResponse()
    {
        return $this->studentResponse;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setResult(string $result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setLatency(string $latency)
    {
        $this->latency = $latency;

        return $this;
    }

    /**
     * @return string
     */
    public function getLatency()
    {
        return $this->latency;
    }

    /**
     * @return CLpIvInteraction
     */
    public function setDescription(?string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return CLpIvInteraction
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
}
