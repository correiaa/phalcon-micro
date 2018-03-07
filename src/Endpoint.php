<?php

namespace Nilnice\Phalcon;

use Nilnice\Phalcon\Http\Request;
use Nilnice\Phalcon\Support\Arr;

class Endpoint
{
    public const ALL = 'all';
    public const FIND = 'find';
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const REMOVE = 'remove';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $handler;

    /**
     * @var array
     */
    protected $allowedRoles = [];

    /**
     * @var array
     */
    protected $deniedRoles = [];

    /**
     * Endpoint constructor.
     *
     * @param string $path
     * @param string $method
     * @param string $handler
     */
    public function __construct(
        string $path,
        string $method = Request::GET,
        string $handler
    ) {
        $this->path = $path;
        $this->method = $method;
        $this->handler = $handler;
    }

    /**
     * @param string      $path
     * @param string      $method
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function factory(
        string $path,
        $method = Request::GET,
        $handler = null
    ) : Endpoint {
        return new Endpoint($path, $method, $handler);
    }

    /**
     * @return Endpoint
     */
    public static function all() : Endpoint
    {
        return self::factory('/', Request::GET, 'all')
            ->setName(self::ALL)
            ->setDescription('返回所有记录');
    }

    /**
     * @return Endpoint
     */
    public static function find() : Endpoint
    {
        return self::factory('/{id}', Request::GET, 'find')
            ->setName(self::FIND)
            ->setDescription('Returns the entity by {id}.');
    }

    /**
     * @return Endpoint
     */
    public static function create() : Endpoint
    {
        return self::factory('/', Request::POST, 'create')
            ->setName(self::CREATE)
            ->setDescription('Creates the entity using the posted data.');
    }

    /**
     * @return Endpoint
     */
    public static function update() : Endpoint
    {
        return self::factory('/{id}', Request::POST, 'update')
            ->setName(self::UPDATE)
            ->setDescription('Updates the entity by {id}, using the posted data.');
    }

    /**
     * @return Endpoint
     */
    public static function remove() : Endpoint
    {
        return self::factory('/{id}', Request::PUT, 'update')
            ->setName(self::REMOVE)
            ->setDescription('Removes the entity by {id}.');
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function get(string $path, $handler = null) : Endpoint
    {
        return self::factory($path, Request::GET, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function post(string $path, string $handler = null) : Endpoint
    {
        return self::factory($path, Request::POST, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function put(string $path, string $handler = null) : Endpoint
    {
        return self::factory($path, Request::PUT, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function delete(
        string $path,
        string $handler = null
    ) : Endpoint {
        return self::factory($path, Request::DELETE, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function head(string $path, string $handler = null) : Endpoint
    {
        return self::factory($path, Request::HEAD, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function options(
        string $path,
        string $handler = null
    ) : Endpoint {
        return self::factory($path, Request::OPTIONS, $handler);
    }

    /**
     * @param string      $path
     * @param string|null $handler
     *
     * @return Endpoint
     */
    public static function patch(
        string $path,
        string $handler = null
    ) : Endpoint {
        return self::factory($path, Request::PATCH, $handler);
    }

    /**
     * Set endpoint name.
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
     * Get endpoint name.
     *
     * @return string
     */
    public function getName() : ? string
    {
        return $this->name;
    }

    /**
     * Set endpoint description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description) : self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get endpoint description.
     *
     * @return string
     */
    public function getDescription() : ? string
    {
        return $this->description;
    }

    /**
     * Get HTTP request method.
     *
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * Get endpoint identifier.
     *
     * @return string
     */
    public function getIdentifier() : string
    {
        return $this->getMethod() . ' ' . $this->getPath();
    }

    /**
     * Get endpoint path.
     *
     * @return string
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Set endpoint handler.
     *
     * @param string $handler
     *
     * @return $this
     */
    public function setHandler(string $handler) : self
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get endpoint handler.
     *
     * @return string
     */
    public function getHandler() : string
    {
        return $this->handler;
    }

    /**
     * Allows access to this endpoint for role with the given names.
     *
     * @param ...array $roles
     *
     * @return Endpoint
     */
    public function setAllowRoles() : self
    {
        $roles = Arr::flatten(\func_get_args());
        foreach ($roles as $role) {
            if (! \in_array($role, $this->allowedRoles, true)) {
                $this->allowedRoles[] = $role;
            }
        }

        return $this;
    }

    /**
     * Get allow roles.
     *
     * @return array
     */
    public function getAllowRole() : array
    {
        return $this->allowedRoles;
    }

    /**
     * Denies access to this endpoint for role with the given names.
     *
     * @param ...array $roles
     *
     * @return Endpoint
     */
    public function setDenyRoles() : self
    {
        $roles = Arr::flatten(\func_get_args());
        foreach ($roles as $role) {
            if (! \in_array($role, $this->deniedRoles, true)) {
                $this->deniedRoles[] = $role;
            }
        }

        return $this;
    }

    /**
     * Get deny roles.
     *
     * @return array
     */
    public function getDenyRole() : array
    {
        return $this->deniedRoles;
    }
}
