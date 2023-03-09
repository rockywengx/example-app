<?php
namespace App\Basic\Http\Controllers\Traits;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    /**
     * http狀態碼
     * @var int
     */
    protected $statusCode = FoundationResponse::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode,$httpCode=null)
    {
        $httpCode = $httpCode ?? $statusCode;
        $this->statusCode = $statusCode;
        return $this;
    }

    public function success($data=null,$message="成功"){
        if(is_null($data)){
            $status = [
                'success'   => true,
                'msg'       => $message
            ];
        }else{
            $this->parseNull($data);
            $status = [
                'success'   => true,
                'msg'       => $message,
                'data'      => $data
            ];
        }
        return response()->json($status);
    }


    //如果返回的資料中有 null 則那其值修改為空 （安卓和IOS 對null型的資料不友好，會報錯）
    private function parseNull(&$data){
        if(is_array($data)){
            foreach($data as &$v){
                $this->parseNull($v);
            }
        }else{
            if(is_null($data)){
                $data = "";
            }
        }
    }

    /**
     * @param $status
     * @param array $data
     * @param null $code
     * @return mixed
     */
    public function status($status, array $data,$message, $code = null){

        if ($code){
            $this->setStatusCode($code);
        }
        $status = [
            'success'   => $status,
            'code'      => $this->statusCode,
            'msg'       => $message
        ];

        $data = array_merge($status,$data);
        return response()->json($data);

    }

    public function error($message, $code = null){
        if ($code){
            $this->setStatusCode($code);
        }
        return response()->json([
            'success' => false,
            'code' => $this->statusCode,
            'msg'=>$message
        ]);
    }
    /**
     * @param $message
     * @param string $status
     * @return mixed
     */
    // public function message($message, $status = "success"){

    //     return $this->status($status,[
    //         'message' => $message
    //     ]);
    // }

    /**
     * @param string $message
     * @return mixed
     */
    public function notFound($message = 'Not Found!')
    {
        return $this->error($message,Foundationresponse::HTTP_NOT_FOUND);
    }
}
