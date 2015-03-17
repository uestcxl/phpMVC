<?php

    /**
     * 框架基类app.php
     * Created by PhpStorm.
     * User: xl
     * Date: 15-3-17
     * Time: 上午10:24
     */

    /*引入基类*/
    require dirname(__FILE__).'/system/app.php';
    /*引入系统主配置文件*/
    require dirname(__FILE__).'/config/config.php';

    Application::run($CONFIG);
