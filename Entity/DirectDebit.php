<?php

namespace ChrKo\Bundles\SepaBundle\Entity;

use ChrKo\Bundles\SepaBundle\Traits\EntityId;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DirectDebit
 * @package ChrKo\Bundles\SepaBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="chrko_direct_debit")
 */
class DirectDebit
{
    use EntityId;

    /**
     * @var Creditor
     *
     * @ORM\ManyToOne(targetEntity="Creditor")
     * @ORM\JoinColumn(name="creditor_id", referencedColumnName="")
     */
    protected $creditor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="date")
     */
    protected $dueDate;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float")
     */
    protected $amount = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", nullable=true)
     */
    protected $reference = null;

    /**
     * @var Mandate[]
     *
     * @ORM\ManyToMany(targetEntity="Mandate")
     * @ORM\JoinTable(name="chrko_direct_debit_mandates")
     */
    protected $mandates;

    public function __construct()
    {
        $this->setDueDate(new \DateTime());
        $this->mandates = new ArrayCollection();
    }

    /**
     * @param Creditor $creditor
     *
     * @return $this
     */
    public function setCreditor(Creditor $creditor)
    {
        $this->creditor = $creditor;

        return $this;
    }

    /**
     * @return Creditor
     */
    public function getCreditor()
    {
        return $this->creditor;
    }

    /**
     * @param string|\DateTime $dueDate
     *
     * @return $this
     */
    public function setDueDate($dueDate)
    {
        if (is_string($dueDate)) {
            $dueDate = \DateTime::createFromFormat('Y-m-d', $dueDate);
        }
        if (!($dueDate instanceof \DateTime)) {
            throw new \InvalidArgumentException('Parameter $dueDate is not a \DateTime Object neither in format Y-m-d');
        }

        $dueDate->setTime(12, 0, 0);

        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param float $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $amount = (float)$amount;
        if (!(is_float($amount) && $amount >= 0)) {
            throw new \InvalidArgumentException('Cannot set $amount ' . $amount);
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function addMandate(Mandate $mandate)
    {
        $this->mandates[] = $mandate;

        return $this;
    }

    /**
     * @param Mandate $mandate
     *
     * @return $this
     */
    public function removeMandate(Mandate $mandate)
    {
        $this->mandates->removeElement($mandate);

        return $this;
    }

    /**
     * @return Mandate[]
     */
    public function getMandates()
    {
        return $this->mandates;
    }
}
