<?php

namespace Nilnice\Phalcon;

use Nilnice\Phalcon\Constant\Service;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\CollectionInterface;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * @property \Nilnice\Phalcon\Http\Request  $request
 * @property \Nilnice\Phalcon\Http\Response $response
 */
class Api extends Micro
{
    /**
     * @param $middleware
     *
     * @return $this
     */
    public function attach(MiddlewareInterface $middleware) : self
    {
        if (! $this->getEventsManager()) {
            $eventsManager = $this->getDI()->get(Service::EVENTS_MANAGER);
            $this->setEventsManager($eventsManager);
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }

    public function mount(CollectionInterface $collection)
    {
        return parent::mount($collection);
    }
}
