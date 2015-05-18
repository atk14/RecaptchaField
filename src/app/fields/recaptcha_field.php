<?php
// The following constants must be defined
//define("RECAPTCHA_SITE_KEY","fksjfu2094389SAKJDPOSAIIaskalkslamcbuyid");
//define("RECAPTCHA_SECRET_KEY","pwofe994883eiDJKHFISIYTTSSSSSkfdt7poieqnx");

class RecaptchaField extends CharField{
	function __construct($options = array()){
		$options = array_merge(array(
			"widget" => new RecaptchaWidget()
		),$options);
		parent::__construct($options);
		$this->update_messages(array(
			"required" => _("Please try to solve the test. It is important for us to be sure that we are communicating with a human."),
			"invalid" => _("The test was not successful. Please try it aganin."),
			"service_unavailable" => _("We are experiencing some technical issue during the communication with Google. Please try it later."),
		));

		if(!defined("RECAPTCHA_SITE_KEY") || !defined("RECAPTCHA_SECRET_KEY")){
			die ("To use RecaptchaField you must define RECAPTCHA_SITE_KEY and RECAPTCHA_SECRET_KEY as it is mentioned on https://github.com/atk14/RecaptchaField");
		}
	}

	function clean($value){
		list($error,$value) = parent::clean($value);
		if($error || !$value){
			return array($error,$value);
		}

		$request = &$GLOBALS["HTTP_REQUEST"];

		$response = trim($request->getPostVar("g-recaptcha-response"));
		if(strlen($response)==0){
			return array($this->messages["required"],null);
		}

		$uf = new UrlFetcher(sprintf("https://www.google.com/recaptcha/api/siteverify?secret=%s&response=%s&remoteip=%s",urlencode(RECAPTCHA_SECRET_KEY),urlencode($response),urlencode($request->getRemoteAddr())));
		if(!$uf->found()){
			return array($this->messages["service_unavailable"],null);
		}

		$data = json_decode($uf->getContent(),true); // { "success": true }
		if(!$data){
			return array($this->messages["service_unavailable"],null);
		}

		if($data["success"]!==true){
			return array($this->messages["invalid"],null);
		}
		return array(null,"ok");
	}
}
