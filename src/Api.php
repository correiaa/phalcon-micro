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
     * @var array
     */
    protected $collectionByName = [];

    /**
     * @var array
     */
    protected $collectionByIdentifier = [];

    /**
     * @var array
     */
    protected $endpointByIdentifier = [];

    /**
     * Attach middleware.
     *
     * @param \Phalcon\Mvc\Micro\MiddlewareInterface $middleware
     *
     * @return \Nilnice\Phalcon\Api
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

    /**
     * Set collection.
     *
     * @param \Nilnice\Phalcon\Collection $collection
     *
     * @return \Nilnice\Phalcon\Api
     */
    public function setCollection(Collection $collection) : self
    {
        $this->mount($collection);

        return $this;
    }

    public function getCollection()
    {
        return $this->collectionByName ?? null;
    }

    /**
     * @return array
     */
    public function getCollections() : array
    {
        return array_values($this->collectionByIdentifier);
    }

    /**
     * Set resource.
     *
     * @param Resource $resource
     *
     * @return \Nilnice\Phalcon\Api
     */
    public function setResource(Resource $resource) : self
    {
        $this->mount($resource);

        return $this;
    }


    /**
     * Mounts a collection of handlers.
     *
     * @param \Phalcon\Mvc\Micro\CollectionInterface $collection
     *
     * @return \Phalcon\Mvc\Micro
     */
    public function mount(CollectionInterface $collection) : Micro
    {
        if ($collection instanceof Collection) {
            $name = $collection->getName();
            $identifier = $collection->getPrefix();

            if ($name !== null) {
                $this->collectionByName[$name] = $collection;
            }
            $this->collectionByIdentifier[$identifier] = $collection;

            /** @var \Nilnice\Phalcon\Endpoint $endpoint */
            foreach ($collection->getEndpoints() as $endpoint) {
                $identifier = $collection->getIdentifier() . ' '
                    . $endpoint->getIdentifier();

                $this->endpointByIdentifier[$identifier] = $endpoint;
            }
        }

        return parent::mount($collection);
    }
}
