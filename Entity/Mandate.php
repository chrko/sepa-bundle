<?php

namespace ChrKo\Bundles\SepaBundle\Entity;

use ChrKo\Bundles\SepaBundle\Traits\EntityId;
use Exception as InvalidStateException;

use ChrKo\Bundles\SepaBundle\Interfaces\BankAccountUser as IBankAccountUser;
use ChrKo\Bundles\SepaBundle\Traits\BankAccountUser;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Class Mandate
 * @package ChrKo\Bundles\SepaBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="chrko_mandate")
 */
class Mandate
    implements IBankAccountUser
{
    use BankAccountUser, EntityId;

    const FIRST = 1;
    const RECURRING = 2;
    const LAST = 3;

    const UNIQUE = 'OOFF';
    const ONE_OFF = 'OOFF';

    /**
     * @var string
     *
     * @ORM\Column(name="mandate_reference", type="string", length=35)
     */
    protected $mandateReference;

    /**
     * @var bool
     *
     * @ORM\Column(name="mandate_reference_transmitted", type="boolean")
     */
    protected $mandateReferenceTransmitted = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mandate_date", type="date")
     */
    protected $mandateDate;

    /**
     * @var Mandate
     *
     * @ORM\ManyToOne(targetEntity="Mandate")
     * @ORM\JoinColumn(name="old_mandate_id", referencedColumnName="id")
     */
    protected $oldMandate = null;

    /**
     * @var string|integer
     *
     * @ORM\Column(name="type", type="string", length=5)
     */
    protected $type = null;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=5)
     */
    protected $state = null;

    public function __construct()
    {
        $this->mandateDate = new \DateTime();
    }

    /**
     * @param $mandateReference
     *
     * @return $this
     */
    public function setMandateReference($mandateReference)
    {
        if (!is_string($mandateReference)) {
            throw new \InvalidArgumentException('Mandate reference must be a string.');
        }
        if (preg_match('#^[0-9A-Za-z\',.:+-/()?]{1,35}$#', $mandateReference) === 0) {
            throw new \InvalidArgumentException('Invalid mandate reference string, ...');
        }

        $this->mandateReference = $mandateReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getMandateReference()
    {
        return $this->mandateReference;
    }

    /**
     * @param bool $mandateReferenceTransmitted
     *
     * @return $this
     */
    public function setMandateReferenceTransmitted($mandateReferenceTransmitted)
    {
        $this->mandateReferenceTransmitted = $mandateReferenceTransmitted;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMandateReferenceTransmitted()
    {
        return $this->mandateReferenceTransmitted;
    }

    /**
     * @param $mandateDate
     *
     * @return $this
     */
    public function setMandateDate($mandateDate)
    {
        if (is_string($mandateDate)) {
            $mandateDate = \DateTime::createFromFormat('Y-m-d', $mandateDate);
        }
        if (!($mandateDate instanceof \DateTime)) {
            throw new \InvalidArgumentException('Parameter $dueDate is not a \DateTime Object neither in format Y-m-d');
        }

        $mandateDate->setTime(12, 0, 0);

        $this->mandateDate = $mandateDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getMandateDate()
    {
        return $this->mandateDate;
    }

    /**
     * @param Mandate $oldMandate
     */
    public function setOldMandate(Mandate $oldMandate)
    {
        $this->oldMandate = $oldMandate;
    }

    /**
     * @return Mandate
     */
    public function getOldMandate()
    {
        return $this->oldMandate;
    }

    /**
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        if (!in_array($type, [static::RECURRING, static::UNIQUE], true)) {
            throw new \InvalidArgumentException('Only Mandate::RECURRING or Mandate::UNIQUE are allowed.');
        }

        if ($type === static::UNIQUE) {
            $this->state = static::ONE_OFF;
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return (string)$this->type;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public function isType($type)
    {
        return $this->type == $type;
    }

    /**
     * @param $state
     *
     * @return $this
     * @throws InvalidStateException
     */
    public function setState($state)
    {
        if (!in_array($state, [static::FIRST, static::RECURRING, static::LAST, static::ONE_OFF], true)) {
            throw new \InvalidArgumentException('Only Mandate::FIRST, Mandate::RECURRING, Mandate::LAST, Mandate::ONE_OFF');
        }

        switch ($this->type) {
            case static::RECURRING:
                switch ($this->state) {
                    case static::FIRST:
                        if (!in_array($state, [static::FIRST, static::RECURRING, static::LAST])) {
                            break;
                        }
                        break 2;
                    case static::RECURRING:
                        if (!in_array($state, [static::RECURRING, static::LAST])) {
                            break;
                        }
                        break 2;
                    case static::LAST:
                        if ($state !== static::LAST) {
                            break;
                        }
                        break 2;
                    case null:
                        break 2;
                    default:
                        throw new InvalidStateException('Here is something terrible wrong');
                }
                throw new InvalidStateException('Setting the state on failed.');
                break;
            case static::UNIQUE:
                if ($state !== static::ONE_OFF) {
                    throw new InvalidStateException('Cannot set any other state on a one time mandate.');
                }
                break;
            default:
                throw new InvalidStateException('Cannot set state, if no type is specified.');
        }

        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

}
