<?php

namespace Gfiedler\GerenciaContatos\Core;
class Response
{
    public static function success(
        mixed $data,
        int   $status = 200
    ): never
    {

        http_response_code($status);

        echo json_encode($status);

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);

        exit;

    }

    public static function error(string $message, int $status = 400): never
    {
        http_response_code($status);

        echo json_encode(['success' => false, 'message' => $message]);
        exit;
    }
}