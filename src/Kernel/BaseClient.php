<?php

namespace Volcengine\Vms\Kernel;

use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;

class BaseClient extends \Volcengine\Kernel\BaseClient
{
    protected function getRegion()
    {
        return $this->app['config']->get('region', 'cn-north-1');
    }

    protected function getVersion()
    {
        return $this->app['config']->get('version', '2020-09-01');
    }

    protected function getServiceName()
    {
        return '';
    }

    public function request(string $url, string $method = 'GET', array $options = [], $returnRaw = false)
    {
        $this->pushMiddleware($this->beforeRequestMiddleware(), 'vms_before_request');
        return parent::request($url, $method, $options, $returnRaw);
    }

    protected function beforeRequestMiddleware()
    {
        $that = $this;
        return static function (callable $handler) use ($that): callable {
            return static function (RequestInterface $request, array $options) use ($handler, $that) {
                if (!$request->hasHeader('ServiceName')) {
                    $request = $request->withHeader('ServiceName', $that->getServiceName());
                }
                if (!$request->hasHeader('Region')) {
                    $request = $request->withHeader('Region', $that->getRegion());
                }
                if (!$request->hasHeader('Content-Type')) {
                    $request = $request->withHeader('Content-Type', 'application/x-www-form-urlencoded');
                }
                $queryString = $request->getUri()->getQuery();
                $query = [];
                parse_str($queryString, $query);
                $query['Version'] = $that->getVersion();
                $request = $request->withUri($request->getUri()->withQuery(http_build_query($query)));
                return $handler($request, $options);
            };
        };
    }
}
