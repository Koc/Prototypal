<?php

require "prototype.php";

header("Content-Type: text/plain");

class B extends ProtoObject {

	public static $prototype = null;
	
	public function __construct() {
		parent::__construct();
	}
	
}

$a = new ProtoObject();
$b = new B();

$a->prototype->test = function($self) {
	var_dump($self);
};

$b->test();

?>
