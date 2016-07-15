<?php
namespace App\Exceptions;


class ResponseException extends \Exception
{
    private $response;

    /**
     * ResponseException constructor.
     * 
     * @param mixed|\Psr\Http\Message\ResponseInterface $response
     */
    public function __construct($response)
    {
        parent::__construct('The response was invalid.');
        $this->response = $response;
    }
}
