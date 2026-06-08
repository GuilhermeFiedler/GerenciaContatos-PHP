<?php

namespace Gfiedler\GerenciaContatos\Helpers;
class FormatHelper
{
    public static function phone($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }
}