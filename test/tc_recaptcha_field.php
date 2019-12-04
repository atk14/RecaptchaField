<?php
class TcRecaptchaField extends TcBase {

	function test(){
		$this->field = new RecaptchaField(array());

		$err = $this->assertInvalid("");
		$this->assertEquals("Please try to solve the test. It is important for us to be sure that we are communicating with a human.",$err);
	}
}
