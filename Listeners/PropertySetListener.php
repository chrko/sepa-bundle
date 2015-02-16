<?php

namespace ChrKo\Bundles\SepaBundle\Listeners;

use ChrKo\Bundles\SepaBundle\Events\PropertySetEvent;
use ChrKo\Bundles\SepaBundle\Interfaces\Driver;

/**
 * Class PropertySetListener
 * @package ChrKo\Bundles\SepaBundle\Listener
 */
class PropertySetListener
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @param Driver $driver
     */
    public function setDriver(Driver $driver) {
        $this->driver = $driver;
    }

    /**
     * @param PropertySetEvent $event
     */
    public function onPropertySet(PropertySetEvent $event)
    {
        switch ($event->getPropertyName()) {
            case PropertySetEvent::BANK_ACCOUNT_NAME:
                $length = mb_strlen($event->getPropertyValue());
                if (!($length > 0 && $length <= 70)) {
                    throw new \InvalidArgumentException('A bank account name must not blank and must not exceed 70 characters');
                }
                $event->stopPropagation();
                break;
            case PropertySetEvent::IBAN:
                if (!$this->driver->isIbanValid($event->getPropertyValue())) {
                    throw new \InvalidArgumentException('no valid iban');
                }
                $event->stopPropagation();
                break;
            case PropertySetEvent::BIC:
                if (!$this->driver->isBicValid($event->getPropertyValue())) {
                    throw new \InvalidArgumentException('this bic was not found');
                }
                $event->stopPropagation();
                break;
            default:
                dump($event);
        }
    }
}