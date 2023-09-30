<?php
class jQuery{
	private $selector;
	private $methodsList = array();
	
	public function __construct($selector){
		$this->selector = $selector;
	}
	public function output(){
		$output = "jQuery(".$this->selector.")";
		foreach($this->methodsList as $currMethod){
			$parameters = $currMethod[1];
			$paramsList = array();
			foreach($parameters as $param){
				if(is_callable($param)){
					$paramFunc = 'function(){';
					$paramFunc .= $param();
					$paramFunc .= '}';
					$paramsList[] = $paramFunc;
				}else{
					$paramsList[] = "'".$param."'";
				}
			}
			$params = implode(",",$paramsList);
			
			$output .= '.'.$currMethod[0].'('.$params.')';
		}
		$output .= ';';
		return $output;
	}
	public function __call($name, $arguments){
		$this->methodsList[] = array($name,$arguments);
		return $this;
	}
}