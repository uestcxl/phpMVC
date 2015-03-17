<?php

    /* 系统总配置文件
     * @author  xl
     * @version 0.1
     */

    /*数据库配置*/
    $CONFIG['SYSTEM']['DB'] = array(
        'DB_HOST'       =>  'localhost',
        'DB_USER'       =>  'xl',
        'DB_PWD'        =>  'xulei123',
        'DB_NAME'       =>  'framework',
        'DB_TABLE_PRE'  =>  'fra_',
        'DB_CHARSET'    =>  'utf8'
    );

    /*系统类库配置*/
    $CONFIG['SYSTEM']['LIB'] = array(
        'LIB_PRE'       =>  'Lib',
    );

    /*路由配置*/
    $CONFIG['SYSTEM']['ROUTE'] = array(
        'DEFAULT_CTR'   =>  'home',
        'DEFAULT_ACTION'    =>  'index'
    );

    /*开发者模式或应用模式*/
    $CONFIG['SYSTEM']['DEV'] = array(
        'DEBUG'     =>  TRUE
    );

