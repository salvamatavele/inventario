<?php 
/**
 * Url base
 * $__URL__
 */
define('__URL__','http://localhost/inventario');

/*Config data base here
*DB configuracao 
*/
// define("DATA_LAYER_CONFIG", [
//     "driver" => "mysql",
//     "host" => "127.0.0.1",
//     "port" => "3306",
//     "dbname" => "phpscrip",
//     "username" => "admin",
//     "passwd" => "admin",
//     "options" => [
//         PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
//         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
//         PDO::ATTR_CASE => PDO::CASE_NATURAL
//     ]
// ]);
define("DATA_LAYER_CONFIG", [ 
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "umum_iventario",
        "username" => "root",
        "passwd" => "root",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ],
    ]);


    /**
     * Email configuration
     */
    define('MAIL', [
        "host"=>"smtp.zoho.com",
        "port"=>"587",
        "user"=>"smatavele1@zohomail.com",
        "passwd"=>"1INmIPqPtKFq",
        "from_name"=>"UMUM INVENTÁRIO",
        "from_email"=>"smatavele1@zohomail.com"
    ]);
    

/**
 * Para acessar css e javascript e img
 * asset
 */
function asset(string $path): string
{
    return __URL__."/Public/{$path}";
}


/**
 * Urls
 *
 * @param string $uri
 * @return string
 */
function url(string $uri = null): string
{
    if ($uri){
        return __URL__."/{$uri}";
    }
    return __URL__;
}

function template(string $dir = null): string
{
    if ($dir){
        return __DIR__."/../Source/template/{$dir}";
    }
    return __DIR__."/../Source/template/";
}

define('_DOMIN_',$_SERVER["HTTP_HOST"]);