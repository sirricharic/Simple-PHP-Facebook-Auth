<?

function make_request($url) {

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$clientResponse = curl_exec($ch);

	curl_close($ch);

	return $clientResponse;
}

$appID ='APPID';
$redirectURI = "REDIRECT_URI";
$clientSecret = 'App Secret Key';
$code = $_GET['code'];
$fbGraphURL = "https://graph.facebook.com/";
$fbApiVer = "v2.10";

//Get Initial Auth Code

$url1 = "${fbGraphURL}${fbApiVer}/oauth/access_token?client_id=${appID}&redirect_uri=${redirectURI}&client_secret=${clientSecret}&code=${code}";
$initialTokenResponse = make_request($url1);
$initialTokenJSON = json_decode($initialTokenResponse);
$initialToken = $initialTokenJSON -> {'access_token'};

//Get FB App Token to Inspect $initialToken Not required? I don't know but it was in the tutorial.

$url2 = "${fbGraphURL}${fbApiVer}/oauth/access_token?client_id=${appID}&client_secret=${clientSecret}&grant_type=client_credentials";

$appTokenResponse = make_request($url2);
$appTokenJSON = json_decode($appTokenResponse);
$appToken = $appTokenJSON -> {'access_token'};

//Inspect $initialToken using $appToken and $initialToken

//$url3 = "${fbGraphURL}${fbApiVer}/debug_token?input_token=${initialToken}&access_token=${appToken}";

//$approvalResponse = make_request($url3);
//$approvalJSON = json_decode($approvalResponse);
//$approval = $approvalJSON -> {'data'} -> ${'is_valid'};

//Eventually check if $approval is true but for now just get email and gtfo

$url4 = "${fbGraphURL}${fbApiVer}/me?fields=email&access_token=${initialToken}";

$emailResponse = make_request($url4);
$emailJSON = json_decode($emailResponse);
$email = $emailJSON -> {'email'}; // This fuckery right here

//Now you have the email for login.

//Making a link to https://www.facebook.com/v2.10/dialog/oauth?client_id={$appID}&redirect_uri={$redirectURI}&scope=email,public_profile
//Will take you to your (This Page) to exchange auth.


?>