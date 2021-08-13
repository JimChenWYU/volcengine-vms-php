<?php

namespace Volcengine\Vms\SecretNumber;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        !isset($pimple['secret_number']) && $pimple['secret_number'] = function ($app) {
            return new Client($app);
        };
    }
}
