<?php

namespace Showpad;

use Guzzle\Http\Client as GuzzleClient;

final class GuzzleAdapter implements Adapter
{
    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * Constructor
     *
     * @param GuzzleClient $client A guzzle client instance
     */
    public function __construct(GuzzleClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send an http request
     *
     * @param string $method     The HTTP method
     * @param string $url        The url to send the request to
     * @param array  $parameters The parameters for the request (assoc array)
     * @param array  $headers    The headers for the request (assoc array)
     *
     * return mixed
     */
    public function request($method, $url, array $parameters = null, array $headers = null)
    {
        $request = $this->client->createRequest($method, $url, $headers, $parameters);
        try {
            $response = $request->send();
        } catch (\Exception $e) {
            $response = $e->getResponse();
            throw new ApiException($response->getStatusCode(), $response->getBody(true));
        }

        return $response->json();
    }
}

