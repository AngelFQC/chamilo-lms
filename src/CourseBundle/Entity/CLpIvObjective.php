<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CLpIvObjective.
 */
#[ORM\Table(name: 'c_lp_iv_objective')]
#[ORM\Index(name: 'course', columns: ['c_id'])]
#[ORM\Index(name: 'lp_iv_id', columns: ['lp_iv_id'])]
#[ORM\Entity]
class CLpIvObjective
{
    #[ORM\Column(name: 'iid', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $iid = null;

    #[ORM\Column(name: 'c_id', type: 'integer')]
    protected int $cId;

    #[ORM\Column(name: 'lp_iv_id', type: 'integer', nullable: false)]
    protected int $lpIvId;

    #[ORM\Column(name: 'order_id', type: 'integer', nullable: false)]
    protected int $orderId;

    #[ORM\Column(name: 'objective_id', type: 'string', length: 255, nullable: false)]
    protected string $objectiveId;

    #[ORM\Column(name: 'score_raw', type: 'float', precision: 10, scale: 0, nullable: false)]
    protected float $scoreRaw;

    #[ORM\Column(name: 'score_max', type: 'float', precision: 10, scale: 0, nullable: false)]
    protected float $scoreMax;

    #[ORM\Column(name: 'score_min', type: 'float', precision: 10, scale: 0, nullable: false)]
    protected float $scoreMin;

    #[ORM\Column(name: 'status', type: 'string', length: 32, nullable: false)]
    protected string $status;

    #[ORM\Column(name: 'progress_measure', type: 'float', nullable: true)]
    protected ?float $progressMeasure = null;

    /**
     * @return CLpIvObjective
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
     * @return CLpIvObjective
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
     * @return CLpIvObjective
     */
    public function setObjectiveId(string $objectiveId)
    {
        $this->objectiveId = $objectiveId;

        return $this;
    }

    /**
     * @return string
     */
    public function getObjectiveId()
    {
        return $this->objectiveId;
    }

    /**
     * @return CLpIvObjective
     */
    public function setScoreRaw(float $scoreRaw)
    {
        $this->scoreRaw = $scoreRaw;

        return $this;
    }

    /**
     * @return float
     */
    public function getScoreRaw()
    {
        return $this->scoreRaw;
    }

    /**
     * @return CLpIvObjective
     */
    public function setScoreMax(float $scoreMax)
    {
        $this->scoreMax = $scoreMax;

        return $this;
    }

    /**
     * @return float
     */
    public function getScoreMax()
    {
        return $this->scoreMax;
    }

    /**
     * @return CLpIvObjective
     */
    public function setScoreMin(float $scoreMin)
    {
        $this->scoreMin = $scoreMin;

        return $this;
    }

    /**
     * @return float
     */
    public function getScoreMin()
    {
        return $this->scoreMin;
    }

    /**
     * @return CLpIvObjective
     */
    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return CLpIvObjective
     */
    public function setProgressMeasure(?float $progressMeasure)
    {
        $this->progressMeasure = $progressMeasure;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getProgressMeasure()
    {
        return $this->progressMeasure;
    }

    /**
     * @return CLpIvObjective
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
