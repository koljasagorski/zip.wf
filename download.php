<?php
include 'core.php';

$lib = new core_get;

$url = $_GET['url'];
if($url){
    if (strpos($url, "www") == false) $url = str_replace("https://", "https://www.", $url);
    if (!preg_match('@https?://(?:[\w\-]+\.)*zippyshare\.com/\w/(\w+)@i', $url, $fids)) die('File ID not found at link. Invalid link?');
    $fid = $fids[1];

    $srv = $lib->cut_str($url,'https://','zippyshare.com');

    $page = $lib->curl($url, "ziplocale=en", "");
    $cookie = "ziplocale=en; " .$lib->GetCookies($page);
    // echo $cookie;

    
    $script = $lib->cut_str($page,'<div class="download"></div>','</script>');
    // echo htmlspecialchars($script);
    if (stristr($page, '>File does not exist on this server<') || stristr($page, '>File has expired and does not exist anymore on this server')){
      die('File has expired or does not exist anymore on this server');
    }
    elseif (stristr($script, '/"+(b+18)+"/'))
    {
        $id = $lib->cut_str($script, "document.getElementById('dlbutton').omg = ", ';');
        $tachid = explode('%', $id); 
        $id2 = $lib->cut_str($script, "parseInt(document.getElementById('dlbutton').omg) * (", ');');
        $tachid2 = explode('%', $id2); 
        $b = ($tachid[0] % $tachid[1]) * ($tachid2[0] % $tachid2[1]);
        $data = $lib->cut_str($script, 'document.getElementById(\'dlbutton\').href    = "', '";');
        $tach = str_replace('"+(b+18)+"', $b + 18, $data);  
        $link = "https://{$srv}zippyshare.com{$tach}"; 
    }
    elseif (stristr($script, '/"+e()+"/'))
    {
        $a = $lib->cut_str($script, ".a = ", ';');
        $b = $lib->cut_str($script, "var b = ", ';');
        $ID = (($a+3)*3)%$b + 3;
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $tach = str_replace('"+e()+"', $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach}";
    }
    elseif (stristr($script, '/"+(a * b + c + d)+"/'))
    {
        $a = $lib->cut_str($script, "var a = ", ';');
        $tacha = explode('%', $a); 
        
        $b = $lib->cut_str($script, "var b = ", ';');
        $tachb = explode('%', $b);
        
        $c = $lib->cut_str($script, "var c = ", ';');
        if(preg_match_all('/var d = (.*);/i', $page, $tachd)) $d = explode('%', $tachd[1][1]);
        
        $ID = ($tacha[0] % $tacha[1]) * ($tachb[0] % $tachb[1]) + $c + ($d[0] % $d[1]);
        
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $tach = str_replace('"+(a * b + c + d)+"', $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach}";
    }
    elseif (stristr($script, '"+(n + n * 2 + b)+'))
    {
        $n = $lib->cut_str($script, "var n = ", ';');
        $b = $lib->cut_str($script, "var b = ", ';');
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $tach = explode("\"", $data);
        $number = current(explode("/", $tach[2]));
        $ID = $n + $n * 2 + $b.$number;
        $tach1 = str_replace('"'.$tach[1].'"'.$number, $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach1}";
    }
    elseif (stristr($script, 'a() + b() + c() + d + 5/5)'))
    {
        $d = intval($lib->cut_str($script, '<span id="omg" class="', '"'));
        $a = intval($lib->cut_str($script, "var a = function() {return ", '};'));
        $b = intval($a) + intval($lib->cut_str($script, "var b = function() {return a() + ", '};'));
        $c = intval($b) + intval($lib->cut_str($script, "var c = function() {return b() + ", '};'));
        if(stristr($script, '{ d = d*2;}')){
            $d = ($d * 2);
        }
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $L1 = $lib->cut_str($script, "+(", '%');
        $L2 = $lib->cut_str($script, $L1."%", ' +');

        $ID = ($L1 % $L2) + $a + $b + $c +$d + (5/5);
        $tach1 = str_replace('"+('.$L1.'%'.$L2.' + a() + b() + c() + d + 5/5)+"', $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach1}";
    }
    elseif (stristr($script, '(Math.pow(a, 3)+b)'))
    {
        $a = intval($lib->cut_str($script, "var a = ", ';'));
        $omgstr = $lib->cut_str($script, "document.getElementById('dlbutton').omg = \"", '".substr(0, 3);');
        $omg = substr($omgstr, 0 , 3); 
        $b = intval(strlen($omg));
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $ID = intval(pow($a,3) + $b);
        $tach1 = str_replace('"+(Math.pow(a, 3)+b)+"', $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach1}";
    }
    elseif (stristr($script, "if (document.getElementById('dlbutton').omg != 'f')"))
    {
        $a = intval($lib->cut_str($script, "var a = ", ';'));
        $b = intval($lib->cut_str($script, "var b = ", ';'));
        $omgstr = $lib->cut_str($script, "document.getElementById('dlbutton').omg = \"", '";');
        if ($omg !== 'f') {
            $a = ceil($a/3);
        }else{
            $a = floor($a/3);
        }
        $L = $lib->cut_str($script, "+(a + ", '%b)+');
        $h = $L % $b;
        $data = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $ID = $a + $h;
        $tach1 = str_replace('"+(a + '.$L.'%b)+"', $ID, $data);
        $link = "https://{$srv}zippyshare.com{$tach1}";
    }
    else
    {
        $id = $lib->cut_str($script, "dlbutton').href = \"", '";');
        $id2 = preg_replace('/\s+/', '', $lib->cut_str($script, '" + (', ') + "'));
        $replace = $lib->cut_str($id, '/"', '"/');
        $tachid2 = explode('%', $id2); 
        $L1 = $tachid2[0];
        $L2 = $lib->cut_str($id2, "%", '+');
        $L3 = $lib->cut_str($id2, "+", '%');
        $L4 = $tachid2[2];
        $ID = $L1 % $L2 + $L3 % $L4;
        $ID2 = str_replace('"', '', str_replace($replace, $ID, $id));
        $link = "https://{$srv}zippyshare.com{$ID2}";
    }

    if (!$link) die("Zippyshare under maintenance");

    $head = get_headers($link);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    foreach ($head as $value) {
        if(stristr($value, 'Set-Cookie') || stristr($value, 'Content-Disposition')){
            header($value);
        }
    }
    header('Content-Transfer-Encoding: chunked');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    $stream = fopen('php://output', 'w');

    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_READFUNCTION, function($ch, $fd, $length) use ($stream) {
        return fwrite($stream, fread($fd, $length));
    });

    curl_exec($ch);
    curl_close($ch);    
}
?>