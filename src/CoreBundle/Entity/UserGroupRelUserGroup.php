<?php

declare(strict_types=1);

/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GroupRelGroup.
 */
#[ORM\Table(name: 'usergroup_rel_usergroup')]
#[ORM\Entity]
class UserGroupRelUserGroup
{
    #[ORM\Column(name: 'id', type: 'integer')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[ORM\Column(name: 'group_id', type: 'integer', nullable: false)]
    protected int $groupId;

    #[ORM\Column(name: 'subgroup_id', type: 'integer', nullable: false)]
    protected int $subgroupId;

    #[ORM\Column(name: 'relation_type', type: 'integer', nullable: false)]
    protected int $relationType;

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @return $this
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSubgroupId()
    {
        return $this->subgroupId;
    }

    /**
     * @return $this
     */
    public function setSubgroupId(int $subgroupId)
    {
        $this->subgroupId = $subgroupId;

        return $this;
    }

    /**
     * @return int
     */
    public function getRelationType()
    {
        return $this->relationType;
    }

    /**
     * @return $this
     */
    public function setRelationType(int $relationType)
    {
        $this->relationType = $relationType;

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
