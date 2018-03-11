<?php

namespace Nilnice\Phalcon;

use Nilnice\Phalcon\Constant\Service;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;
use Phalcon\Mvc\Micro\CollectionInterface;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * @property \Nilnice\Phalcon\Http\Request  $request
 * @property \Nilnice\Phalcon\Http\Response $response
 */
class App extends Micro
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
     * @var null|array
     */
    private $routeByName;

    /**
     * Attach middleware.
     *
     * @param \Phalcon\Mvc\Micro\MiddlewareInterface $middleware
     *
     * @return \Nilnice\Phalcon\App
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
     * @param \Phalcon\Mvc\Micro\CollectionInterface $collection
     *
     * @return \Nilnice\Phalcon\App
     */
    public function setCollection(CollectionInterface $collection) : self
    {
        $this->mount($collection);

        return $this;
    }

    /**
     * Get collection by name.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getCollection(string $name)
    {
        return $this->collectionByName[$name] ?? null;
    }

    /**
     * Get all collections.
     *
     * @return array
     */
    public function getCollections() : array
    {
        return array_values($this->collectionByIdentifier);
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
        /** @var \Nilnice\Phalcon\Collection|\Nilnice\Phalcon\Resource $collection */
        if ($collection instanceof Collection) {
            $name = $collection->getName();
            $identifier = $collection->getPrefix();

            if ($name !== null) {
                $this->collectionByName[$name] = $collection;
            }
            $this->collectionByIdentifier[$identifier] = $collection;

            /** @var \Nilnice\Phalcon\Endpoint $endpoint */
            foreach ($collection->getEndpoints() as $endpoint) {
                $identifier = $collection->getIdentifier()
                    . ' '
                    . $endpoint->getIdentifier();

                $this->endpointByIdentifier[$identifier] = $endpoint;
            }
        }

        return parent::mount($collection);
    }

    /**
     * @return mixed|null
     */
    public function getMatchedCollection()
    {
        $identifier = $this->getMatchedRouteUri('collection');

        if (! $identifier) {
            return null;
        }

        return $this->collectionByIdentifier[$identifier] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getMatchedEndpoint()
    {
        $collectionIdentifier = $this->getMatchedRouteUri('collection');
        $endpointIdentifier = $this->getMatchedRouteUri('endpoint');

        if (! $endpointIdentifier) {
            return null;
        }

        $identifier = $collectionIdentifier . ' ' . $endpointIdentifier;

        return $this->endpointByIdentifier[$identifier] ?? null;
    }

    /**
     * Returns the route that matches the handled URI.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    private function getMatchedRouteUri(string $name)
    {
        if ($this->routeByName === null) {
            $routeName = $this->getRouter()->getMatchedRoute()->getName();

            if (! $routeName) {
                return null;
            }

            $this->routeByName = unserialize(
                $routeName,
                ['allow_classes' => false]
            );
        }

        if (\is_array($this->routeByName)
            && array_key_exists($name, $this->routeByName)
        ) {
            return $this->routeByName[$name];
        }

        return null;
    }
}
