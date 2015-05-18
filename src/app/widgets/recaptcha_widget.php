<?php
class RecaptchaWidget extends Widget{
	function render($name, $value, $options = array()){
		$out = array();
		$out[] = '<script src="https://www.google.com/recaptcha/api.js"></script>'; // TODO: Paste this snippet before the closing </head> tag on your HTML template:
		$out[] = '<div style="float: left; min-height: 80px;">'; // TODO: Do I like the inline style?
		$out[] = '<div class="g-recaptcha" data-sitekey="'.RECAPTCHA_SITE_KEY.'"></div>';
		$out[] = '</div>';
		$out[] = '<div style="clear: both;"></div>';

		// This is a fake hidden field which makes the Form framework in thinking that the value is submitted as usually.
		// It is important for the Field::clean() method.
		$out[] = sprintf('<input type="hidden" name="%s" value="sent">',$name);

		return join("\n",$out);
	}
}
