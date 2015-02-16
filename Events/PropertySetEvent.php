<?php

namespace ChrKo\Bundles\SepaBundle\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class PropertySetEvent
 * @package ChrKo\Bundles\SepaBundle\Event
 */
class PropertySetEvent
    extends Event
{
    const TYPE = 'chrko.sepa.property_set';

    const BANK_ACCOUNT_NAME = 'bank_account.name';

    const IBAN = 'iban';

    const BIC = 'bic';


    protected $propertyName;
    protected $propertyValue;

    /**
     * @param $propertyName
     * @param $propertyValue
     */
    public function __construct($propertyName, $propertyValue)
    {
        $this->propertyName = $propertyName;
        $this->propertyValue = $propertyValue;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @return string
     */
    public function getPropertyValue()
    {
        return $this->propertyValue;
    }
}