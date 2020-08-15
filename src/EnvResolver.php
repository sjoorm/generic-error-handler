<?php

namespace sjoorm\GenericErrorHandler;

class EnvResolver
{
    public static function isCli(): bool
    {
        return \in_array(\PHP_SAPI, ['cli', 'phpdbg'], true);
    }
}
