<?php

namespace Nilnice\Phalcon;

use Illuminate\Support\Arr;
use Nilnice\Phalcon\Acl\MountableInterface;

class Collection extends \Phalcon\Mvc\Micro\Collection implements
    MountableInterface
{
    use CollectionTrait;

    /**
     * @var array
     */
    protected $allowRoles = [];

    /**
     * @var array
     */
    protected $denyRoles = [];

    /**
     * Collection constructor.
     *
     * @param string $prefix
     */
    public function __construct(string $prefix)
    {
        parent::setPrefix($prefix);

        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }
    }

    /**
     * @param string      $prefix
     * @param string|null $name
     *
     * @return \Nilnice\Phalcon\Collection
     */
    public static function factory(
        string $prefix,
        string $name = null
    ) : Collection {
        $class = static::class;

        /** @var \Nilnice\Phalcon\Collection $collection */
        $collection = new $class($prefix);

        if ($name) {
            $collection->setName($name);
        }

        return $collection;
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
}
