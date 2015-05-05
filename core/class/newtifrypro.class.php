<?php
/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';


function iso8601() {
  // Suppress DateTime warnings
  date_default_timezone_set(@date_default_timezone_get());
  $time=time();
  // strange iso8601 formating for newtifry pro
  return gmdate("Y-m-d", $time) . 'T' . gmdate("H:i:s", $time) .'.00:00';
}

function newtifryProPush( $apikey,
                          $deviceIds,  
                          $title, 
                          $source = NULL, 
                          $message = NULL) {
  //Prepare variables
  $GCM_URL = "https://android.googleapis.com/gcm/send";
  $data = array ( "type" => "ntp_message",
                  "timestamp" => iso8601(),
                  "priority" => 0, 
                  "title" => base64_encode($title));

  if ($message) {
    $data["message"] = base64_encode($message);
  }
  if ($source) {
    $data["source"] = base64_encode($source);
  }

  $fields = array(  'registration_ids'  => $deviceIds,
                    'data'              => $data);

  $headers = array( 'Authorization: key=' . $apikey,
                    'Content-Type: application/json');

  // Open connection
  $ch = curl_init();
  // Set the url, number of POST vars, POST data
  curl_setopt( $ch, CURLOPT_URL, $GCM_URL );
  curl_setopt( $ch, CURLOPT_POST, true );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );

  // Execute post
  $result = curl_exec($ch);
  // Close connection
  curl_close($ch);
  //Return push response as array
  return json_decode($result);
}

class newtifrypro extends eqLogic {
    
}

class newtifryproCmd extends cmd {
    public function preSave() {
		$newtifrypro = $this->getEqLogic();
        if ($newtifrypro->getConfiguration('apikey') == '') {
            throw new Exception('Api_Key ne peut etre vide');
        }
        if ($this->getConfiguration('devid') == '') {
            throw new Exception('Dev_id ne peut etre vide');
        }        
    }

    public function execute($_options = null) {
        if ($_options === null) {
            throw new Exception(__('Les options de la fonction doivent être définis', __FILE__));
        }
        if ($_options['title'] == '') {
            throw new Exception(__('Le message et le sujet ne peuvent être vide', __FILE__));
        }
        if ($_options['title'] == '') {
            $_options['title'] = NULL;
        }
        
        $deviceIds = array();
        $deviceIds[] = $this->getConfiguration('devid');
        $result = newtifryProPush(    $this->getEqLogic()->getConfiguration('apikey'),
                            $deviceIds, 
                            $_options['title'], 
                            'Jeedom Notification', 
                            $_options['message']);
    }
}

?>