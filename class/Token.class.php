<?php
/**
 *  Token Class
 *  
 *  @author henry@juzili.com
 *  @version v1.0
 */
 
class Token{
    protected $expired_time = 0;
    
    protected $appid = "";
    
    protected $secret = "";
    
    protected $timeStamp = 0;
    
    protected $grant_type = "authorization_code";
    
    protected $db = null;
    
    protected $curl = null;
    
    protected $params = array();
    
    protected $pre = "https://api.weixin.qq.com/cgi-bin/";
    
    protected $token = "";
    
    protected $oauth_url = "https://open.weixin.qq.com/connect/oauth2/";
    
    function __constructor($appid, $secret){
        $this->appid = $appid;
        $this->secret = $secret;
        
        $conf = array(
            'host' => $_Globals['host'],
            'user' => $_Globals['user'],
            'password' => $_Globals['pwd'],
            'port' => $_Globals['port'],
            'database' => $_Globals['dbname']
        );
        $this->db = new Mysql($conf);
        $this->curl = new CurlObj();
        //$this->initToken();
    }
    
    
    public function getData(){
        

    }
    
    public function getTokenFromDb(){
        $sql = "select from token where `appid` = '".$this->appid."'";
        
        $ret = $this->db->sql($sql);
        
        if ($ret && count($ret)  == 1){
            if ($ret['timeStamp'] + $ret['expired'] - 30 > time()){
                return $ret['token'];
            }
        }
        return false;
    }
    
    public function getTokenOpenId(){
        
        $token = $this->getTokenFromDb();
        
        $params = $this->params;
        
        $params['grant_type'] = $this->grant_type;
        $params['code'] =  $_GET['code'];
        $url = $this->getUrl('token', $params);
        $result = $this->curl->get(url);
        
        $retData = json_decode($result, true);
        if (!$result || $result['errcode']){
            //:Todo 错误日志
        }
        $token = $retData['access_token'];
        $expire = $retData['expires_in'];
        $openid = $retData['openid'];
        $this->setTokenInfo($token, $expire, time());
        return $openid;
    }
    
    public function setTokenInfo($token, $expire, $timeStamp){
        $sql = "replace into to token(`appid`,`token`,`expired`.`timeStamp`) value('"
        .$this->appid."','".$token."','".$expire."','".time()."')";
        
        $ret = $this->db->sql($sql);
        
        if ($ret){
            
        }
    }
    
    public function getUserInfo(){
        
    }
    
    public function getUrl($type, $params = array()){
        $str = '';
        foreach ($params as $key => $value) {
            $str.$key."=".$value."&";
        }
        return $this->oauth_url.$type."?".$str;
    }
}


?>