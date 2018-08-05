<?php

namespace App\Exceptions\Reporter;

use App;
use Auth;
use Throwable;
use GuzzleHttp\Client;

class Fluentd
{
    /**
     * @var Client
     */
    protected $client;
    
    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
    
    /**
     * @param Throwable $throwable
     */
    public function report(Throwable $throwable)
    {
        if ($endpoint = env('report_endpoint')) {
            $this->client->post($endpoint.'?time='.time(), [
                'json' => $this->reportPayload($throwable),
                'http_errors' => false,
            ]);
        }
    }
    
    /**
     * @param Throwable $throwable
     * @return array
     */
    protected function reportPayload(Throwable $throwable)
    {
        $payload = [
            'application' => config('app.name'),
            'environment' => App::environment(),
            'user_id' => Auth::id(),
            'exception' => [
                'file' => $throwable->getFile(),
                'line' => $throwable->getLine(),
                'code' => $throwable->getCode(),
                'message' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ],
        ];
        
        if (!App::runningInConsole()) {
            $request = app('request');
            $payload['request'] = [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'content' => $request->getContent(),
                'ip' => $request->ip(),
                'headers' => array_map(function ($header) {
                    return isset($header[0]) ? $header[0] : '';
                }, $request->headers->all()),
            ];
        }
        
        return $payload;
    }
}
