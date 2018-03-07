<?php

namespace Nilnice\Phalcon;

use Nilnice\Phalcon\Http\Request;

trait CollectionTrait
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $endpoints = [];

    /**
     * @var string
     */
    protected $collectionKey;

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription(string $description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Set collection endpoint.
     *
     * @param \Nilnice\Phalcon\Endpoint $endpoint
     *
     * @return $this
     */
    public function setEndpoint(Endpoint $endpoint) : self
    {
        $this->endpoints[$endpoint->getName()] = $endpoint;
        $routePattern = $endpoint->getPath();
        $handler = $endpoint->getHandler();
        $name = $this->createRouteName($endpoint);

        switch ($endpoint->getMethod()) {
            case Request::GET:
                $this->get($routePattern, $handler, $name);
                break;
            case Request::POST:
                $this->post($routePattern, $handler, $name);
                break;
            case Request::PUT:
                $this->put($routePattern, $handler, $name);
                break;
            case Request::DELETE:
                $this->delete($routePattern, $handler, $name);
                break;
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function getEndpoint(string $name)
    {
        return $this->endpoints[$name] ?? null;
    }

    /**
     * Get all endpoints.
     *
     * @return array
     */
    public function getEndpoints() : array
    {
        return array_values($this->endpoints);
    }

    /**
     * Set collection key.
     *
     * @param string $collectionKey
     *
     * @return $this
     */
    public function setCollectionKey(string $collectionKey) : self
    {
        $this->collectionKey = $collectionKey;

        return $this;
    }

    /**
     * Get collection key.
     *
     * @return string
     */
    public function getCollectionKey() : string
    {
        return $this->collectionKey ?: $this->name ?: 'item';
    }

    /**
     * Get identifier.
     *
     * @return string
     */
    public function getIdentifier() : string
    {
        return $this->getPrefix();
    }

    /**
     * @param \Nilnice\Phalcon\Endpoint $endpoint
     *
     * @return string
     */
    protected function createRouteName(Endpoint $endpoint) : string
    {
        return serialize([
            'collection' => $this->getIdentifier(),
            'endpoint'   => $endpoint->getIdentifier(),
        ]);
    }
}
