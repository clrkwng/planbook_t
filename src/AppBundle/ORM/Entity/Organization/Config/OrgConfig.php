<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:32 PM
 */

namespace AppBundle\ORM\Entity\Organization\Config;
use AppBundle\ORM\Entity\Organization\Organization;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * @Entity(repositoryClass="OrgConfigRepository") @Table(name="org_config")
 *
 * @label('Configurations for the deployment environment on a per tenant basis')
 *
 **/
class OrgConfig
{
    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @var Organization
     *
     * @Label('Allows for configurations to be set on a per tenant basis')
     *
     * @ManyToOne(
     *     targetEntity="AppBundle\ORM\Entity\Organization\Organization",
     *     inversedBy="orgConfigurations"
     * )
     *
     */
    protected $organization;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $variable;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $value;

    /**
     * @var DateTime
     * @Column(type="date")
     *
     * @label('Timestamp for when this record was created')
     *
     */
    protected $created_time;

    /**
     * @var DateTime
     * @Column(type="date")
     *
     * @label('Timestamp for when this record was last updated')
     *
     */
    protected $updated_time;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('User that last updated this record')
     *
     */
    protected $updated_by;

    /**
     * @var string
     * @Column(type="string")
     *
     * @label('User that initially created this record')
     *
     */
    protected $created_by;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param Organization $organization
     */
    public function setOrganizationId(Organization $organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * @param string $variable
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return DateTime
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }

    /**
     * @param DateTime $created_time
     */
    public function setCreatedTime(DateTime $created_time)
    {
        $this->created_time = $created_time;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedTime()
    {
        return $this->updated_time;
    }

    /**
     * @param DateTime $updated_time
     */
    public function setUpdatedTime(DateTime $updated_time)
    {
        $this->updated_time = $updated_time;
    }

    /**
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param string $updated_by
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param string $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }



}