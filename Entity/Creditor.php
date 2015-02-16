<?php

namespace ChrKo\Bundles\SepaBundle\Entity;

use ChrKo\Bundles\SepaBundle\Interfaces\BankAccountUser as IBankAccountUser;
use ChrKo\Bundles\SepaBundle\Interfaces\EventDispatcherAware as IEventDispatcherAware;
use ChrKo\Bundles\SepaBundle\Traits\BankAccountUser;
use ChrKo\Bundles\SepaBundle\Traits\EntityId;
use ChrKo\Bundles\SepaBundle\Traits\EventDispatcherAware;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class Creditor
 * @package ChrKo\Bundles\SepaBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="chrko_creditor")
 */
class Creditor
    implements IBankAccountUser, IEventDispatcherAware
{
    use BankAccountUser, EventDispatcherAware, EntityId;

    /**
     * @var string
     *
     * @ORM\Column(name="creditor_identifier", type="string", length=30)
     */
    protected $creditorIdentifier = null;

    /**
     * @param string $creditorIdentifier
     *
     * @return $this
     */
    public function setCreditorIdentifier($creditorIdentifier)
    {
        $this->creditorIdentifier = $creditorIdentifier;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreditorIdentifier()
    {
        return $this->creditorIdentifier;
    }
}
