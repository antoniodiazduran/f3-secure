<?php

class MainController extends Controller {

    public function main_index(){
        $this->f3->set('page_head','Capture your data...');
        $this->f3->set('view','main.htm');
	echo \Template::instance()->render('welcome.htm');
    }

} // main class

?>
