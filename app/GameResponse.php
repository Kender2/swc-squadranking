<?php
namespace App;


class GameResponse
{
    protected $protocolVersion;
    /** @var  array */
    protected $data;
    protected $serverTimestamp;
    protected $serverTime;

    /**
     * GameResponse constructor.
     * @param \Psr\Http\Message\StreamInterface $responseBody
     */
    public function __construct($responseBody)
    {
        $response = \GuzzleHttp\json_decode($responseBody);
        $this->protocolVersion = $response->protocolVersion;
        $this->data = $response->data;
        $this->serverTimestamp = $response->serverTimestamp;
        $this->serverTime = $response->serverTime;
    }

    /**
     * @return integer
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @param integer $protocolVersion
     * @return GameResponse
     */
    public function setProtocolVersion($protocolVersion)
    {
        $this->protocolVersion = $protocolVersion;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return GameResponse
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return integer
     */
    public function getServerTimestamp()
    {
        return $this->serverTimestamp;
    }

    /**
     * @param integer $serverTimestamp
     * @return GameResponse
     */
    public function setServerTimestamp($serverTimestamp)
    {
        $this->serverTimestamp = $serverTimestamp;
        return $this;
    }

    /**
     * @return string
     */
    public function getServerTime()
    {
        return $this->serverTime;
    }

    /**
     * @param string $serverTime
     * @return GameResponse
     */
    public function setServerTime($serverTime)
    {
        $this->serverTime = $serverTime;
        return $this;
    }

    /**
     * Get a string of request ids with their status.
     * @return string
     */
    public function getStatus()
    {
        $status = [];
        foreach ($this->data as $item) {
            $status[] = $item->requestId . ': ' . $item->status;
        }
        return implode(',', $status);
    }

}
