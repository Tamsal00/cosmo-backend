<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200, $meta = [])
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, int $code = 422, $data = null, $meta = [])
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $code);
    }
}
