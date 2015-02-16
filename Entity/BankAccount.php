<?php

namespace ChrKo\Bundles\SepaBundle\Entity;

use ChrKo\Bundles\SepaBundle\Events\PropertySetEvent as Event;
use ChrKo\Bundles\SepaBundle\Interfaces\EventDispatcherAware as IEventDispatcherAware;
use ChrKo\Bundles\SepaBundle\Traits\EntityId;
use ChrKo\Bundles\SepaBundle\Traits\EventDispatcherAware;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Class BankAccount
 * @package ChrKo\Bundles\SepaBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table("chrko_bank_account")
 * @Gedmo\Loggable()
 */
class BankAccount
    implements IEventDispatcherAware
{
    use EventDispatcherAware, EntityId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Gedmo\Versioned()
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="iban", type="string", length=34)
     * @Gedmo\Versioned()
     */
    protected $iban;

    /**
     * @var string
     *
     * @ORM\Column(name="bic", type="string", length=11)
     * @Gedmo\Versioned()
     */
    protected $bic;

    /**
     * Sets the account owner name.
     *
     * @param string $name
     *
     * @return BankAccount
     */
    public function setName($name)
    {
        if ($this->eventDispatcher) {
            $event = new Event(Event::BANK_ACCOUNT_NAME, $name);
            $this->eventDispatcher->dispatch(Event::TYPE, $event);
        }

        $this->name = $name;

        return $this;
    }

    /**
     * Gets the account owner name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the IBAN on the account.
     *
     * @param string $iban IBAN
     *
     * @return BankAccount
     */
    public function setIban($iban)
    {
        if ($this->eventDispatcher) {
            $event = new Event(Event::IBAN, $iban);
            $this->eventDispatcher->dispatch(Event::TYPE, $event);
        }

        $this->iban = $iban;

        return $this;
    }


    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * Sets the BIC on the account
     *
     * @param string $bic BIC
     *
     * @return BankAccount
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function setBic($bic)
    {
        if ($this->eventDispatcher) {
            $event = new Event(Event::BIC, $bic);
            $this->eventDispatcher->dispatch(Event::TYPE, $event);
        }

        $this->bic = $bic;

        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }
}