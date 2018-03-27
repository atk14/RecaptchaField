RecaptchaField
==============

An ATK14 form field for protecting your forms against spam.

It uses https://www.google.com/recaptcha/intro/index.html

Installation
------------

Just use the Composer:

    cd path/to/your/atk14/project/
    composer require atk14/recaptcha-field

    ln -s ../../vendor/atk14/recaptcha-field/src/app/fields/recaptcha_field.php app/fields/recaptcha_field.php

You must define two constants in config/settings.php. Get their right values at https://www.google.com/recaptcha/admin#list

    <?php
    // file: config/settings.php

    // ...
    define("RECAPTCHA_SITE_KEY","fksjfu2094389SAKJDPOSAIIaskalkslamcbuyid");
    define("RECAPTCHA_SECRET_KEY","pwofe994883eiDJKHFISIYTTSSSSSkfdt7poieqnx");

Usage in a form
---------------

    <?php
    // file: app/forms/users/create_new_form.php
    class CreateNewForm extends ApplicationForm{

      function set_up(){
        $this->add_field("firstname", new CharField([
          "label" => "Firstname",
          "max_length" => 200,
        ]));

        $this->add_field("lastname", new CharField([
          "label" => "Lastname",
          "max_length" => 200,
        ]));

        // other fields

        $this->add_field("captcha",new RecaptchaField([
          "label" => "Spam protection"
        ]));
      }

      function clean(){
        list($err,$values) = parent::clean();

        // perhaps you may not want to have "captcha" in the cleaned data
        if(is_array($values)){ unset($values["captcha"]); }

        return [$err,$values];
      }
    }

Example of usage
----------------

The RecaptchaField is used in the [registration form](http://forum.atk14.net/en/users/create_new/) on [ATK14 Forum](http://forum.atk14.net/) for instance.

License
-------

UrlField is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)
