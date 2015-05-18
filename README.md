RecaptchaField
==============

An ATK14 form field for protecting your forms agains spam.

It uses https://www.google.com/recaptcha/intro/index.html

Installation
------------

Just use the Composer:

```bash
cd path/to/your/atk14/project/
composer require atk14/recaptcha-field dev-master
```

You must define two constants in config/settings.php. Get their right values at https://www.google.com/recaptcha/admin#list

```php
<?php
// file: config/settings.php

// ...
define("RECAPTCHA_SITE_KEY","fksjfu2094389SAKJDPOSAIIaskalkslamcbuyid");
define("RECAPTCHA_SECRET_KEY","pwofe994883eiDJKHFISIYTTSSSSSkfdt7poieqnx");
```

Usage in a form
---------------

```php
<?php
// file: app/forms/users/create_new_form.php
class CreateNewForm extends ApplicationForm{
	function set_up(){
		$this->add_field("captcha",new RecaptchaField(array(
			"label" => "Spam protection"
		)));
	}

	function clean(){
		list($err,$values) = parent::clean();

		// perhaps you may not want to have "spam" in the cleaned data
		if(isset($values["spam"])){ unset($values["spam"]); }

		return array($err,$values);
	}
}
```
