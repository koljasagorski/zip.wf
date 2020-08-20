<?php
class core_get{
    
    function curl($url, $cookies, $post, $header = 1, $json = 0, $ref = 0, $xml = 0)
	{
        $UserAgent = 'Mozilla/5.0 (Windows NT 5.1; rv:12.0) Gecko/20100101 Firefox/27.0.1';
		$ch = @curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		if ($json == 1) {
			$head[] = "Content-type: application/json";
			$head[] = "X-Requested-With: XMLHttpRequest";
		}
		if ($xml == 1) {
			$head[] = "X-Requested-With: XMLHttpRequest";
		}
		$head[] = "Connection: keep-alive";
		$head[] = "Keep-Alive: 300";
		$head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$head[] = "Accept-Language: en-us,en;q=0.5";
		if ($cookies) curl_setopt($ch, CURLOPT_COOKIE, $cookies);
		curl_setopt($ch, CURLOPT_USERAGENT, $UserAgent);
		curl_setopt($ch, CURLOPT_REFERER, $ref == 0 ? $url : $ref);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		if($header == -1){
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_NOBODY, 1);
		}
		else curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if ($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
        
        
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, FALSE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		$page = curl_exec($ch);
		curl_close($ch);
		return $page;
	}
	function cut_str($str, $left, $right)
	{
		$str = substr(stristr($str, $left) , strlen($left));
		$leftLen = strlen(stristr($str, $right));
		$leftLen = $leftLen ? -($leftLen) : strlen($str);
		$str = substr($str, 0, $leftLen);
		return $str;
	}
	function GetCookies($content)
	{
		preg_match_all('/Set-Cookie: (.*);/U',$content,$temp);
		$cookie = $temp[1];
		$cookies = "";
		$a = array();
		foreach($cookie as $c){
			$pos = strpos($c, "=");
			$key = substr($c, 0, $pos);
			$val = substr($c, $pos+1);
			$a[$key] = $val;
		}
		foreach($a as $b => $c){
			$cookies .= "{$b}={$c}; ";
		}
		return $cookies;
	}
	function GetAllCookies($page)
	{
		$lines = explode("\n", $page);
		$retCookie = "";
		foreach($lines as $val) {
			preg_match('/Set-Cookie: (.*)/', $val, $temp);
			if (isset($temp[1])) {
				if ($cook = substr($temp[1], 0, stripos($temp[1], ';'))) $retCookie.= $cook . ";";
			}
		}
		return $retCookie;
	}
}
?>