<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/dao/AccountDao.class.php';

Flight::register('accountDao', 'AccountDao');

require_once dirname(__FILE__)."/routes/accounts.php";

Flight::route('/', function(){
    echo 'hello world3!';
});

Flight::route('/hello5', function(){
    echo 'hello world5!';
});

Flight::start();
?>
