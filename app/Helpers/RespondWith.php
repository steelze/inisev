<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response;

class RespondWith
{
     public static function success($payload = [], string $message = 'success', int $code = Response::HTTP_OK)
     {
          return self::respond(true, $payload, $message, $code);
     }

     public static function error($payload = [], string $message = 'error', int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
     {
          return self::respond(false, $payload, $message, $code);
     }

     protected static function respond(bool $success, $payload = [], string $message, int $code)
     {
          return response()->json(['success' => $success, 'message' => $message, 'payload' => $payload], $code);
     }
}
