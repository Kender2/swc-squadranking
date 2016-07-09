<?php
namespace App;


class CommandResponse
{

    public $requestId;
    public $messages;
    public $status;
    public $result;

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
    }

    public function __toString()
    {
        return \GuzzleHttp\json_encode($this);
    }
}
