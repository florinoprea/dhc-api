<?php
namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\Response;


class ApiResponse extends Response implements Responsable
{
    private $data;
    private $success;
    private $message;
    private $errors;
    private $valid;
    private $messages;
    private $code;
    private $meta;
    private $request;

    public $headers;

    public function status()
    {
        return $this->code;
        return 200;
    }

    public function __construct($request, $data = [], $code = '200', $message = '')
    {
        $this->messages = isset($data['messages']) ? $data['messages'] : []  ;
        $this->data = isset($data['data']) ? $data['data'] : null;
        $this->success =  (isset($data['success'])) ? $data['success'] : (( ($message !== '') || isset($data['message']) || isset($data['error']) || isset($data['errors'])) ? false : true);
        $this->errors = isset($data['errors']) ? $data['errors'] : [];
        $this->valid = isset($data['valid']) ? $data['valid'] : null;
        $this->message = isset($data['message']) ? $data['message'] : null;

        if ($message !== ''){
            $this->message = $message;
        }
        $this->code = $code;
        $this->meta = isset($data['meta']) ? $data['meta'] : null;
        $this->request = $request;


        parent::__construct('', intval($code));
    }
    public function header($name, $content){

        $this->request->headers->set($name, $content);
    }

    public function setMessage($message){

        $this->data['message'] = $message;
    }

    public function toResponse($request)
    {
        return response()
            ->json($this->transform(), 200);
    }

    protected function transform()
    {

        $return = [
            'status' => [
                'success' => $this->success,
                'message' => $this->message,
                'messages' => $this->messages,
                'errors' => $this->errors,
                'code' => $this->code,
            ]
        ];
        if ($this->valid)
            $return['status']['valid'] = $this->valid;

        if (!is_null($this->data) )
            $return['data'] = $this->data;

        if (!is_null($this->meta) )
            $return['meta'] = $this->meta;

        return $return;
    }
}
?>
