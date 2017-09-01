<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:02 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="task_repeat")
 *
 * Definition for a task that occurs on a recurrent basis
 *
 **/
class TaskRepeat
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
     * Base task to inherit from
     *
     */
    protected $task_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Task's default priority to be inherited by each single instance
     *
     */
    protected $priority_id;

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     *
     * Task's repetition frequency; used for creation of `Task_Repeat_Single`
     *
     */
    protected $frequency_id;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, this will override the name specified in the associated base task
     *
     */
    protected $name_ov;

    /**
     * @var string
     * @Column(type="string")
     *
     * If provided, this will override the description specified in the associated base task
     *
     */
    protected $description_ov;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = TaskRepeat is active and actively created new single occurrences
     * "DISABLED"           = User has opted to temporarily turn off this TaskRepeat; User can toggle back on
     * "DELETED"            = User has chosen to delete this TaskRepeat entirely
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