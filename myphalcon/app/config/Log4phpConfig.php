<?php

return array(

    'rootLogger' => array(
        'level' => 'TRACE',
        'appenders' => array('all', 'info', 'warn', 'error'),
    ),

    'appenders' => array(
        'all' => array(
            'class'  => 'LoggerAppenderDailyFile',
            'layout' => array(
                'class'  => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '[%level] [%date{Y-m-d}] %msg%n',
                ),
             ),
            'params' => array(
                'file'   => LOGS_PATH . '/myphalcon.%s',
                'append' => true,
                'datePattern' => 'Y-m-d',
            ),
            'filters' => array(
                array(
                    'class'  => 'LoggerFilterLevelRange',
                    'params' => array(
                        'levelMin' => 'TRACE',
                        'levelMax' => 'FATAL',
                    ),
                ),
            ),
        ),

        'info' => array(
            'class'  => 'LoggerAppenderDailyFile',
            'layout' => array(
                'class'  => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '[%level] [%date{Y-m-d}] %msg%n',
                ),
             ),
            'params' => array(
                'file'   => LOGS_PATH . '/myphalcon.info.%s',
                'append' => true,
                'datePattern' => 'Y-m-d',
            ),
            'filters' => array(
                array(
                    'class'  => 'LoggerFilterLevelRange',
                    'params' => array(
                        'levelMin' => 'TRACE',
                        'levelMax' => 'INFO',
                    ),
                ),
            ),
        ),

        'warn' => array(
            'class'  => 'LoggerAppenderDailyFile',
            'layout' => array(
                'class'  => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '[%level] [%date{Y-m-d}] %msg%n',
                ),
            ),
            'params' => array(
                'file'   => LOGS_PATH . '/myphalcon.warn.%s',
                'append' => true,
                'datePattern' => 'Y-m-d',
            ),
            'filters' => array(
                array(
                    'class'  => 'LoggerFilterLevelRange',
                    'params' => array(
                        'levelMin' => 'WARN',
                        'levelMax' => 'WARN',
                    ),
                ),
            ),
        ),

        'error' => array(
            'class'  => 'LoggerAppenderDailyFile',
            'layout' => array(
                'class'  => 'LoggerLayoutPattern',
                'params' => array(
                    'conversionPattern' => '[%level] [%date{Y-m-d}] %msg%n',
                ),
            ),
            'params' => array(
                'file'   => LOGS_PATH . '/myphalcon.error.%s',
                'append' => true,
                'datePattern' => 'Y-m-d',
            ),
            'filters' => array(
                array(
                    'class'  => 'LoggerFilterLevelRange',
                    'params' => array(
                        'levelMin' => 'ERROR',
                        'levelMax' => 'FATAL',
                    ),
                ),
            ),
        ),
    ),
);
