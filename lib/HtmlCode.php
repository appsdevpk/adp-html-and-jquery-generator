<?php
class HtmlCode{
	private $elementsList = array();
	private $stylePos  = 'footer';
	
	public function __construct($stylePos='footer'){
		$this->stylePos = $stylePos;
	}
	public function parseJson($jsonCode){
		foreach($jsonCode as $obj){
			foreach($obj as $key=>$val){
				if(!is_array($val)){
					$this->$key($val);
				}else{
					if(isset($val['attribs'])){
						$this->$key($val['attribs']);
					}else{
						$this->$key();
					}
					foreach($val as $k=>$v){
						if($k!='attribs'){
							$this->$k($v);
						}
					}
				}
			}
		}
		return $this;
	}
	public function output(){
		$stylesList = array();
		
		$output = "<!DOCTYPE HTML><html>";
		$haveHeader = false;
		
		foreach($this->elementsList as $currElement){
			$parameters = isset($currElement[1][0]) ? $currElement[1][0] : '';
			$paramsList = array();
			$params = "";
			$currStyle = '';
			$currSelector = '';
			
			if(is_array($parameters)){
				foreach($parameters as $key=>$val){
					if($key=='styleSelector'){
						$currSelector .= $val;
					}elseif($key=='style'){
						$styleVals = array();
						foreach($val as $k=>$v){
							$styleVals[] = $k.':'.$v;
						}
						$currStyle = implode(';',$styleVals);
					}elseif($key=='optimize'){
						//code to be done
					}else{
						$paramsList[] = $key.'="'.$val.'"';
					}
				}
				$params = " ".implode(" ",$paramsList);
			}
			
			
			
			$nameParts = explode("_",$currElement[0]);
			
			if($currSelector=='' && $currStyle!=''){
				$params .= ' style="'.$currStyle.'"';
			}elseif($currSelector!='' && $currStyle!=''){
				$stylesList[$currSelector] = $currStyle;
			}
			
			if(count($nameParts) > 1){
				if($nameParts[1]=='start'){
					$output .= '<'.$nameParts[0].$params.'>';
					if($nameParts[0]=='head'){
						$haveHeader = true;
					}
				}elseif($nameParts[1]=='end'){
					if($nameParts[0]=='head'){
						$output .= '[adpcsscontentHead]';
					}
					if($nameParts[0]=='body'){
						$output .= '[adpcsscontentFooter]';
					}
					$output .= '</'.$nameParts[0].'>';
				}
			}else{
				if($nameParts[0]=='contents'){
					$output .= $currElement[1][0];
				}else{
					$output .= '<'.$nameParts[0].$params.' />';
				}
			}
		}
		$cssCode = '<style>';
		if(count($stylesList) > 0){
			foreach($stylesList as $sKey=>$sVal){
				if($sKey=='' || $sVal==''){
					continue;
				}
				$cssCode .= $sKey.'{ '.$sVal.' }';
			}
		}
		$cssCode .= '</style>';
		
		if($haveHeader && $this->stylePos=='head'){
			$output = str_ireplace('[adpcsscontentHead]',$cssCode,$output);//replace with css code
			$output = str_ireplace('[adpcsscontentFooter]','',$output);
		}else{
			$output = str_ireplace('[adpcsscontentHead]','',$output);
			$output = str_ireplace('[adpcsscontentFooter]',$cssCode,$output);//replace with css code
		}
		$output .= '</html>';
		return $output;
	}
	public function __call($name, $arguments){
		$this->elementsList[] = array($name,$arguments);
		return $this;
	}
}