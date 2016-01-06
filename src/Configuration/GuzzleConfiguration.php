<?php

namespace Northwoods\CCCF\Configuration;

use Auryn\Injector;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Equip\Configuration\ConfigurationInterface;
use Equip\Env;

class GuzzleConfiguration implements ConfigurationInterface
{
    const BASE_URL = 'http://www.cookcountychamber.org/api/';

    protected $env;

    public function __construct(Env $env)
    {
        $this->env = $env;
    }

    public function apply(Injector $injector)
    {
        $injector->delegate(Client::class, [$this, 'makeClient']);
    }

    public function makeClient(Injector $injector)
    {
        if (empty($this->env['chamber_api_secret'])) {
            throw new \DomainException('Bad API configuration');
        }

        $handler = $injector->execute([$this, 'makeStack']);
        return new Client(compact('handler'));
    }

    public function makeStack(CurlHandler $curl, HandlerStack $stack)
    {
        $stack->setHandler($curl);

        $stack->push(function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $method = $request->getMethod();
                $uri = '/' . trim($request->getUri()->getPath(), '/');
                $qs = $request->getUri()->getQuery();

                if ($qs) {
                    $qs = '?' . $qs;
                }

                $header = $this->getAuthenticationHeader($method, $uri);

                $request = $request->withHeader('Authentication', $header);
                $request = $request->withUri(Psr7\uri_for(
                    static::BASE_URL . $uri . $qs
                ));

                return $handler($request, $options);
            };
        });

        return $stack;
    }

    protected function getAuthenticationHeader($method, $uri)
    {
        $date = time();

        $digest = implode('+', [$method, $uri, $date]);
        $secret = $this->env['chamber_api_secret'];
        $hash = hash_hmac('sha256', $digest, $secret);

        return implode(':', [$date, $hash]);
    }
}
