<?php

namespace ChrKo\Bundles\SepaBundle\Interfaces;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Interface EventDispatcherAware
 * @package ChrKo\Bundles\SepaBundle\Interfaces
 */
interface EventDispatcherAware {

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return mixed
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);
}