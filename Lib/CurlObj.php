<?php

/**
 *  Curl 封装类
 *  @author henry@juzili.com
 *  @version v1.0
 */
 
class CurlObj
{  
    protected $ch = null;
    
    protected $ttl = 60;
     
    function __construct($url = ''){
        $this->ch = curl_init();
    }
     
    public function get($url, $params){
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $this->ttl);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_URL, $url);
    }
}
