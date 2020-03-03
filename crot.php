<?php
function request($url, $token = null, $data = null, $pin = null){
    
$header[] = "Host: api.gojekapi.com";
$header[] = "User-Agent: okhttp/3.12.1";
$header[] = "Accept: application/json";
$header[] = "Accept-Language: id-ID";
$header[] = "Content-Type: application/json; charset=UTF-8";
$header[] = "X-AppVersion: 3.37.2";
$header[] = "X-UniqueId: 9436f3bc7531d25a".mt_rand(1000,9999);
$header[] = "Connection: keep-alive";    
$header[] = "X-User-Locale: id_ID";
$header[] = "X-Location:-3.1265224,114.5913881";
$header[] = "X-Location-Accuracy: 48.544";
if ($pin):
$header[] = "pin: $pin";    
    endif;
if ($token):
$header[] = "Authorization: Bearer $token";
endif;
$c = curl_init("https://api.gojekapi.com".$url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if ($data):
    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    curl_setopt($c, CURLOPT_POST, true);
    endif;
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    if ($socks):
          curl_setopt($c, CURLOPT_HTTPPROXYTUNNEL, true); 
          curl_setopt($c, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5); 
          curl_setopt($c, CURLOPT_PROXY, $socks);
        endif; 
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    return $json;
}

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function register($no)
	{
	$nama = nama();
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"name":"' . nama() . '","email":"' . $email . '@gmail.com","phone":"+' . $no . '","signed_up_country":"ID"}';
	$register = request("/v5/customers", "", $data);
	//print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['otp_token'];
		}
	  else
		{
		return false;
		}
	}
function verif($otp, $token)
	{
	$data = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $token . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
	$verif = request("/v5/customers/phone/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
		return false;
		}
	}
	function login($no)
	{
	$nama = nama();
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"phone":"+'.$no.'"}';
	$register = request("/v4/customers/login_with_phone", "", $data);
	print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['login_token'];
		}
	  else
		{
		return false;
		}
	}
function veriflogin($otp, $token)
	{
		
	$data = '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp.'","otp_token":"'.$token.'"},"grant_type":"otp","scopes":"gojek:customer:transaction gojek:customer:readonly"}';
	$verif = request("/v4/customers/login/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
		return false;
		}
	}
function claim($token)
	{
	$data = '{"promo_code":"GOFOOD022620A"}';
	$claim = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim['success'] == 1)
		{
		return $claim['data']['message'];
		}
	  else
		{
		return false;
		}
	}

echo "AUTO REGISTER, KLAIM VOUCHER, GOPAY SENDER V3\n";
print "Thanks to : Muhammad Ikhsan, Muhammad Jumadi, Muhammad Irsad\n\n";
echo "[+] Masukan 62 untuk ID dan 1 untuk US\n";
echo "[+] Nomor: ";
$nope = trim(fgets(STDIN));
$register = register($nope);
if ($register == false)
	{
	echo "[!] Gagal Mendapatkan OTP!\n";
	}
  else
	{
	echo "[+] OTP: ";
	$otp = trim(fgets(STDIN));
	$verif = verif($otp, $register);
	if ($verif == false)
		{
		echo "[+] Gagal Mendaftar!\n";
		}
	  else
		{
		echo "[+] Mencoba klaim GOFOOD022620A\n";
		$claim = claim($verif);
		if ($claim == false)
			{
			echo "[!] Gagal Klaim\n";
			}
		  else
			{
			echo $claim . "\n";
			}
		 
	}
     function fetch_value($str,$find_start,$find_end) {
	$start = @strpos($str,$find_start);
	if ($start === false) {
		return "";
	}
	$length = strlen($find_start);
	$end    = strpos(substr($str,$start +$length),$find_end);
	return trim(substr($str,$start +$length,$end));
}
function gopaysend($a, $no){
	$rand = rand(0000,9999);
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/wallet/qr-code?phone_number=%2B'.$no.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'X-Session-ID: 1d8ac538-2757-44ae-a3a0-e16b2b3912eb';
	$headers[] = 'D1: 93:F5:0A:32:29:A8:B0:97:AA:3B:B4:09:01:53:13:E7:BF:9D:2A:0D:B6:8D:EC:D8:4F:52:D1:C9:87:CF:0E:04';
	$headers[] = 'X-Platform: Android';
	$headers[] = 'X-UniqueId: '.$rand.'';
	$headers[] = 'X-AppVersion: 3.37.2';
	$headers[] = 'X-AppId: com.gojek.app';
	$headers[] = 'Authorization: Bearer 2f013e66-a8b1-4434-83ee-b2948d744158';
	$headers[] = 'X-DeviceOS: Android,7.1.2';
	$headers[] = 'User-uuid: 604374760';
	$headers[] = 'X-DeviceToken: fWIBbGVnreI:APA91bH1IXMz51gOyQz466ggvicFPpyAYzUpr2FCzzR3NWXiykL-PAMPpLLEtAuOq3F2tqBPQ_T-WFetrsRzj_ef6tY7-zfiQrTVfP44QqKNi9Br-07VUSkqcHhoSIlf4AWoc-HJWvVY';
	$headers[] = 'X-PushTokenType: FCM';
	$headers[] = 'X-PhoneModel: Xiaomi,Redmi 4X';
	$headers[] = 'Accept-Language: id-ID';
	$headers[] = 'X-User-Locale: id_ID';
	$headers[] = 'X-M1: 1:__a6b9bcaf8b864d81a1f39ce298a6fbe9,2:dea668397d44,3:1564554094307-3029908080826701121,4:9884,5:msm8937|1401|8,6:04:B1:67:B7:B6:59,7:<wifi is turned off>,8:720x1280,9:passive\,gps\,network,10:1,11:SVF2bUhIRWFxTE5vR1JyVUltdkd2REpkb3J2clV4eAA=';
	$headers[] = 'Host: api.gojekapi.com';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'User-Agent: okhttp/3.12.1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	curl_close ($ch);
        $qr = fetch_value($result,'"qr_id":"','"');

        $body = '{"amount":"1","description":"💰","qr_id":"'.$qr.'"}';
        $ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/v2/fund/transfer');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = 'pin: 050299';
	$headers[] = 'Accept: application/json';
	$headers[] = 'X-Session-ID: 1d8ac538-2757-44ae-a3a0-e16b2b3912eb';
	$headers[] = 'D1: 93:F5:0A:32:29:A8:B0:97:AA:3B:B4:09:01:53:13:E7:BF:9D:2A:0D:B6:8D:EC:D8:4F:52:D1:C9:87:CF:0E:04';
	$headers[] = 'X-Platform: Android';
	$headers[] = 'X-UniqueId: '.$rand.'';
	$headers[] = 'X-AppVersion: 3.37.2';
	$headers[] = 'X-AppId: com.gojek.app';
	$headers[] = 'Authorization: Bearer 2f013e66-a8b1-4434-83ee-b2948d744158';
	$headers[] = 'X-DeviceOS: Android,7.1.2';
	$headers[] = 'User-uuid: 604374760';
	$headers[] = 'X-DeviceToken: fWIBbGVnreI:APA91bH1IXMz51gOyQz466ggvicFPpyAYzUpr2FCzzR3NWXiykL-PAMPpLLEtAuOq3F2tqBPQ_T-WFetrsRzj_ef6tY7-zfiQrTVfP44QqKNi9Br-07VUSkqcHhoSIlf4AWoc-HJWvVY';
	$headers[] = 'X-PushTokenType: FCM';
	$headers[] = 'X-PhoneModel: xiaomi,Redmi 4x';
	$headers[] = 'Accept-Language: id-ID';
	$headers[] = 'X-User-Locale: id_ID';
	$headers[] = 'X-M1: 1:__a6b9bcaf8b864d81a1f39ce298a6fbe9,2:dea668397d44,3:1564554094307-3029908080826701121,4:9884,5:msm8937|1401|8,6:04:B1:67:B7:B6:59,7:<wifi is turned off>,8:720x1280,9:passive\,gps\,network,10:1,11:SVF2bUhIRWFxTE5vR1JyVUltdkd2REpkb3J2clV4eAA=';
	$headers[] = 'Content-Type: application/json; charset=UTF-8';
	$headers[] = 'Content-Length: 82';
	$headers[] = 'Host: api.gojekapi.com';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'User-Agent: okhttp/3.12.1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result1 = curl_exec($ch);
	curl_close ($ch);

        $ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'https://api.gojekapi.com/wallet/profile/detailed');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_POST, 1);

	$headers = array();
	$headers[] = 'Accept: application/json';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'X-Session-ID: 1d8ac538-2757-44ae-a3a0-e16b2b3912eb';
	$headers[] = 'D1: 93:F5:0A:32:29:A8:B0:97:AA:3B:B4:09:01:53:13:E7:BF:9D:2A:0D:B6:8D:EC:D8:4F:52:D1:C9:87:CF:0E:04';
	$headers[] = 'X-Platform: Android';
	$headers[] = 'X-UniqueId: '.$rand.'';
	$headers[] = 'X-AppVersion: 3.37.2';
	$headers[] = 'X-AppId: com.gojek.app';
	$headers[] = 'Authorization: Bearer 2f013e66-a8b1-4434-83ee-b2948d744158';
	$headers[] = 'X-DeviceOS: Android,7.1.2';
	$headers[] = 'User-uuid: 604374760';
	$headers[] = 'X-DeviceToken: fWIBbGVnreI:APA91bH1IXMz51gOyQz466ggvicFPpyAYzUpr2FCzzR3NWXiykL-PAMPpLLEtAuOq3F2tqBPQ_T-WFetrsRzj_ef6tY7-zfiQrTVfP44QqKNi9Br-07VUSkqcHhoSIlf4AWoc-HJWvVY';
	$headers[] = 'X-PushTokenType: FCM';
	$headers[] = 'X-PhoneModel: xiaomi,Redmi 4x';
	$headers[] = 'Accept-Language: id-ID';
	$headers[] = 'X-User-Locale: id_ID';
	$headers[] = 'X-M1: 1:__a6b9bcaf8b864d81a1f39ce298a6fbe9,2:dea668397d44,3:1564554094307-3029908080826701121,4:9884,5:msm8937|1401|8,6:04:B1:67:B7:B6:59,7:<wifi is turned off>,8:720x1280,9:passive\,gps\,network,10:1,11:SVF2bUhIRWFxTE5vR1JyVUltdkd2REpkb3J2clV4eAA=';
	$headers[] = 'Host: api.gojekapi.com';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'User-Agent: okhttp/3.12.1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result2 = curl_exec($ch);
	curl_close ($ch);
        return "[+] Success : ".fetch_value($result1,'"success":',',')." | Sisa Saldo : ".fetch_value($result2,'"balance":',',');
}

echo "[+] Nomor Target : ";
$no = trim(fgets(STDIN));
for($a=0;$a<1;$a++){
$oce = gopaysend($a, $no);
echo "".$oce."\n";
           }
	  	 }
?>
