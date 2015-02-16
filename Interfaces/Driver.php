<?php

namespace ChrKo\Bundles\SepaBundle\Interfaces;

use ChrKo\Bundles\SepaBundle\Entity\DirectDebit;

/**
 * Interface Driver
 * @package ChrKo\Bundles\SepaBundle\Interfaces
 */
interface Driver {

    /**
     * @param string $iban
     *
     * @return bool
     */
    public function isIbanValid($iban);

    /**
     * @param string $bic
     *
     * @return bool
     */
    public function isBicValid($bic);

    /**
     * @param string $account
     * @param string $bankNumber
     *
     * @return string|null
     */
    public function convertToIban($account, $bankNumber);

    /**
     * @param string $iban
     *
     * @return string|null
     */
    public function getBicByIban($iban);

    /**
     * @param DirectDebit $directDebit
     *
     * @return string
     */
    public function generateDirectDebitXml(DirectDebit $directDebit);
}