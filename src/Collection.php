<?php

namespace Nilnice\Phalcon;

use Illuminate\Support\Arr;
use Nilnice\Phalcon\Acl\MountableInterface;

class Collection extends \Phalcon\Mvc\Micro\Collection implements
    MountableInterface
{
    use CollectionTrait;

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
}
