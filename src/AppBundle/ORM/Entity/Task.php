<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/25/2017
 * Time: 9:03 PM
 */

namespace AppBundle\ORM\Entity;

/**
 * @Entity @Table(name="task")
 *
 * Base definition for a task
 *
 **/
class Task
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
     * User this task is assigned to
     *
     */
    protected $user_id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $description;

    /**
     * @var string
     * @Enum({"ACTIVE", "DISABLED", "DELETED"})
     * @Column(type="string")
     *
     * "ACTIVE"             = Task is active and available for Users to create instances of
     * "DISABLED"           = User has opted to temporarily turn off this Task; User can toggle back on
     * "DELETED"            = User has chosen to delete this Task entirely
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