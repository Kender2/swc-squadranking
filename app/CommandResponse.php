<?php
namespace App;


class CommandResponse
{

    public $requestId;
    public $messages;
    public $status;
    public $result;
    protected $data;

    /**
     * CommandResponse constructor.
     * @param \stdClass $data
     */
    public function __construct($data)
    {
        $this->requestId = $data->requestId;
        $this->messages = $data->messages;
        $this->status = $data->status;
        $this->result = $data->result;
        $this->data = $data;
    }

    public function __toString()
    {
        return \GuzzleHttp\json_encode($this);
    }

    /**
     * @return \stdClass
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
