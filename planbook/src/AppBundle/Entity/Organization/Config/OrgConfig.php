<?php
/**
 * Created by PhpStorm.
 * User: Andrew.Parise
 * Date: 8/31/2017
 * Time: 9:32 PM
 */

namespace AppBundle\Entity\Organization\Config;
use AppBundle\Entity\Organization\Organization;
use AppBundle\Repository\Organization\Config\OrgConfigRepository;

use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Table(name="org_config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Organization\Config\OrgConfigRepository")
 *
 * Configurations for the deployment environment on a per tenant basis
 *
 **/
class OrgConfig
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Organization
     *
     * llows for configurations to be set on a per tenant basis
     *
     * @ORM\ManyToOne(
     *     targetEntity="AppBundle\Entity\Organization\Organization",
     *     inversedBy="orgConfigurations"
     * )
     *
     *
     */
    protected $organization;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     */
    protected $variable;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 1)
     */
    protected $value;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     *
     * Timestamp for when this record was created
     *
     */
    protected $created_time;

    /**
     * @var DateTime
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
     * Timestamp for when this record was last updated
     *
     */
    protected $updated_time;

    /**
     * @var string
     * @ORM\Column(
     *     type="string",
     *     nullable=true
     * )
     *
     * User that last updated this record
     *
     */
    protected $updated_by;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * User that initially created this record
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