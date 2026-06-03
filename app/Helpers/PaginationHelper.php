<?php

class PaginationHelper {
    public static function format($data, $page, $limit, $total) {
        return [
            "data" => $data,
            "pagination" => [
                "page" => $page,

                "limit" => $limit,
                "total" => $total,
            "pages" => ceil($total / $limit)]
        ];
    }
}