<?php

/**
 * 
 * 
 */
 
$tokenObj = new Token($_Globals['Appid'], $_Globals['Secret']);
$openid = $tokenObj->getTokenOpenId(); 
$transid = $_GET['scope'];
function initRollNum(){
    session_start();
    if (!$_SESSION[$openid]){
        $_SESSION[$openid] = 2;
        initUserInfo($openid);
    }
    session_destroy();
}

function initUserInfo($openid){
    $conf = array(
        'host' => $_Globals['host'],
        'user' => $_Globals['user'],
        'password' => $_Globals['pwd'],
        'port' => $_Globals['port'],
        'database' => $_Globals['dbname']
    );
    $db = new Mysql($conf);
    
    $sql = "replace into `christ`(`openid`,`num`) value('{$openid}',2)";
    
    $ret = $this->db->sql($sql);
}
?>
