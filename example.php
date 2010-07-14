<?php

require "prototypal.php";



class A extends ProtoObject {
	
	public function __construct() {
		ProtoObject::__construct();
	}
	
}



class B extends A {
	
	public function __construct() {
		ProtoObject::__construct();
	}
	
}



$a = new A(); $b = new B();

$a->prototype->test = 'Hello World!';

echo $b->test;   // outputs: Hello World!



?>
