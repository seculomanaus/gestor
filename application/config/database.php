<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$active_group = 'default';
$active_record = TRUE;

$banco = 'h';

switch($banco){
    case 'h': // BACO DE DADOS PRODUCAO
        $dbhost = '10.228.20.17';
        $dbname = 'bdiseculo.seculomanaus.com.br';
        $status = '<div class="alert alert-warning alert-dismissable">  Homologação.</div>';
        //define('FLG_BANCO', 'HOMOLOGAÇÃO');
    break;
    case 'p': // BACO DE DADOS PRODUCAO
        $dbhost = '10.228.20.18';
        $dbname = 'bdiseculo.seculomanaus.com.br';
        $status = '<div class="alert alert-warning alert-dismissable">  Produção.</div>';
        // define('FLG_BANCO', 'PRODUÇÃO');
    break;
}

 $db['default']['hostname'] = '(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = '. $dbhost .')(PORT = 1521))
)(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = '. $dbname .')))';
$db['default']['username'] = 'SISWEB';
$db['default']['password'] = '17Sec001!xx';
$db['default']['database'] = $dbname;
$db['default']['dbdriver'] = 'oci8';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;