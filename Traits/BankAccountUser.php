<?php

namespace ChrKo\Bundles\SepaBundle\Traits;

use ChrKo\Bundles\SepaBundle\Entity\BankAccount;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Class BankAccountUser
 * @package ChrKo\Bundles\SepaBundle\Traits
 */
trait BankAccountUser
{
    /**
     * @var BankAccount
     *
     * @ORM\ManyToOne(targetEntity="BankAccount")
     * @ORM\JoinColumn(name="bank_account_id", referencedColumnName="id")
     * @Gedmo\Versioned()
     */
    protected $bankAccount;

    /**
     * @param BankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    /**
     * @return BankAccount
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->bankAccount->getName();
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->bankAccount->getIban();
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bankAccount->getBic();
    }
}
