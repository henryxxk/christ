<?php

/**
 *  Curl 封装类
 *  @author henry@juzili.com
 *  @version v1.0
 */
 
 class CurlObj{
     protected $ttl = 0;
     
     protected $host = "";
     
     protected $port = "";
     
     protected $options = array();
     
     protected $ch = null;
     
     function __construct(){
         $this->ch = curl_init();
     }
     
     public function get($url, $params){
         
     }
 }
