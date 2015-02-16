<?php

namespace ChrKo\Bundles\SepaBundle\Drivers;

use JMS\DiExtraBundle\Annotation as DI;
use ChrKo\Bundles\SepaBundle\Interfaces\Driver;
use ChrKo\Bundles\SepaBundle\Entity\Mandate;
use ChrKo\Bundles\SepaBundle\Entity\DirectDebit;

use \Exception as InvalidStateException;

/**
 * Class Libsepa
 * @package ChrKo\Bundles\SepaBundle\Drivers
 */
class Libsepa
    implements Driver
{

    public function __construct($user, $code)
    {
        \SEPA::init(SEPA_INIT_LICUSER, $user);
        \SEPA::init(SEPA_INIT_LICCODE, $code);
    }

    /**
     * @param string $iban
     *
     * @return bool
     */
    public function isIbanValid($iban)
    {
        return \SEPA::IBAN_check($iban);
    }

    /**mixed
     * @param $bic
     *
     * @return bool
     */
    public function isBicValid($bic)
    {
        $bankName = \SEPA::BIC_getBankName($bic);
        if (is_null($bankName)) {
            $bic = substr($bic, 0, -3) . 'XXX';
            $bankName = \SEPA::BIC_getBankName($bic);

            if (is_null($bankName)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $account
     * @param string $bankNumber
     *
     * @return string|null
     */
    public function convertToIban($account, $bankNumber)
    {
        return \SEPA::IBAN_convert('DE', $account, $bankNumber);
    }

    /**
     * @param string $iban
     *
     * @return string|null
     */
    public function getBicByIban($iban) {
        return \SEPA::IBAN_getBic($iban);
    }

    /**
     * @param DirectDebit $directDebit
     *
     * @return mixed
     * @throws InvalidStateException
     */
    public function generateDirectDebitXml(DirectDebit $directDebit)
    {
        \SEPA::init(SEPA_INIT_LICUSER, 'radioaktiv Campusradio Rhein-Neckar e.V.');
        \SEPA::init(SEPA_INIT_LICCODE, 'ACQDL-TYHHK-KRXFH');

        $libsepa = new \SEPA(SEPA_MSGTYPE_DDI);

        $libsepa->setName($directDebit->getCreditor()->getName());
        $libsepa->setCreditorIdentifier($directDebit->getCreditor()->getCreditorIdentifier());
        $libsepa->setIBAN($directDebit->getCreditor()->getIban());
        $libsepa->setBIC($directDebit->getCreditor()->getBic());

        $libsepa->setDate($directDebit->getDueDate()->format('Y-m-d'));

        foreach ($directDebit->getMandates() as $mandate) {
            $tx = [
                'name'   => $mandate->getName(),
                'iban'   => $mandate->getIban(),
                'bic'    => $mandate->getBic(),
                'mref'   => $mandate->getMandateReference(),
                'mdate'  => $mandate->getMandateDate()->format('Y-m-d'),
                'amount' => $directDebit->getAmount()
            ];

            if ($directDebit->getReference() != null) {
                $tx['ref'] = $directDebit->getReference();
            }

            switch ($mandate->getState()) {
                case Mandate::FIRST:
                    $tx['seq'] = 'FRST';
                    break;
                case Mandate::RECURRING:
                    $tx['seq'] = 'RCUR';
                    break;
                case Mandate::LAST:
                    $tx['seq'] = 'FNAL';
                    break;
                case Mandate::ONE_OFF:
                    $tx['seq'] = 'OOFF';
                    break;
                default:
                    throw new InvalidStateException('No valid state in $mandate');
            }

            if ($mandate->isType(Mandate::RECURRING) && $mandate->getOldMandate() instanceof Mandate) {
                if ($mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() != $mandate->getOldMandate()->getBic()
                ) {
                    $tx['smnda'] = 1;
                }

                if ($mandate->getState() != Mandate::FIRST
                    && $mandate->getMandateReference() != $mandate->getOldMandate()->getMandateReference()
                ) {
                    $tx['old_mref'] = $mandate->getOldMandate()->getMandateReference();
                }

                if ($mandate->getState() != Mandate::FIRST
                    && $mandate->getIban() != $mandate->getOldMandate()->getIban()
                    && $mandate->getBic() == $mandate->getOldMandate()->getBic()
                ) {
                    $tx['old_iban'] = $mandate->getOldMandate()->getIban();
                }
            }

            $libsepa->add($tx);
        }

        return $libsepa->toXML();
    }
}