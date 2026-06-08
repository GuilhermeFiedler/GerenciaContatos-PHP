<?php
declare(strict_types=1);

namespace Gfiedler\GerenciaContatos\Services;
class ValidatorService
{
    public static function email(string $email): bool
    {
        return filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ) !== false;
    }

    public static function telefone(string $telefone): bool
    {

        $telefone = preg_replace(
            '/\D/',
            '',
            $telefone
        );

        return preg_match(
            '/^\d{10,11}$/',
            $telefone
        );
    }
}