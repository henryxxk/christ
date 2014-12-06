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
    
    protected $grant_type = "client_credential";
    
    protected $db = null;
    
    protected $curl = null;
    
    protected $params = array();
    
    protected $pre = "https://api.weixin.qq.com/cgi-bin/";
    
    protected $token = "";
    
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
        $this->initToken();
    }
    
    public function initToken(){
        //$url = $pre + ""
        $params = $this->params;
        
        $params['grant_type'] = $this->grant_type;
        //$url = $this->getUrl('token', $params);
        $result = $this->curl->get(url, $param);
        
        $retData = json_decode($result, true);
        if (!$result || $result['errcode']){
            //:Todo 错误日志
        }
        $token = $retData['access_token'];
        $expire = $retData['expires_in'];
        
        $this->setTokenInfo($token, $expire, time());
    }
    
    public function getData(){
        
    }
    
    public function setTokenInfo($token, $expire, $timeStamp){
        $sql = "insert into to wx_token where".
        " 'appid' =".$this->appid." 'secret' = ".$this->secret;
        
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
        return $this->pre.$type."?".$str;
    }
}


?>