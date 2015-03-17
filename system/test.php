<?php

    define('SYSTEM_PATH', dirname(__FILE__));
    echo SYSTEM_PATH;
    echo "\n";
    define('ROOT_PATH',  substr(SYSTEM_PATH, 0,-7));
    echo ROOT_PATH;
    echo "\n";

