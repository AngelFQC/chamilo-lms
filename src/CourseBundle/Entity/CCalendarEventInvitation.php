<?php


namespace Chamilo\CourseBundle\Entity;

use Chamilo\CoreBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CCalendarEventInvitation.
 *
 * @package Chamilo\CourseBundle\Entity
 *
 * @ORM\Table(name="c_calendar_event_invitation")
 * @ORM\Entity()
 */
class CCalendarEventInvitation
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Chamilo\CourseBundle\Entity\CCalendarEvent", cascade={"persist"}, inversedBy="invitations")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="iid", onDelete="CASCADE")
     */
    protected CCalendarEvent $event;

    /**
     * @ORM\ManyToOne(targetEntity="Chamilo\CoreBundle\Entity\User", inversedBy="c_calendar_event_invitations")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     */
    protected User $user;

}
