<?php
/**
 * Carregador simples de variáveis de ambiente a partir de um arquivo .env
 * na raiz do projeto. Não sobrescreve variáveis já definidas no ambiente
 * (ex: definidas pelo servidor/hosting).
 */
class EnvLoader
{
    private static $loaded = false;

    public static function load($path = null)
    {
        if (self::$loaded) {
            return;
        }

        $path = $path ?: realpath(__DIR__ . '/../.env');

        if ($path && file_exists($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || strpos($line, '#') === 0) {
                    continue;
                }
                if (strpos($line, '=') === false) {
                    continue;
                }
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, " \t\n\r\0\x0B\"'");

                if (getenv($key) === false) {
                    putenv("$key=$value");
                    $_ENV[$key] = $value;
                }
            }
        }

        self::$loaded = true;
    }
}
