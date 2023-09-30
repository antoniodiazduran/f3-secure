<?php

class MainController extends Controller {

    public function index(){
        $this->f3->set('layout','layout.htm');
	$this->f3->set('msg','Welcome '.$this->f3->get('SESSION.user')	);
        $this->f3->set('content','welcome.htm');
        $this->f3->set('isMobile',$this->isMobile());
//	echo \Template::instance()->render($this->f3->get('layout'));
    }

} // main class

?>
