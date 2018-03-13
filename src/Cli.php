<?php

namespace Nilnice\Phalcon;

use Nilnice\Phalcon\Constant\Service;
use Phalcon\Cli\Console;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class Cli extends Console
{
    /**
     * Attach middleware.
     *
     * @param \Phalcon\Mvc\Micro\MiddlewareInterface $middleware
     *
     * @return \Nilnice\Phalcon\Cli
     */
    public function attach(MiddlewareInterface $middleware) : self
    {
        if (! $this->getEventsManager()) {
            $this->setEventsManager(
                $this->getDI()->get(Service::EVENTS_MANAGER)
            );
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }
}
