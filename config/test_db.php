<?php
$db = require(__DIR__ . '/db.php');
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=192.168.1.135;port=3306;dbname=zuiyouxiApp';
$db['username'] = 'pirate';
$db['password'] = 'admin';

return $db;
