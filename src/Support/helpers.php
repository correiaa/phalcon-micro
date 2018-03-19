<?php

use Phalcon\Di;

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param null $make
     *
     * @return \Phalcon\DiInterface
     */
    function app($make = null)
    {
        if ($make === null) {
            return Di::getDefault();
        }

        return Di::setDefault($make);
    }
}