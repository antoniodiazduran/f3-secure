<?php

class Controller {

    protected $f3;
    protected $db;
    protected $d1;
    protected $rev;
    protected $aev;
    protected $sales;
    protected $dmz;

    function __construct() {
        $f3=Base::instance();

	// Enabling saving data to sqlite
	$db = new DB\SQL('sqlite:data/enc.sqlite');
	$d1 = new DB\SQL('sqlite:data/global.sqlite');
	//$rev = new DB\SQL('sqlite:data/rev.sqlite');
	//$aev = new DB\SQL('sqlite:data/aev.sqlite');
	//$sales = new DB\SQL('sqlite:data/sales.sqlite');

        // De-Militirizaed Zone for public pages
	$dmz = array('/mat/screen','/mat/receiving','/sf');

	$this->dmz=$dmz;
	$this->f3=$f3;
	$this->db=$db;
	$this->d1=$d1;
	//$this->rev=$rev;
	//$this->aev=$aev;
	//$this->sales=$sales;

        $f3->set('CACHE','folder=/var/tmp/f3filescache/');

    }

//  *****************************
//  Secure Before and After route
//  *****************************

     function beforeRoute() {
     }

    function afterRoute() {
      if ($this->f3->get('SECURE')) {
          if($this->f3->get('SESSION.user') === null) {
echo "u";
             $this->f3->set('SESSION.bp_id', null);
          //   echo \Template::instance()->render($this->f3->get('layout'));
          }
          if($this->f3->get('SESSION.timeout') < time()) {
echo "t";
             echo $this->f3->set('SESSION.user',null);
	  }

        // Setting up the page parameters
/*        $this->f3->set('isMobile',$this->isMobile());
        $this->f3->set('layout','layout.htm');
        $this->f3->set('content','auth/login.htm');
*/
        // Refresh timer on every click
        date_default_timezone_set('America/New_York');
        $this->f3->set('SESSION.timeout', time()+$this->f3->get('expire'));
        $this->f3->set('SESSION.timeoutdate',date('Y.m.d h:i:s',time()+$this->f3->get('expire')) );
      }

/*      if ($this->f3->get('SECURE')) {
        if($this->f3->get('SESSION.user') != null ) {
          if ( $this->f3->get('SESSION.ip') === $this->f3->ip() ) {
	     //$this->f3->reroute('/login');
  	     //echo \Template::instance()->render($this->f3->get('layout'));
  	     echo \Template::instance()->render('layout.htm');
          } else {
             echo "Session Terminated..".$this->f3->get('SESSION.ip');
          }
        }
      } else {
	//echo \Template::instance()->render($this->f3->get('layout')); 
      }
*/
        echo  "a";
        echo \Template::instance()->render($this->f3->get('layout'));
    }


//  ****************************

    function xbeforeRoute() {

    }

    function xafterRoute() {
	// Testing array in config file
	//echo "w".$this->f3->get('DMZ.2');
	foreach ($this->dmz as $key=>$page) { 
	  //echo "w".$page;
	}
	echo \Template::instance()->render($this->f3->get('layout'));
    }

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
