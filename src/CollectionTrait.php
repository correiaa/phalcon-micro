<?php

namespace Nilnice\Phalcon;

use Phalcon\Mvc\Collection;

trait CollectionTrait
{
    /**
     * @var string
     */
    protected $collectionKey;

    /**
     * Set collection key.
     *
     * @param string $collectionKey
     *
     * @return \Phalcon\Mvc\Collection
     */
    public function setCollectionKey(string $collectionKey) : Collection
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
}
