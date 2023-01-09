<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    protected bool $isSuccess;
    protected string $message;
    protected mixed $data;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->isSuccess;
    }

    /**
     * @param bool $isSuccess
     * @return ApiResponse
     */
    public function setIsSuccess(bool $isSuccess): static
    {
        $this->isSuccess = $isSuccess;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return ApiResponse
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     * @return ApiResponse
     */
    public function setData(mixed $data): static
    {
        $this->data = $data;
        return $this;
    }

    public function toArray()
    {
        return call_user_func('get_object_vars', $this);
    }

    public static function success(mixed $data = null, string $message = 'SUCCESS', $statusCode = 200): JsonResponse
    {
        return response()->json(
            self::make()->setIsSuccess(true)->setMessage($message)->setData($data)->toArray(),
            $statusCode
        );
    }

    public static function fail($statusCode = 500, string $message = null, mixed $data = null): JsonResponse
    {
        return response()->json(
            self::make()->setIsSuccess(false)->setMessage($message)->setData($data),
            $statusCode
        );
    }

    public static function validationError(string $message = null, mixed $data = null): JsonResponse
    {
        return self::fail(422, $message, $data);
    }

    public static function make(): static
    {
        return new static();
    }


}
