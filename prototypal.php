<?php

/*
 * prototypal.php
 *
 * @software  Prototypal
 * @version   0.1.1-rc
 * @author    James Brumond
 * @created   13 July, 2010
 * @updated   13 July, 2010
 *
 * Copyright 2010 James Brumond
 * Dual licensed under MIT and GPL
 */

class Prototype {

	protected $owner = null;
	protected $prototype_chain = array();

	public function __set($name, $value) {
		$this->prototype_chain[$name] = $value;
	}
	
	public function &__get($name) {
		if (array_key_exists($name, $this->prototype_chain)) {
			return $this->prototype_chain[$name];
		} elseif (array_key_exists('prototype', $this->prototype_chain) && $this->prototype_chain['prototype']->$name) {
			return $this->prototype_chain['prototype']->$name;
		}
		return null;
	}
	
	public function __call($name, $args) {
		if (array_key_exists($name, $this->prototype_chain) && is_callable($this->prototype_chain[$name])) {
			return call_user_func_array($this->prototype_chain[$name], $args);
		} elseif (array_key_exists('prototype', $this->prototype_chain)
		&& $this->prototype_chain['prototype']->$name
		&& is_callable($this->prototype_chain['prototype']->$name)) {
			return call_user_func_array($this->prototype_chain['prototype']->$name, $args);
		}
		return null;
	}
	
	public function __construct($owner, $parent = null) {
		$this->owner = $owner;
		if ($parent !== null) {
			$this->prototype_chain['prototype'] =& $parent;
		}
	}

}

class ProtoObject {

	public static $prototype = null;
	
	public static function init_prototype() {
		if (self::$prototype === null) {
			$parent = (get_parent_class() === false || ! isset(parent::$prototype)) ? null : parent::$prototype;
			self::$prototype = new Prototype(get_called_class(), $parent);
		}
	}
	
	public function __construct() {
		if (self::$prototype === null) {
			$parent = (get_parent_class() === false || ! isset(parent::$prototype)) ? null : parent::$prototype;
			self::$prototype = new Prototype(get_called_class(), $parent);
		}
	}
	
	public function &__get($name) {
		if ($name == 'prototype') {
			return self::$prototype;
		} elseif (self::$prototype->$name) {
			return self::$prototype->$name;
		} else {
			return null;
		}
	}
	
	public function __call($name, $args) {
		array_unshift($args, $this);
		return self::$prototype->$name($args);
	}

}

?>
