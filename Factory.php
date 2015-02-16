<?php

namespace ChrKo\Bundles\SepaBundle;

use ChrKo\Bundles\SepaBundle\Entity\BankAccount;
use ChrKo\Bundles\SepaBundle\Entity\Creditor;
use ChrKo\Bundles\SepaBundle\Entity\DirectDebit;
use ChrKo\Bundles\SepaBundle\Entity\Mandate;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class Factory
 * @package ChrKo\Bundles\SepaBundle
 *
 * @DI\Service(id="chrko.sepa.factory")
 */
class Factory
{

    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $name
     * @param string $iban
     * @param string $bic
     *
     * @return BankAccount
     */
    public function createBankAccount($name, $iban, $bic)
    {
        $account = new BankAccount();
        $account
            ->setEventDispatcher($this->eventDispatcher)
            ->setName($name)
            ->setIban($iban)
            ->setBic($bic);

        return $account;
    }

    /**
     * @param BankAccount $bankAccount
     * @param             $creditorId
     *
     * @return Creditor
     */
    public function createCreditor(BankAccount $bankAccount, $creditorId)
    {
        $creditor = new Creditor();
        $creditor
            ->setBankAccount($bankAccount)
            ->setCreditorIdentifier($creditorId);

        return $creditor;
    }

    /**
     * @param $name
     * @param $iban
     * @param $bic
     * @param $creditorId
     *
     * @return Creditor
     */
    public function createCreditorFromScratch($name, $iban, $bic, $creditorId)
    {
        return $this->createCreditor($this->createBankAccount($name, $iban, $bic), $creditorId);
    }

    /**
     * @param BankAccount $bankAccount
     * @param             $mandateReference
     *
     * @return Mandate
     */
    public function createMandate(BankAccount $bankAccount, $mandateReference)
    {
        $mandate = new Mandate();
        $mandate
            ->setBankAccount($bankAccount)
            ->setMandateReference($mandateReference);

        return $mandate;
    }

    /**
     * @param $name
     * @param $iban
     * @param $bic
     * @param $mandateReference
     *
     * @return Mandate
     */
    public function createMandateFromScratch($name, $iban, $bic, $mandateReference)
    {
        return $this->createMandate($this->createBankAccount($name, $iban, $bic), $mandateReference);
    }

    /**
     * @param Creditor         $creditor
     * @param string|\DateTime $dueDate
     *
     * @return DirectDebit
     */
    public function createDirectDebit(Creditor $creditor, $dueDate = null)
    {
        $directDebit = new DirectDebit();
        $directDebit->setCreditor($creditor);
        if (!is_null($dueDate)) {
            $directDebit->setDueDate($dueDate);
        }

        return $directDebit;
    }
}