<?php
$url = parse_url(getenv("DATABASE_URL"));
$host = $url["host"];
$username = $url["user"];
$password = isset($url["pass"]) ? $url["pass"] : '';
$database = substr($url["path"], 1);

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=' . $host . ';dbname=' . $database,
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
