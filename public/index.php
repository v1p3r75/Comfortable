<?php

/* DON'T REMOVE OR MOVE THIS FILE */

/*
 * Name : Comfortable PHP
 * Description : A simple PHP Framework
 * Architecture : MVC
 * FileName : index.php
 * Role : A bootstrap file
 * Author : Fortunatus EK (v1p3r 75)
 * website : https://www.github.com/v1p3r75/Comfortable
 * Licence : 
 */

require ('../vendor/autoload.php');
require_once ('../Cores/Functions/all_func.php');
require_once ('../App/Configuration.php');
require_once('../App/Routes/Routes.php');


saveEnv($appVar); // Save the environment variables of configuration file

$route -> run(trim($_SERVER['REQUEST_URI']));
