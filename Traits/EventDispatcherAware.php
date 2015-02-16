<?php

namespace ChrKo\Bundles\SepaBundle\Traits;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class EventDispatcherAware
 * @package ChrKo\Bundles\SepaBundle\Traits
 */
trait EventDispatcherAware {
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher = null;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return $this
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;

        return $this;
    }

    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }
}