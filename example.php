<?php

require "prototype.php";



class A extends ProtoObject {

	public static $prototype = null;
	
	public function __construct() {
		parent::__construct();
	}
	
}



class B extends A {

	public static $prototype = null;
	
	public function __construct() {
		parent::__construct();
	}
	
}



$a = new A(); $b = new B();

$a->prototype->test = 'Hello World!';

echo $b->test;   // outputs: Hello World!



?>
