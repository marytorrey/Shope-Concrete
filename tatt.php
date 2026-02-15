<?php
// CONFIG
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$filePath = __FILE__;
$file = basename(__FILE__);
$current_dir = realpath(dirname(__FILE__));
$tempDir = sys_get_temp_dir();
$os = getOS();
$directorySeparator = ($os === 'Windows') ? '\\' : '/'; // Use backslash for Windows and forward slash for Linux
$now = setTime();
error_reporting(E_ALL ^ E_WARNING);
date_default_timezone_set('America/Phoenix');
$testFiles = isset($_SESSION['testFiles']) ? $_SESSION['testFiles'] : [];
$phpVersion = getPHPvers();
$fileHandlingResults = testPHPfiles($tempDir, $now);
$sessionResults = sessionTest();
global $maxRequests;
$maxRequests = 42;
$allowedExtensionsText = "Allowed extensions: jpg, jpeg, png, gif";
$sizeLimitText = "Max file size: 1MB";
$alerts = [];
// END CONFIG

function httpsCheck() {
    global $alerts;
    if (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] !== "on") {
    // No HTTPS - set warning and restrict tests with creds
        array_push($alerts, "ALERT! TATT is running in insecure mode - tests involving credentials are only available over HTTPS for security reasons.") ;
    }return;
}
httpsCheck();

function limitRequests() {
  $tattCount = date('m-d-Y') . '_tatt_counter';
  
  if (!file_exists($tattCount)) {
      $requestCount = "1";
      file_put_contents($tattCount, $requestCount);
  } 
  
  $files = glob('*_tatt_counter');
      foreach ($files as $file) {
          if ($file !== $tattCount) {
              unlink($file);
          }
      }

  $requestCount = file_get_contents($tattCount);
      if (empty($requestCount)) {
          $requestCount = "1";
      } else {
          // If not blank, increase the number by 1
          $requestCount = intval($requestCount) + 1;
      }
      file_put_contents($tattCount, $requestCount);
  return $requestCount;
}

function verify_input($data) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  return $data;
}

function setTime() {
    $timezone = new DateTime('now', new DateTimeZone('UTC'));
    $timezone->modify('-7 hours');
    $timeFormat = $timezone->format('d-m-Y-H:i');

    return $timeFormat; 
}

function getPHPvers() {
    $phpVers = phpversion();
    $phpVersfloat = floatval($phpVers);
    if ($phpVersfloat <= 5.5) {
        echo "Error: Your PHP version ($phpVers) is 5.5 or lower. Please upgrade to a higher version for this tool to work.";
        exit();
    } else {
        return $phpVers; 
    }
}

if (isset($_POST['remoteRemove'])) {
  removeSelf();
}

if (isset($_POST['removeButton'])) {
  removeSelf();
}

function getOS() {
    $os = strtolower(PHP_OS);
    if (strpos($os, 'win') === 0) {
        return 'Windows';
    } elseif (strpos($os, 'linux') === 0) {
        return 'Linux';
    } else {
        // Unable to detect the host OS
        return 'Unknown';
    }
}

// Check if the file is writable
if(!is_writable($filePath)) {
  setWrite($os, $filePath);
}

function setWrite($os, $filePath) {
    if ($os === 'Linux') {
        // Linux host, change file permissions
        if (chmod(__FILE__, 0644)) {
            return true;
        } else {
            echo "ALERT! Unable to set file perms, please ensure file has write and modify permissions. TATT tests will fail without proper permissions.";
            exit;
        }
    } elseif ($os === 'Windows') {
        // Windows host, cannot modify permissions
        echo "ALERT! Unable to set file perms, please ensure file has write and modify permissions. TATT tests will fail without proper permissions.";
        exit;
    } else {
        // Unknown host OS
        echo "Unable to set file perms, please ensure file has write and modify permissions.";
        exit;
    }
}

function createCronJob() {
  $cronFileContent = '<?php file_put_contents("tatt_cron_success.txt", "Cron ran successfully at " . date("Y-m-d H:i:s"));$cronJobCommand = \'php -f \' . __DIR__ .  \'/tatt_cron_test.php\';exec(\'(crontab -l | grep -v "\' . $cronJobCommand . \'") | crontab -\');unlink(__FILE__); ?>';
  file_put_contents('tatt_cron_test.php', $cronFileContent);
  $cronJobCommand = 'php -f ' . __DIR__ .  '/tatt_cron_test.php';
  $cronExpression = '* * * * *';
  exec('(crontab -l ; echo "' . $cronExpression . ' ' . $cronJobCommand . '") | crontab -', $output, $returnValue);
  if ($returnValue !== 0) {
      return 'Error: Failed to set cron job';
  } else {
      return 'Cron set';
  }
}

function checkCronStatus() {
  if (file_exists('tatt_cron_success.txt')) {
      return 'Cron executed successfully';
  } else {
      return 'Cron not yet executed. Checking...';
  }
}

function testPHPfiles($tempDir, $now) {
    $prefix = "TATT-fileTest-";
    $testFile = $tempDir . DIRECTORY_SEPARATOR . $prefix . $now;
    $fileResults = array(
        'fileCreate' => '',
        'fileWrite' => '',
        'fileRead' => '',
        'fileRemove' => ''
    );

    $fileContent = "This is a test file created by PHP.";
    $fileHandle = fopen($testFile, 'w');
    if ($fileHandle === false) {
        $fileResults['fileCreate'] = "Failed";
        return $fileResults;
    } else {
        $fileResults['fileCreate'] = "Success";
    }

    if (fwrite($fileHandle, $fileContent) === false) {
        $fileResults['fileWrite'] = "Failed";
        fclose($fileHandle);
        return $fileResults;
    } else {
        $fileResults['fileWrite'] = "Success";
    }

    fclose($fileHandle);

    $readFile = file_get_contents($testFile);
    if ($readFile !== false) {
        $fileResults['fileRead'] = "Success";
    } else {
        $fileResults['fileRead'] = "Failed";
    }

    if (unlink($testFile)) {
        $fileResults['fileRemove'] = "Success";
    } else {
        $fileResults['fileRemove'] = "Failed";
    }
    return $fileResults;
}

function sessionTest() {
  $sessionResults = array(
      'sessionStart' => '', 
      'sessionWrite' => ''
  );

  if (session_status() == PHP_SESSION_NONE) {
      session_start();
      $sessionResults['sessionStart'] = 'Success'; 
  } elseif (session_status() == PHP_SESSION_ACTIVE) {
      $sessionResults['sessionStart'] = 'Success';
  } else {
      $sessionResults['sessionStart'] = 'Failed'; 
  }

  $_SESSION['session_test'] = 'This is a test value for PHP session.';
  if (isset($_SESSION['session_test'])) {
      $sessionResults['sessionWrite'] = 'Success'; 
  } else {
      $sessionResults['sessionWrite'] = 'Failed'; 
  }

  return $sessionResults;
}

function removeSelf() {
    global $testFiles;

    $uniqueFiles = array_unique($testFiles);

    foreach ($uniqueFiles as $file) {
        if (unlink($file)) {
            echo "File '$file' removed successfully.<br>";
        } else {
            echo "ALERT! Unable to remove the file '$file' using 'unlink'. Make sure the file is writable.<br>";
        }
    }

    unset($_SESSION['testFiles']);
    setcookie("TATT", "N", time() -3600, '/');

    if (unlink(__FILE__)) {
        echo "Script file '" . __FILE__ . "' removed successfully.<br>";
    } else {
        echo "ALERT! Unable to remove the script file '" . __FILE__ . "' using 'unlink'. Make sure the file is writable.<br>";
    }
}

function fileUpload() {
  global $maxRequests, $testFiles, $alerts, $allowedExtensionsText, $sizeLimitText;
  $targetDir = "./";
  $fileTmpName = $_FILES["fileToUpload"]["tmp_name"];
  $extension = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
  $mimetype = $_FILES["fileToUpload"]["type"];
  $targetFile = $targetDir . "tatt_upload_test." . $extension;
  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  $allowedExtensions = array("jpg", "jpeg", "png", "gif");
  $allowedMimeTypes = array("image/jpeg", "image/png", "image/gif");

  $requestCount = limitRequests();
  if ($requestCount > $maxRequests){
      return "ERROR! too many requests - to reset this remove tatt_counter on your filesystem";
      exit;
  }

  if (!in_array($extension, $allowedExtensions)) {
      // Add more detailed error information
      $debugInfo = "Debug: Invalid file type.\r\n";
      $debugInfo .= "Actual Extension: " . $extension . "\r\n";
      $debugInfo .= "Allowed Extensions: " . implode(", ", $allowedExtensions) . "\r\n";
      return "Invalid file type. " . $debugInfo;
  }

  if (!in_array($mimetype, $allowedMimeTypes)) {
    // Add more detailed error information
    $debugInfo = "Debug: Invalid mime type.\r\n";
    $debugInfo .= "Mime type sent by your browser: " . $mimetype . "\r\n";
    $debugInfo .= "Allowed Mime Types: " . implode(", ", $allowedMimeTypes) . "\r\n";
    return "Invalid mime type. " . $debugInfo;
  }

$magicBytes = file_get_contents($fileTmpName, false, null, 0, 4); // Read the first 4 bytes
  $validMagicBytes = array(
      "jpg" => "\xFF\xD8\xFF", // JPEG
      "jpeg" => "\xFF\xD8\xFF", // JPEG
      "png" => "\x89\x50\x4E\x47", // PNG
      "gif" => "GIF8" // GIF
  );

  if (!isset($validMagicBytes[$extension]) || strncmp($magicBytes, $validMagicBytes[$extension], strlen($validMagicBytes[$extension])) !== 0) {
      return "Invalid file type. Magic bytes check failed.";
  }

  // Check for php start chars in the first 100 bytes (common tactic to bypass magic bytes)
  $fileContents = file_get_contents($fileTmpName, false, null, 0, 100); // Read the first 100 bytes
  if (strpos($fileContents, "<?") !== false ) {
      return "Invalid file type. PHP start tag was detected.";
  }

  $maxFileSize = 1000000; // 1 MB

  if ($_FILES["fileToUpload"]["size"] > $maxFileSize) {
      // Add more detailed error information
      $debugInfo = "Debug: File size exceeds the limit.\r\n";
      $debugInfo .= "Actual Size: " . $_FILES["fileToUpload"]["size"] . "\r\n";
      $debugInfo .= "Max Size: " . $maxFileSize . "\r\n";
      return "File size exceeds the limit. " . $debugInfo;
  }

  // Display detailed error messages
  if ($_FILES["fileToUpload"]["error"] > 0) {
      return "File Upload Error: " . $_FILES["fileToUpload"]["error"];
  }

  // Check if the file is really uploaded
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
          chmod($targetFile, 0644);
          $uploadInfo = "File uploaded successfully!\r\n";
          $uploadInfo .= "Filename: " . basename($targetFile) . "\r\n";
          $uploadInfo .= "Type: " . $_FILES["fileToUpload"]["type"] . "\r\n";
          $uploadInfo .= "Size: " . round(($_FILES["fileToUpload"]["size"] / 1024), 2) . " KB\r\n";
          $testFiles[] = __DIR__ . '/tatt_upload_test.' . $extension;
          $_SESSION['testFiles'] = $testFiles;
          return $uploadInfo;
      } else {
          // Add more detailed error information
          $debugInfo = "Debug: " . error_get_last()['message'] . "\r\n";
          $debugInfo .= "Target File: " . $targetFile . "\r\n";
          $debugInfo .= "Current Working Directory: " . getcwd() . "\r\n";
          return "There was an error uploading your file. Move operation failed. " . $debugInfo;
      }
}

function mysqlTest($mysqlHost, $mysqlDatabase, $mysqlUser, $mysqlPassword, $mysqlPort) {
    // Sanitize input
    $mysqlHost = verify_input($mysqlHost);
    $mysqlDatabase = verify_input($mysqlDatabase);
    $mysqlUser = verify_input($mysqlUser);
    $mysqlPassword = verify_input($mysqlPassword);
    $mysqlPort = verify_input($mysqlPort);

    // Initialize an array to store the result and debug information
    $result = array();

    // if mysqlPort is a valid port number, use it, otherwise use the default port
    if (is_numeric($mysqlPort) && $mysqlPort > 999 && $mysqlPort < 65535) {
        $mysqlPort = (int)$mysqlPort;
    } else {
        $mysqlPort = 3306;
    }

    // Check to see what extensions are available
    if ($_POST['config'] == "auto") {
        if (extension_loaded('mysqli')) {
            $extension = "mysqli";
        } elseif (extension_loaded('pdo_mysql')) {
            $extension = "pdo_mysql";
        } else {
            $result['error'] = "The MySQLi or PDO extension is not available.";
            return json_encode($result);
        }
    } elseif ($_POST['config'] == "mysqli") {
        if (extension_loaded('mysqli')) {
            $extension = "mysqli";
        } else {
            $result['error'] = "The MySQLi extension is not available.";
            return json_encode($result);
        }
    } elseif ($_POST['config'] == "pdo_mysql") {
        if (extension_loaded('pdo_mysql')) {
            $extension = "pdo_mysql";
        } else {
            $result['error'] = "The PDO MySQL extension is not available.";
            return json_encode($result);
        }
    }

    if ($extension == "mysqli") {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        // Create connection
        try {
            $con = @mysqli_connect($mysqlHost, $mysqlUser, $mysqlPassword, $mysqlDatabase, $mysqlPort);
            $result['message'] = "The database connection was successful!";
            mysqli_close($con);
        } catch (Exception $e) {
            $result['error'] = "Failed to connect to MySQL using the PHP mysqli extension: " . $e->getMessage();
        }
    } elseif ($extension == "pdo_mysql") {
        // Create connection
        try {
            $con = new PDO("mysql:host=$mysqlHost;port=$mysqlPort;dbname=$mysqlDatabase", $mysqlUser, $mysqlPassword);
            $result['message'] = "The database connection was successful!";
            $con = null;
        } catch (Exception $e) {
            $result['error'] = "Failed to connect to MySQL using the PHP PDO extension: " . $e->getMessage();
        }
    }

    // Add additional information to the result array
    $result['extension'] = $extension;

    return json_encode($result);
}

function tattPing() {
  $params=['domain' => urlencode($_SERVER['HTTP_HOST']), 'file' => $_SERVER['SCRIPT_NAME'], 'https' => $_SERVER['HTTPS']];
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL,"https://9krq5o9767.execute-api.us-west-2.amazonaws.com/prod/");
  curl_setopt($ch, CURLOPT_HEADER  , true);
  curl_setopt($ch, CURLOPT_NOBODY  , true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, 
    http_build_query(  $params  ) );

  $ch_results = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  $checksum= sha1_file(__FILE__);
  list($headers, $jsonContent) = explode("\r\n\r\n", $ch_results, 2);
  $results_array = json_decode($jsonContent, true);
  if (isset($results_array['checksum'])) {
    $passedChecksum = $results_array['checksum'];
  } else {
    echo " version check failed - exiting";
    exit;
  }

  if ($checksum !== $passedChecksum) {
        echo "Your version of TATT is outdated. Please download the newest version.";
        removeSelf();
        exit;
    }
}

if(!isset($_COOKIE["TATT"])) {
  setcookie("TATT", "Y", time() +3600, '/');
  tattPing();
  limitRequests();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['VERSION'])) {
  $passedVersion = $_POST['VERSION'];
  if ($currentVersion !== $passedVersion) {
      echo "Your version of TATT is outdated. Please download the newest version.";
      removeSelf();
  }
}

// WINDOWS ONLY TESTS //
function mssqlTest($serverName, $dbName, $username, $password) {
  $serverName = verify_input($serverName);
  $dbName = verify_input($dbName);
  $username = verify_input($username);
  $password = verify_input($password);

  $connectionOptions = array(
      "Database" => $dbName,
      "Uid" => $username,
      "PWD" => $password
  );

  $conn = sqlsrv_connect($serverName, $connectionOptions);

  if ($conn === false) {
      $result['error'] = "Connection failed. Error: " . print_r(sqlsrv_errors(), true);
  } else {
      $result['message'] = "Connected to SQL Server successfully.";
      sqlsrv_close($conn);
  }

  return json_encode($result);
}


// send a minimal test message by connecting to an smtp server and sending commands using the smtp protocol
function sendsmtp(&$smtp_log, $to, $from, $subject, $message, $relayserver, $helo)
{

  global $maxRequests, $alerts;
    $requestCount = limitRequests();
    if ($requestCount > $maxRequests){
        return "ERROR! too many requests - to reset this remove tatt_counter on your filesystem";
        exit;
    }

  $timeout = 15;
  $port = 25;
  $smtp_cmd = "";
  $smtp_log = "";

  //connect to the host and port
  $smtp_log .= "Connecting to $relayserver on port $port\r\n";
  $smtpConnect = fsockopen($relayserver, $port, $errno, $errstr, $timeout);

  //check if the connection was successful
  if (!$smtpConnect) {
    //if not successful, output the error message
    $smtp_log .= "Failed to connect to SMTP server: $errstr ($errno)\r\n";
    return false;
  } else {
    $smtp_log .= "Connected\r\n";
  }

  //get the server response
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 220) {
    //if the response doesn't start with 220, return
    return false;
  }

  //introduce ourselves to the server
  $smtp_cmd = "HELO $helo\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 250) {
    //if the response doesn't start with 250, return
    return false;
  }

  //tell the server we want to send an email
  $smtp_cmd = "MAIL FROM: $from\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 250) {
    //if the response doesn't start with 250, return
    return false;
  }

  //tell the server who we want to send the email to
  $smtp_cmd = "RCPT TO: $to\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 250) {
    //if the response doesn't start with 250, return
    return false;
  }

  $smtp_cmd = "DATA\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 354) {
    //if the response doesn't start with 354, return
    return false;
  }

  //send the subject and the message
  $smtp_cmd = "Subject: $subject\r\n\r\n$message\r\n\r\n.\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 250) {
    //if the response doesn't start with 250, return
    return false;
  }

  $smtp_cmd = "QUIT\r\n";
  $smtp_log .= $smtp_cmd;
  fputs($smtpConnect, $smtp_cmd);
  $smtpResponse = fread($smtpConnect, 4096) . "\r\n";
  $smtp_log .= $smtpResponse;
  if (substr($smtpResponse, 0, 3) != 221) {
    //if the response doesn't start with 221, return
    return false;
  }

  //close the connection
  fclose($smtpConnect);

  //if we made it this far, the email was sent successfully
  return true;
}

$hostname = gethostname();

// determine what the default relay server should be based on the type of hosting
if (strpos($hostname, 'cpnl') === FALSE) //if not cPanel
  $relayserver = 'relay-hosting.secureserver.net';
else
  $relayserver = 'localhost';

// if the form was submitted, send the email
if (isset($_REQUEST['sendemail'])) {

  header("Content-Type: text/plain");
  header("X-Node: $hostname");

  $sendmethod = $_REQUEST['sendmethod'];
  $relayserver = $_REQUEST['relayserver'];
  $from = $_REQUEST['from'];
  $to = $_REQUEST['toemail'];
  $subject = htmlspecialchars($_REQUEST['subject']);
  $message = htmlspecialchars($_REQUEST['message']);

  if ( !preg_match('/^ *[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,} *$/i', $from) ) {
    echo 'Invalid from address.';
    exit;
  }

  if ( !preg_match('/^ *[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,} *$/i', $to) ) {
    echo 'Invalid to address.';
    exit;
  }

  if ($sendmethod == "mail") {

    $result = mail($to, $subject, $message, "From: $from");
    if ($result) {
      echo 'OK';
    } else {
      echo 'FAIL';
    }

  } elseif ($sendmethod == "smtp") {

    if ( !preg_match('/^ *[A-Z0-9.-]+\.[A-Z]{2,} *$|localhost/i', $relayserver) ) {
      echo 'Invalid relay server.';
      exit;
    }
  
    $mailconversation = "";
    $result = sendsmtp($mailconversation, $to, $from, $subject, $message, $relayserver, $hostname);
    $mailconversation = nl2br(htmlspecialchars($mailconversation));

    if ($result) {
      $mailconversation .= "<div style=\"font-size:16px;color:green;\">SUCCESS</div>";
    } else {
      $mailconversation .= "<div style=\"font-size:16px;color:red;\">FAIL</div>";
    }

    echo $mailconversation;

  } elseif ($sendmethod == "sendmail") {

    //remove patterns from strings using regex
    $subject = preg_replace('/[^a-zA-Z0-9\@\.\-\_\, ]|EOF/i', '', $subject);
    $message = preg_replace('/[^a-zA-Z0-9\@\.\-\_\, ]|EOF/i', '', $message);
    $cmd = "cat - << EOF | /usr/sbin/sendmail -t 2>&1\nto:$to\nfrom:$from\nsubject:$subject\n\n$message\n\nEOF\n";
    $result = shell_exec($cmd);
    $cmd = nl2br(htmlspecialchars($cmd));
    if ($result == '') { //A blank result is usually successful
      echo $cmd .= "<div style=\"font-size:16px;color:green;\">SUCCESS</div>";
    } else {
      echo $cmd .= $result . "<div style=\"font-size:16px;color:red;\">FAIL</div>";
    }

  } else {
    echo 'FAIL (Invalid sendmethod variable in POST data)';
  }
  exit;
}

// Handle MySQL form submission
if (isset($_POST["mysqlHost"]) && isset($_POST["mysqlDatabase"]) && isset($_POST["mysqlUser"]) && isset($_POST["mysqlPassword"]) && isset($_POST["mysqlPort"])) {
  $result = mysqlTest($_POST['mysqlHost'], $_POST['mysqlDatabase'], $_POST['mysqlUser'], $_POST['mysqlPassword'], $_POST['mysqlPort']);
  echo $result;
  exit;
}

// Handle MSSQL form submission
if (isset($_POST["serverName"]) && isset($_POST["dbName"]) && isset($_POST["username"]) && isset($_POST["password"])) {
  $result = mssqlTest($_POST['serverName'], $_POST['dbName'], $_POST['username'], $_POST['password']);
  echo $result;
  exit;
}
// Handle cron action
if (isset($_POST["cronAction"])) {
  $action = $_POST["cronAction"];
    switch ($action) {
      case "setCron":
        $result = createCronJob();
        echo $result;
        exit;
        break;
      case "checkCronStatus":
        $result = checkCronStatus();
        echo $result;
        exit;
        break;
      default:
      // Handle unknown action
        break;
    }
}

// Handle file upload test
if (isset($_POST["uploadTest"])) {
  $uploadResult = fileUpload();
  echo $uploadResult;
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>TATT - (PHP) </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
<style media="screen">

  .wt-mt {
    margin-top: 10vh; /* 10% of the viewport height */
  }
  .dbConnectionTest {
    width: 40vw; 
  }
  .navbar {
    background-color: #333;
    color: #fff;
    padding: 10px;
    position: sticky;
    top: 0;
}
.navbar nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.navbar nav li {
    display: inline-block;
    margin-right: 20px;
}

.navbar nav li a {
    color: #fff;
    text-decoration: none;
}
.content {
    padding: 20px;
    margin-top: 70px;
}
  .padding {
    padding-top: 1em;
    padding-bottom: 1em;
    padding-left: 1em;
    padding-right: 1em;
  }
  .curlTest {
    width: 40vw;
  }
  .results {
    font-weight: 700;
  }
  .uploadTest {
    width: 30vw; 
  }
  .cronTest {
    width: 30vw;
  }
  .hidefield {
    display: none;
  }
  body {
    padding: 0;
  }
  h1 {
    text-align: center;
  }
  iframe {
    width: 100%;
    height: 40vh; /* 40% of the viewport height */
    border: none;
  }
</style>
</head>
<body>
<?php if ($alerts): ?>
    <div style="background-color: red; color: white; padding: 10px;">
    <strong>Alerts:</strong><br>
        <?php foreach ($alerts as $alert): ?>
        <?php echo '<center>' . $alert . '</center>' . '<br>'; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<header>
  <nav class="navbar navbar-dark fixed-top bg-dark">
    <div class="d-flex justify-content-start">
      <span class="navbar-brand mb-0 h1"><h1>TATT</h1><p><h5>Test all the (PHP) Things</h5></span><br>
    </div>

    <div class="d-flex justify-content-end">
      <span class="navbar-brand mb-0 h1">Host: <?php echo $os; ?><p><h6>PHP Version:<strong> <?php echo $phpVersion; ?></strong></h6> </span>
    </div>
      <div>
        <span class="navbar-brand mb-0 h1"><u>Session Tests</u><br>
          <?php echo " Start: " . $sessionResults['sessionStart'] . "<br>"
           . " Read/Write: " . $sessionResults['sessionWrite'] . "<br>";
          ?>
        </span>
      </div>
        <div>
            <span class="navbar-brand mb-0 h1">
                <u>File Handling Tests</u><br>
                <?php
                echo " Create: " . $fileHandlingResults['fileCreate'] . "<br>"
                    . " Write: " . $fileHandlingResults['fileWrite'] . "<br>"
                    . " Read: " . $fileHandlingResults['fileRead'] . "<br>"
                    . " Remove: " . $fileHandlingResults['fileRemove'] . "<br>";
                ?>
            </span>
        </div>
  </nav>
  </header>
  <div class="container-fluid wt-mt">
    <div class="row">
      <div class="col-sm-2 text-center">
        <div class="nav flex-column" role="tablist" aria-orientation="vertical">
        <?php if ( isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on"): ?>
          <a class="nav-link" id="mysql-link" data-toggle="pill" href="#mysql" role="tab" aria-controls="mysql" aria-selected="true">MySQL</a>
          <a class="nav-link" id="form-mail-link" data-toggle="pill" href="#form-mail" role="tab" aria-controls="form-mail" aria-selected="false">Form Mailer</a>
          <?php endif; ?>
          <a class="nav-link" id="php-info-link" data-toggle="pill" href="#php-info" role="tab" aria-controls="php-info" aria-selected="false">phpInfo</a>
          <a class="nav-link" id="curl-link" data-toggle="pill" href="#curl" role="tab" aria-controls="curl" aria-selected="true">cURL</a>
          <a class="nav-link" id="upload-link" data-toggle="pill" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Upload</a>
          <?php if ($os === "Windows" && isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on"): ?>
              <a class="nav-link" id="mssql-link" data-toggle="pill" href="#mssql" role="tab" aria-controls="mssql" aria-selected="true">MSSQL</a>
           <?php endif; ?>
            <?php if ($os === "Linux"): ?>
             <a class="nav-link" id="cron-link" data-toggle="pill" href="#cron" role="tab" aria-controls="cron" aria-selected="true">Cron</a>
            <?php endif; ?>
        </div>
        <br>
        <form method="post">
          <input type="submit" name="removeButton" value="Finish and Cleanup" />
        </form><br>
      </div>
      <div id="test_area" class="col-sm-8 tab-content">

<div class="dbConnectionTest tab-pane" id="mysql" role="tabpanel" aria-labelledby="mysql-link">
    <div class="card">
        <div class="card-body" id="mysql">
            <h3 class="card-title"><center>MySQL Database Connection Test</center></h3>
            <form id="mysqlForm" method="post">
              <input type="hidden" name="mysqlAction" value="connTest">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="config">Connection:</label>
                    <div class="col-sm-9">
                        <select class="form-control form-control-sm" name="config" id="config">
                            <option value="auto" selected>Auto Select</option>
                            <option value="mysqli">MySQLi</option>
                            <option value="pdo_mysql">PDO</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="host">Host Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="host" name="mysqlHost" required autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="database">DB Name:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="database" name="mysqlDatabase" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="user">User:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" id="user" name="mysqlUser" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="pwd">Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control form-control-sm" id="pwd" name="mysqlPassword" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="port">Port (optional):</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control form-control-sm" id="port" name="mysqlPort" min="1" max="65535" value="3306">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="mysqlAction" class="btn btn-primary">Connect</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Results:</h3>
            <div id="mysqlResult"></div>
        </div>
    </div>
</div>

<div class="formMailTest tab-pane" id="form-mail" role="tabpanel" aria-labelledby="form-mail-link">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Mail Test</h3>
              <form id="mailform" name="mailform">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="sendmethod">Method:</label>
                  <div class="col-sm-9">
                    <select onchange="AutoSubject(); HideShowRelayServer();" class="form-control form-control-sm" name="sendmethod" id="sendmethod">
                      <option value="mail">PHP mail()</option>
                      <option value="smtp">SMTP</option>
                      <?php if ($os === 'Linux' && function_exists('shell_exec')) { ?>
                        <option value="sendmail">sendmail from shell</option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="form-group row hidefield">
                  <label class="col-sm-3 col-form-label" for="relayserver">SMTP Host:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="relayserver" name="relayserver" value="<?php echo $relayserver; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="toemail">To:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="toemail" name="toemail">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="from">From:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" id="from" name="from">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="subject">Subject:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" disabled id="subject" name="subject">
                    <label for="autosubject" class="form-check-label">
                      <input type="checkbox" onchange="AutoSubject();" name="autosubject" checked class="form-check-input" id="autosubject">Auto
                    </label>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label" for="message">Message:</label>
                  <div class="col-sm-9">
                    <textarea class="form-control" id="message" name="message"></textarea>
                  </div>
                </div>
                <div class="text-center">
                  <button type="button" class="btn btn-primary" id="sendemail"
                    onclick="GoSend(); AutoSubject();">Send</button>
                </div>
              </form>
            </div>
          </div>
          <table id="msglog" class="table table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">TIME</th>
                <th scope="col">TO</th>
                <th scope="col">FROM</th>
                <th scope="col">SUBJECT</th>
                <th scope="col">MESSAGE</th>
                <th scope="col">METHOD</th>
                <th scope="col">NODE</th>
                <th scope="col">RESULT</th>
              </tr>
            </thead>
          </table>
        </div>
        <div class="phpInfoTest tab-pane" id="php-info" role="tabpanel" aria-labelledby="php-info-link">
          <?php phpinfo(); ?>
        </div>
        <div class="curlTest tab-pane" id="curl" role="tabpanel" aria-labelledby="curl-link">
        <?php
            // cURL test
            $url="https://www.secureserver.net";
            if (isset($_GET["site"])) {
                $url = $_GET["site"];
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 120);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            $result = curl_exec($ch);
            curl_close ($ch);
        ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">PHP cURL Test</h3>
                <span class="results">URL:</span> <a href="<?php echo $url; ?>" target="_blank"><?php echo $url; ?></a><br /><br />
                <span class="results">cURL Result:</span><br />
                <iframe srcdoc="<?php echo htmlentities($result);?>"></iframe><br /> <!-- iframe keeps styles isolated -->
                <span class="results">Errors:</span><?php echo $errno . " " . $error; ?>
                </div>
            </div>
        </div>

<div class="uploadTest tab-pane" id="upload" role="tabpanel" aria-labelledby="upload-link">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">PHP Upload Test</h3>
                <form id="uploadForm" method="post" enctype="multipart/form-data">
                    <!-- Add a hidden input field to indicate form submission -->
                    <input type="hidden" name="uploadTest" value="true">
                    <label for="fileToUpload">Select File:</label><br>
                    <?php echo nl2br($allowedExtensionsText . "\r\n"); ?>
                    <input type="file" name="fileToUpload" id="fileToUpload" required><br>
                    <?php echo nl2br($sizeLimitText . "\r\n"); ?>
                    <br>
                    <input type="submit" value="Upload File">
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Results:</h3>
                <div id="uploadResults"></div> 
            </div>
        </div>
    </div>

 <div class="dbConnectionTest tab-pane" id="mssql" role="tabpanel" aria-labelledby="mssql-link">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">SQL Connection Test</h3>
                    <form id="mssqlForm" method="post">
                      <div class="form-group row">
                          <label for="serverName">Server Name:</label>
                          <input type="text" class="form-control form-control-sm" id="serverName" name="serverName" required><br>
                      </div>
                      <div class="form-group row">
                          <label for="dbName">Database Name:</label>
                          <input type="text" class="form-control form-control-sm" id="dbName" name="dbName" required><br>
                      </div>
                      <div class="form-group row">
                          <label for="username">Username:</label>
                          <input type="text" class="form-control form-control-sm" id="username" name="username" required><br>
                      </div>
                      <div class="form-group row">                        
                          <label for="password">Password:</label>
                          <input type="password" class="form-control form-control-sm" id="password" name="password" required><br>
                      </div>
                      <input type="submit" name="mssqlTest" class="btn btn-primary" value="Test Connection">
                  </form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Results:</h3>
                    <div id="mssqlResult"></div> 
                </div>
            </div>
        </div>

<div class="cronTest tab-pane" id="cron" role="tabpanel" aria-labelledby="cron-link">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Cron Test</h3>
            <form id="cronForm" method="post">
                <button type="button" name="cronAction" value="setCron" class="btn btn-primary">Set Cron</button>
            </form>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Results:</h3>
            <div id="cronResult"></div> 
        </div>
    </div>
</div>

        </div>
      </div>
    </div>
  </div>

  <script>
  var msgid = 1;
  AutoSubject();

  function AutoSubject() {
    if ( document.mailform.autosubject.checked ) {
        document.mailform.subject.disabled=true;
        document.mailform.subject.value='GD PHP '+document.mailform.sendmethod.value+' demo #'+msgid;
    } else {
        document.mailform.subject.disabled=false;
    }
  }

  // hide or show a div based on the value of another field
  function HideShowRelayServer() {
    if (document.mailform.sendmethod.value == "smtp") {
      document.mailform.relayserver.parentNode.parentNode.classList.remove('hidefield');
    } else {
      document.mailform.relayserver.parentNode.parentNode.classList.add('hidefield');
    }
  }

  function GoSend() {
      var table = document.getElementById("msglog");
      var row = table.insertRow(1);

      var NUMcell = row.insertCell(0);
      NUMcell.innerHTML = msgid++;

      var DATEcell = row.insertCell(1);
      var d = new Date();
      DATEcell.innerHTML = d.toLocaleTimeString();

      var TOcell = row.insertCell(2);
      TOcell.innerHTML = document.mailform.toemail.value;

      var FROMcell = row.insertCell(3);
      FROMcell.innerHTML = document.mailform.from.value;

      var SUBJECTcell = row.insertCell(4);
      SUBJECTcell.innerHTML = document.mailform.subject.value;

      var MESSAGEcell = row.insertCell(5);
      MESSAGEcell.innerHTML = document.mailform.message.value;

      var METHODcell = row.insertCell(6);
      if (document.mailform.sendmethod.value == "smtp") {
        METHODcell.innerHTML = document.mailform.relayserver.value;
      } else {
        METHODcell.innerHTML = document.mailform.sendmethod.value;
      }

      var NODEcell = row.insertCell(7);

      var RESULTcell = row.insertCell(8);
      RESULTcell.innerHTML = "<img height=\"24\" src=\"data:image/gif;base64,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\">";

      var postdata = "sendemail=1&toemail=" + document.mailform.toemail.value;
      postdata += "&from=" + document.mailform.from.value;
      postdata += "&subject=" + document.mailform.subject.value;
      postdata += "&sendmethod=" + document.mailform.sendmethod.value;
      postdata += "&relayserver=" + document.mailform.relayserver.value;
      postdata += "&message=" + encodeURIComponent(document.mailform.message.value).replace("%20", "+");
      var url = "<?= $_SERVER['PHP_SELF']; ?>";
      var request = new XMLHttpRequest();
      request.open("POST", url, true);
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      request.overrideMimeType("text/plain");
      request.onreadystatechange = function () {
        if (request.readyState == 4) {
          NODEcell.innerHTML = request.getResponseHeader("X-Node");
          if (request.responseText == "OK" || request.responseText == "FAIL") {
            RESULTcell.innerHTML = request.responseText;
          } else {
            if (request.status == 0) {
              RESULTcell.innerHTML = "ERR_EMPTY_RESPONSE";
            } else {
              RESULTcell.innerHTML = "HTTP/1.1 " + request.status + " " + request.statusText + "<br /><br />" + request.responseText;
            }
          }
        }
      }
      request.send(postdata);
    }
  </script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha384-xBuQ/xzmlsLoJpyjoggmTEz8OWUFM0/RC5BsqQBDX2v5cMvDHcMakNTNrHIW2I5f" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {
  // Handle form submission for MySQL test
    $('#mysqlForm').submit(function(e) {
    e.preventDefault(); // Prevent form submission
    var formData = new FormData($(this)[0]); // Get form data
    $.ajax({
    url: '<?php echo $_SERVER['PHP_SELF']; ?>',
    type: 'POST',
    data: formData,
    success: function(response) {
    // Parse JSON response
    var result = JSON.parse(response);
    // Check if there's an error
      if (result.error) {
        $('#mysqlResult').html('Error: ' + result.error); // Display error message
      } else {
        $('#mysqlResult').html(result.message); // Display success message
        }
      },
    error: function(xhr, status, error) {
     console.error(xhr.responseText);
                  $('#mysqlResult').html('An error occurred while processing the request.'); // Display generic error message
              },
              cache: false,
              contentType: false,
              processData: false
          });
      });

    $('#mssqlForm').submit(function(e) {
    e.preventDefault(); // Prevent form submission
    var formData = new FormData($(this)[0]); // Get form data
    $.ajax({
        url: '<?php echo $_SERVER['PHP_SELF']; ?>',
        type: 'POST',
        data: formData,
        success: function(response) {
            // Parse JSON response
            var result = JSON.parse(response);
            // Check if there's an error
            if (result.error) {
                $('#mssqlResult').html('Error: ' + result.error); // Display error message
            } else {
                $('#mssqlResult').html(result.message); // Display success message
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('#mssqlResult').html('An error occurred while processing the request.'); // Display generic error message
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

    // Handle form submission for uploading
    $('#uploadForm').submit(function(e) {
        e.preventDefault(); // Prevent form submission
        var formData = new FormData($(this)[0]); // Get form data
        console.log(formData); // Log form data
        $.ajax({
            url: '<?php echo $_SERVER['PHP_SELF']; ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#uploadResults').html(response); // Update upload results div
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Handle button click for cron test
    $('#cronForm button').click(function() {
        var action = $(this).val();
        $.post('', { cronAction: action }, function(response) {
            $('#cronResult').html(response); // Update cron result message
            if (response.includes('Cron set')) {
                $('#cronResult').append('<br>Checking cron status every 5 seconds...');
                // Start checking cron status periodically
                checkCronPeriodically();
            }
        });
    });

    // Function to check cron status periodically
    function checkCronPeriodically() {
        var totalTime = 0;
        var intervalId = setInterval(function() {
            totalTime += 5000; // Increment time by 5 seconds
            if (totalTime <= 120000) { // Check if total time is less than or equal to 120 seconds
                $.post('', { cronAction: 'checkCronStatus' }, function(response) {
                    if (response.includes('executed successfully')) {
                        $('#cronResult').html('Cron test successful');
                        clearInterval(intervalId);
                    } else if (totalTime >= 120000) {
                        $('#cronResult').html('Cron test failed after 120 seconds');
                        clearInterval(intervalId);
                    } else {
                        // Update cron result message if neither success nor failure
                        $('#cronResult').html(response);
                    }
                });
            } else {
                $('#cronResult').html('Cron test failed after 120 seconds');
                clearInterval(intervalId); // Stop checking if total time exceeds 120 seconds
            }
        }, 5000); // Check every 5 seconds
    }
});
</script>

</body>
</html>
