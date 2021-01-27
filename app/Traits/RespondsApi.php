<?php
namespace App\Traits;

trait RespondsApi
{
    public function success($data, $code = 200)
    {

        return response()->json(['data' => $data], $code);
    }

    public function error($message, $code)
    {
        return response()->json(['error' => $message], $code);
    }

    public function deleted()
    {
        return response()->json(['message' => 'Resource deleted'], 200);
    }
}
