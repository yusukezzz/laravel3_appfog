<?php

class Logentries
{
    const CONFIG_KEY = 'application.logentries';

    protected static $known_levels = array('Emergency',
        'Emerg',
        'Alert',
        'Critical',
        'Crit',
        'Error',
        'Err',
        'Warning',
        'Warn',
        'Notice',
        'Info',
        'Debug'
    );

    protected static function getConfigValues()
    {
        return array(
            Config::get(self::CONFIG_KEY.'.token'),
            Config::get(self::CONFIG_KEY.'.persistent'),
            Config::get(self::CONFIG_KEY.'.use_ssl'),
            Config::get(self::CONFIG_KEY.'.severity')
        );
    }

    /**
     * Laravel Log のログタイプを受け取って、
     * Logentries のログレベルとして解釈する
     * 解釈できない場合はとりあえず Emergency にしておく
     *
     * @param $type
     * @param $params
     */
    public static function __callStatic($type, $params)
    {
        $type = ucfirst($type);
        $message = (string) $params[0];
        if (!in_array($type, self::$known_levels, true)) {
            $type = 'Emergency';
            $message .= "orignal type={$type}, ".$message;
        }
        list($token ,$persistent, $use_ssl, $severity) = self::getConfigValues();
        $logger = LeLogger::getLogger($token, $persistent, $use_ssl, $severity);
        $logger->$type($message);
    }
}
