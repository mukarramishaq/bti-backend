<?php

namespace App\Utils;

/**
 * Utility class to format
 * the responses
 */
class ResponseFormat
{
    /**
     * format the success response
     * @return array
     */
    public function success($data = [])
    {
        $formatted = [
            'status' => 'success',
            'message' => 'Operation Successful',
        ];
        if (!empty($data)) {
            if (\is_array($data)) {
                foreach($data as $key => $value){
                    if (\is_object($value)) {
                        $data[$key] = $value->toArray();
                    }
                }
            } else if (\is_object($data)) {
                $data = $data->toArray();
            }
            $formatted['data'] = $data;
        }
        return $formatted;
    }

    /**
     * format the error response
     * @return array
     */
    public function error(\Error $e)
    {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
        ];
    }
}
