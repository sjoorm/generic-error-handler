<?php

namespace sjoorm\GenericErrorHandler;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\ErrorHandler\ErrorHandler;

class Setup
{
    public static function initLogger(string $channel = null): LoggerInterface
    {
        static $logger;

        if (!$logger) {
            $handler = (new ErrorLogHandler())
                ->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_JSON, false));
            $logger = (new Logger($channel ?? static::defaultChannelName()))
                ->pushProcessor(new MemoryUsageProcessor())
                ->pushProcessor(new MemoryPeakUsageProcessor())
                ->pushHandler($handler);

            if (!EnvResolver::isCli()) {
                $logger->pushProcessor(new WebProcessor());
            }
        }

        return $logger;
    }

    public static function initErrorHandler(int $throwLevels = null, LoggerInterface $logger = null): ErrorHandler
    {
        static $errorHandler;

        if (!$errorHandler) {
            $errorHandler = ErrorHandler::register();
            $errorHandler->throwAt($throwLevels ?? static::defaultThrowLevels(), true);
            $errorHandler->setDefaultLogger($logger ?? static::initLogger());
        }

        return $errorHandler;
    }

    public static function defaultThrowLevels(): int
    {
        return E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE & ~E_STRICT & ~E_WARNING & ~E_USER_WARNING;
    }

    public static function defaultChannelName(): string
    {
        if (EnvResolver::isCli()) {
            return 'cli';
        }

        return $_SERVER['SERVER_NAME'] ?? 'localhost';
    }
}
