<?php

class Controller {

    protected $f3;
    protected $db;
    protected $d1;
    protected $dmz;
    protected $url;

    function __construct() {
        $f3=Base::instance();

	// Enabling saving data to sqlite
	$db = new DB\SQL('sqlite:data/enc.sqlite');
	$d1 = new DB\SQL('sqlite:data/global.sqlite');

        // De-Militirizaed Zone for public pages
	//$dmz = array('/mat/screen','/mat/receiving','/sf');

	//$this->dmz=$dmz;
	$this->f3=$f3;
	$this->db=$db;
	$this->d1=$d1;

        $f3->set('CACHE','folder=/var/tmp/f3filescache/');

    }

//  *****************************
//  Secure Before and After route
//  *****************************

     function beforeroute() {
    if ($this->f3->get('SECURE')) {
	if($this->f3->get('SESSION.user') === NULL ) {
		echo "u_null:";
		$this->f3->reroute('/login');
		exit;
	}
	if($this->f3->get('SESSION.timeout') < time()) {
		echo "s_time:";
		$this->f3->set('SESSION.user',NULL);
		$this->f3->set('SESSION.bp_id',NULL);
		$this->f3->reroute('/login');
		exit;
	}

        // Refresh timer on every click
        date_default_timezone_set('America/New_York');
        $this->f3->set('SESSION.timeout', time()+$this->f3->get('expire'));
        $this->f3->set('SESSION.timeoutdate',date('Y.m.d h:i:s',time()+$this->f3->get('expire')) );

      }

     }

     function afterroute() {
	$this->f3->set('stat','after');
	echo \Template::instance()->render($this->f3->get('layout'));
    }


//  ****************************

    function GSheetsInsert($sheetid,$row,$fileid) {
                //require '/home/antoniodiazduran/vendor/autoload.php';
                $client = Google_Spreadsheet::getClient('data/credentials.json');
                // Get the sheet instance by sheets_id and sheet name (antoniodiazduran)
                $sheet = $client->file($fileid)->sheet($sheetid);
		// Inserting data into Google Sheet
		$sheet->insert($row);
                // Fetch data from remote (or cache)
                //$sheet->fetch();
                // Return all rows in the sheet
                return $sheet->fetch(true)->items;
    }
    function GSheetsRead($sheetid,$fileid) {
                //require '/home/antoniodiazduran/vendor/autoload.php';
                $client = Google_Spreadsheet::getClient('data/credentials.json');
                // Get the sheet instance by sheets_id and sheet name (antoniodiazduran)
                $sheet = $client->file($fileid)->sheet($sheetid);
                // Fetch data from remote (or cache)
                $sheet->fetch();
                // Return all rows in the sheet
                return $sheet->items;
    }

    public function isMobile()  {
         return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    public function sendMail($to,$msg) {
      // In case any of our lines are larger than 70 characters, we should use wordwrap()
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $to = 'antonio.diazduranborja@revgroup.com,'.$to;
      $msg = wordwrap($msg, 300, "<br/>");
      // Send - to, subject, message
      $bool = mail($to,'Engineering owner/priority change', $msg, $headers);
    }

}

?>
