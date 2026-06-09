<?php

namespace Gfiedler\GerenciaContatos\Helpers;
class PaginationHelper
{
    public static function format(array $data, int $page, int $limit, int $total): array
    {
        return [
            "data" => $data,
            "pagination" => [
                "page" => $page,

                "limit" => $limit,
                "total" => $total,
                "pages" => (int) ceil($total / $limit)]
        ];
    }
}