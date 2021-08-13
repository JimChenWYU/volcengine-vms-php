<?php

namespace Volcengine\Vms;

use Closure;
use Volcengine\Vms\Kernel\ServiceContainer;

/**
 * Class Application
 *
 * @property \Volcengine\Vms\SecretNumber\Client  $secret_number
 * @property \Volcengine\Vms\VoiceNotify\Client   $voice_notify
 */
class Application extends ServiceContainer
{
    protected $providers = [
        SecretNumber\ServiceProvider::class,
        VoiceNotify\ServiceProvider::class,
    ];

    /**
     * @param Closure $closure
     * @return false|mixed
     * @throws \Volcengine\Kernel\Exceptions\Exception
     * @throws \Volcengine\Kernel\Exceptions\InvalidSignException
     * @throws \Volcengine\Vms\Kernel\Exceptions\RequestExpiredException
     */
    public function handleMessageNotify(Closure $closure)
    {
        return (new MessageNotify\MessageNotify($this))->handle($closure);
    }

    public function getAuthToken(): string
    {
        return $this['config']->get('auth_token', '');
    }
}
