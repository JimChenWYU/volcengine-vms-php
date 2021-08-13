<?php

namespace Volcengine\Vms\MessageNotify;

use Closure;
use Volcengine\Kernel\Exceptions\Exception;
use Volcengine\Kernel\Exceptions\InvalidSignException;
use Volcengine\Vms\Application;
use Volcengine\Vms\Kernel\Exceptions\RequestExpiredException;

class MessageNotify
{
    /**
     * @var Application
     */
    protected $app;
    /**
     * @var array
     */
    protected $message;

    /**
     * @var bool
     */
    protected $check = true;

    /**
     * Recorded constructor.
     * @param Application $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param Closure $closure
     * @return false|mixed
     * @throws Exception
     * @throws InvalidSignException
     * @throws RequestExpiredException
     */
    public function handle(Closure $closure)
    {
        return \call_user_func($closure, $this->getMessage(), $this->app['request']);
    }

    /**
     * @return array
     * @throws Exception
     * @throws InvalidSignException
     * @throws RequestExpiredException
     */
    protected function getMessage(): array
    {
        if (!empty($this->message)) {
            return $this->message;
        }

        $timestamp = $this->app['request']->get('timestamp');
        $authCode = $this->app['request']->get('authCode');
        $message = json_decode($this->app['request']->getContent(), true);

        if (!is_array($message) || empty($message)) {
            throw new Exception('Invalid request JSON.', 400);
        }

        if ($this->check) {
            $this->validate($message, $timestamp, $authCode);
        }

        return $this->message = $message;
    }

    /**
     * @param array  $message
     * @param string $timestamp
     * @param string $authCode
     * @throws InvalidSignException
     * @throws RequestExpiredException
     */
    protected function validate(array $message, string $timestamp, string $authCode)
    {
        /** @see https://www.volcengine.com/docs/6358/67484 */
        if (time() - $timestamp > 300) {
            throw new RequestExpiredException();
        }

        $hashBody = hash('sha256', json_encode($message));
        $sign = hash('sha256', $timestamp . $hashBody . $this->app->getAuthToken());
        if ($sign !== $authCode) {
            throw new InvalidSignException();
        }
    }
}
