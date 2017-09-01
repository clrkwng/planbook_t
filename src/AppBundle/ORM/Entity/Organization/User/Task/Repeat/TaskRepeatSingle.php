<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:04 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="task_repeat_single")
 *
 * A single occurrence of a task that occurs on a recurrent basis
 *
 **/
class TaskRepeatSingle
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Base repeat task to inherit from
     *
     */
    protected $task_repeat_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * If provided, will override the priority defined in the corresponding `Task_Repeat` record for this instance
     *
     */
    protected $priority_id_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * UNIX timestamp for when the task must be completed by
     *
     */
    protected $deadline;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, will override the name defined in the corresponding `Task_Repeat` record for this instance
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, will override the description defined in the corresponding `Task_Repeat` record for this instance
     *
     */
    protected $description_ov;

    /**
     * @var string
     * @Enum({"NOT_VIEWED", "IN_PROGRESS", "COMPLETED", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "NOT_VIEWED"     = User is prompted with a notification
     * "IN_PROGRESS"    = User can view in their task dashboard; User can mark as complete
     * "COMPLETED"      = User can view in their task dashboard; User can not mark as complete; Points have been added
     * "DISABLED"       = Hidden from user's display; Admin can see the task, edit, and toggle the task's visibility
     * "DELETED"        = Hidden from both the user and the admin's display
     *
     */
    protected $state;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}