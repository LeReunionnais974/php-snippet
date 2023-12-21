<?php

class Logger
{
    private static $logFile = 'app.log';
    private static $logPath = 'logs';

    public static function setLogFile($fileName)
    {
        self::$logFile = $fileName;
    }

    public static function setLogPath($path)
    {
        self::$logPath = $path;
    }

    public static function log($message, $level = 'info')
    {
        if (self::isValidLogLevel($level)) {
            $formattedMessage = self::formatMessage($message, $level);
            self::writeToFile($formattedMessage);
        } else {
            throw new InvalidArgumentException('Niveau de log invalide.');
        }
    }

    private static function formatMessage($message, $level)
    {
        $timestamp = date('[Y-m-d H:i:s]');
        return "$timestamp [$level] - $message" . PHP_EOL;
    }

    private static function writeToFile($message)
    {
        if (!is_dir(self::$logPath)) {
            mkdir(self::$logPath, 0777, true);
        }

        if (file_put_contents(self::$logPath . '/' . self::$logFile, $message, FILE_APPEND | LOCK_EX) === false) {
            throw new RuntimeException('Erreur lors de l\'écriture dans le fichier de log.');
        }
    }

    private static function isValidLogLevel($level)
    {
        $validLogLevels = ['info', 'error', 'warning', 'debug'];
        return in_array($level, $validLogLevels);
    }
}
