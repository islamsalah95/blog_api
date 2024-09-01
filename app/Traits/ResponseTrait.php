<?php
namespace App\Traits;


trait ResponseTrait
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($data = [], $message = 'Operation Successful', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($message = 'Something went wrong', $code = 500, $data = [])
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Validation error response
     *
     * @param array $errors
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function validationError($errors = [], $message = 'Validation Failed', $code = 422)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

    /**
     * Unauthorized response
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function unauthorized($message = 'Unauthorized', $code = 401)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    /**
     * Forbidden response
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function forbidden($message = 'Forbidden', $code = 403)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    /**
     * Not Found response
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound($message = 'Resource Not Found', $code = 404)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
