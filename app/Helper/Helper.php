<?php

namespace App\Helper;
use Response;
class Helper
{
   
    /**
     * This function is used to show api response in json.
     *
     * @param $msg
     * @param $data
     * @param $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response($msg = null, $data = null,$status = null)
    {
        return Response::json([
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    /* ============ FamilyPortal =================== */
    public static function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    public static function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
    /* ============ end =================== */
}