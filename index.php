<?php

    /*
     * 框架入口文件
     * @author  xl
     * @version 0.1
     */

    /*引入基类*/
    require dirname(__FILE__).'/system/app.php';
    /*引入系统主配置文件*/
    require dirname(__FILE__).'/config/config.php';

    Application::run($CONFIG);
