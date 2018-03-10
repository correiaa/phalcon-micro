<?php

namespace Nilnice\Phalcon;

use Illuminate\Support\Arr;
use Nilnice\Phalcon\Http\Request;
use Phalcon\Acl;
use Phalcon\Acl\Resource as AclResource;

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
     * @var array
     */
    protected $allowRoles = [];

    /**
     * @var array
     */
    protected $denyRoles = [];

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
     * @return null|string
     */
    public function getDescription() : ? string
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
     * Allows access to this endpoint for role with the given names.
     *
     * @param ...array $roles
     *
     * @return \Nilnice\Phalcon\Collection
     */
    public function setAllowRoles() : self
    {
        $roles = Arr::flatten(\func_get_args());
        foreach ($roles as $role) {
            if (! \in_array($roles, $this->allowRoles, true)) {
                $this->allowRoles[] = $role;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAllowRoles() : array
    {
        return $this->allowRoles;
    }

    /**
     * Denies access to this endpoint for role with the given names.
     *
     * @param ...array $roles
     *
     * @return $this
     */
    public function setDenyRoles() : self
    {
        $roles = Arr::flatten(\func_get_args());
        foreach ($roles as $role) {
            if (! \in_array($roles, $this->denyRoles, true)) {
                $this->denyRoles[] = $role;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDenyRoles() : array
    {
        return $this->denyRoles;
    }

    /**
     * Get Acl resources.
     *
     * @return array
     */
    public function getAclResources() : array
    {
        $endpointIdentifier = array_map(function (Endpoint $endpoint) {
            return $endpoint->getIdentifier();
        }, $this->endpoints);

        $resource = new AclResource(
            $this->getIdentifier(),
            $this->getDescription()
        );

        return [$resource, $endpointIdentifier];
    }

    /**
     * Get Acl roles.
     *
     * @param array $roles
     *
     * @return array
     */
    public function getAclRoles(array $roles) : array
    {
        $allowedRoles = $deniedRoles = [];
        $defaultAllowRoles = $this->allowRoles;
        $defaultDenyRoles = $this->denyRoles;

        /** @var \Phalcon\Acl\Role $role */
        foreach ($roles as $role) {
            /** @var \Nilnice\Phalcon\Endpoint $endpoint */
            foreach ($this->endpoints as $endpoint) {
                $rule = null;
                $allowCollection = collect(array_merge(
                    $defaultAllowRoles,
                    $endpoint->getAllowRole()
                ));
                $denyCollection = collect(array_merge(
                    $defaultDenyRoles,
                    $endpoint->getDenyRole()
                ));

                if ($allowCollection->contains($role->getName())) {
                    $rule = true;
                }

                if ($denyCollection->contains($role->getName())) {
                    $rule = false;
                }

                if ($rule === true) {
                    $allowedRoles = [
                        $role->getName(),
                        $this->getIdentifier(),
                        $endpoint->getIdentifier(),
                    ];
                }

                if ($rule === false) {
                    $deniedRoles = [
                        $role->getName(),
                        $this->getIdentifier(),
                        $endpoint->getIdentifier(),
                    ];
                }
            }
        }

        return [Acl::ALLOW => $allowedRoles, Acl::DENY => $deniedRoles];
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
