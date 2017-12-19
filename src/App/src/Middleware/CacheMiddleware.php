<?php
namespace App\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use App\Enum\HttpResponses;

class CacheMiddleware implements ServerMiddlewareInterface
{
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $url  = str_replace('/', '_', $request->getUri()->getPath());
        $file = $this->config['path'] . $url . '.json';
        if ($this->config['enabled'] && file_exists($file) &&
            (time() - filemtime($file)) < $this->config['lifetime']) {
            $string = file_get_contents($file);
            $result = json_decode($string, true);
            
            return new JsonResponse($result, HttpResponses::HTTP_OK, array('Access-Control-Allow-Origin' => '*'));
        }

        $response = $delegate->process($request);
        if ($response instanceof JsonResponse && $this->config['enabled']) {
            file_put_contents($file, $response->getBody());
        }
        return $response;
    }
}