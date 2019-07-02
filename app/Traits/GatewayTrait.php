<?php
/**
 * Created by PhpStorm.
 * User: biastegalaraga
 * Date: 4/1/18
 * Time: 10:40 AM
 */

namespace App\Traits;

use App\Helpers\TimeHelper;

trait GatewayTrait
{

    public $success = false;
    public $message = null;
    public $data = null;
    public $code = \Illuminate\Http\Response::HTTP_OK;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function json() : \Illuminate\Http\JsonResponse
    {
        $result = array();
        $result['success'] = $this->success;
        $result['message'] = $this->message;
        if (is_array($this->data) || is_object($this->data))
            $result['data'] = $this->data;
        $result['elapsed'] = TimeHelper::server_elapsed_time();
        return response()->json($result, $this->code, [], JSON_PRETTY_PRINT);
    }

}