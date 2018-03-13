<?php

namespace Nilnice\Phalcon;

use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

interface CliBootstrapInterface
{
    /**
     * Run cli some services.
     *
     * @param \Nilnice\Phalcon\Cli        $cli
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(Cli $cli, DiInterface $di, Ini $ini);
}
