<?php

namespace Wanjee\Shuwee\ConfigBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class Parameter
 * @package Wanjee\Shuwee\ConfigBundle\Entity
 *
 * @ORM\Table(name="shuwee_parameters")
 * @ORM\Entity()
 *
 * @UniqueEntity(
 *   fields={"machineName"},
 *   message="The machine name must be unique."
 * )
 *
 */
class Parameter implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Administrative name
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * Machine name
     *
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     */
    private $machineName;

    /**
     * This maps to available Symfony2 form types
     * @see http://symfony.com/doc/current/reference/forms/types.html
     *
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(choices = {"text", "textarea", "integer", "number", "date", "datetime", "email", "url"}, message = "Choose a valid type.")
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * Serialized version of the form displayed value
     * @ORM\Column(type="text", nullable=true)
     */
    private $value;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMachineName()
    {
        return $this->machineName;
    }

    /**
     * @param mixed $machineName
     */
    public function setMachineName($machineName)
    {
        $this->machineName = $machineName;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get serialized value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set serialized value.
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * "ValueInput" is a fake field.
     *
     * @return mixed
     */
    public function getValueInput()
    {
        $valueInput = unserialize($this->value);

        // if value is set it should already be of the correct type
        if (!$valueInput) {
            // Otherwise ensure we have a valid null|default value depending on current type
            // "text", "textarea", "integer", "number", "date", "datetime", "email", "url"
            switch ($this->getType()) {
                case 'integer':
                case 'number':
                    $valueInput = null;
                    break;
                case 'date':
                case 'datetime':
                    $valueInput = new \DateTime();
                    break;

                case 'text':
                case 'textarea':
                case 'email':
                case 'url':
                default :
                    $valueInput = '';
                    break;
            }
        }
        // if value was

        return $valueInput;
    }

    /**
     * @param mixed $valueInput
     */
    public function setValueInput($valueInput)
    {
        $this->value = serialize($valueInput);
    }

    /**
     * Get Javascript optimised format for value field
     *
     * @return mixed Raw value|object to be json encoded
     */
    public function getValueJson()
    {
        $valueOutput = unserialize($this->value);

        switch ($this->getType()) {
            case 'date':
            case 'datetime':
                if ($valueOutput instanceof \Datetime) {
                    return $valueOutput->format(\DateTime::ISO8601);
                }
                else {
                    return null;
                }
                break;
            case 'text':
            case 'textarea':
            case 'email':
            case 'url':
            case 'integer':
            case 'number':
            default :
                return $valueOutput;
                break;
        }
    }

    /**
     * @return mixed Returns data which can be serialized by json_encode().
     */
    function jsonSerialize()
    {
        return array(
            'name' => $this->machineName,
            'type' => $this->type,
            'value' => $this->getValueJson(),
        );
    }

}