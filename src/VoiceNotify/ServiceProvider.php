<?php

namespace Volcengine\Vms\VoiceNotify;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        !isset($pimple['voice_notify']) && $pimple['voice_notify'] = function ($app) {
            return new Client($app);
        };
    }
}
