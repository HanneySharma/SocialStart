<?php
require_once __DIR__ . '/vendor/autoload.php';

define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', __DIR__ .'/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/sheets.googleapis.com-php-quickstart.json
define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}
//echo 'he';die;
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();

    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';

    $authCode = trim(fgets(STDIN));
    //$authCode = "4/ik21JJusXlbFyX-8_kvG7DkvmkA-TscMUEKmcEhpuUE";
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0777, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);


$spreadsheetId = '1wpsY63vshpKwd7nXvXtmw7CU3Fev_AlrZqeQAJwtksM';

$range = 'A677:K';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

$conn = mysqli_connect("localhost","root","socialstart","socialstart");



if (count($values) == 0) {
  print "No data found.\n";
} else {
  foreach ($values as $key => $row) {

    // $sql = "SELECT * FROM googlesheet ORDER BY id DESC LIMIT 1";
    // $result = $conn->query($sql);
    // $mylink = $result->fetch_assoc();

    $sltQuery = 'SELECT `id`  FROM `organizations` WHERE `formal_company_name` = "'.$row[2].'" and source = "directinquiry"';
    $result = $conn->query($sltQuery);
    $mylink = $result->fetch_assoc();
    if(empty($mylink)){

    
    


      $created = date('Y-m-d H:i:s', strtotime($row[0]));
      $name = explode(' ', $row[1]);
      $first_name = (isset($name[0]))?  mysqli_real_escape_string($conn, $name[0]) : '';
      $last_name  = (isset($name[1]))?  mysqli_real_escape_string($conn, $name[1]) : '';
      $company = mysqli_real_escape_string($conn, $row[2]);
      $email = mysqli_real_escape_string($conn, $row[3]);
      $description = mysqli_real_escape_string($conn, $row[4]);
      $contact = mysqli_real_escape_string($conn, $row[5]);
      $vartical = mysqli_real_escape_string($conn, $row[6]);
      $revenue = mysqli_real_escape_string($conn, $row[7]);
      $founded = date('Y-m-d', strtotime($row[8]));
      $funds_raised =  (isset($row[9]))? mysqli_real_escape_string($conn, $row[9]) : '';
      $website =  (isset($row[10]))? mysqli_real_escape_string($conn, $row[10]) : '';

      $fields = array(
          'formal_company_name' => $company,
          'first_name' => $first_name,
          'last_name' => $last_name,
          'last_name' => $last_name,
          'email' => $email,
          'description' => $description,
          'phone' => $contact,
          'verticals' => $vartical,
          'money_raised' => ($revenue != '' || !empty($revenue != '-'))? str_replace("$",'',$revenue) : 0,
          'total_funding_usd' => $funds_raised,
          'founded_on' => $founded,
          'website' => $website,
          'source' => 'directinquiry',
          'created' => $created,
      );
      $sql = "INSERT INTO `organizations` ("; 
      foreach ($fields as $key => $value) {
          $sql .= $key.', ';
      }
      $sql = rtrim($sql,", ");
      $sql .= ') VALUES (';
      foreach ($fields as $key => $value) {
          $sql .= '"'.$value.'", ';
      }
      $sql = rtrim($sql,", ");
      $sql .= ')';
      $conn->query($sql);
    }
  }
  die('success');
  }












//https://docs.google.com/spreadsheets/d/1kc3aoZekGpkVObLwpQaeCB2SEU245QwZfGPi_pTcDsI/edit#gid=0
