<?php

class MainController extends Controller {

    public function index(){
        $this->f3->set('layout','layout.htm');
        $this->f3->set('content','main.htm');
	echo \Template::instance()->render($this->f3->get('layout'));
    }

} // main class

?>
