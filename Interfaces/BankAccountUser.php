<?php

namespace ChrKo\Bundles\SepaBundle\Interfaces;

use ChrKo\Bundles\SepaBundle\Entity\BankAccount;

/**
 * Interface BankAccountUser
 * @package ChrKo\Bundles\SepaBundle\Interfaces
 */
interface BankAccountUser
{
    /**
     * @param BankAccount $bankAccount
     *
     * @return $this
     */
    public function setBankAccount(BankAccount $bankAccount);

    /**
     * @return BankAccount
     */
    public function getBankAccount();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIban();

    /**
     * @return string
     */
    public function getBic();
}
