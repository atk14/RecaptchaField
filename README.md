RecaptchaField
==============

RecaptchaField is a field for protecting forms against spam in ATK14 applications.

It uses reCAPTCHA v2 from Google (see https://www.google.com/recaptcha/intro/index.html)

Installation
------------

Just use the Composer:

    cd path/to/your/atk14/project/
    composer require atk14/recaptcha-field

You must define two constants in config/settings.php. Get their right values at https://www.google.com/recaptcha/admin#list

    <?php
    // file: config/settings.php

    // ...
    define("RECAPTCHA_SITE_KEY","fksjfu2094389SAKJDPOSAIIaskalkslamcbuyid");
    define("RECAPTCHA_SECRET_KEY","pwofe994883eiDJKHFISIYTTSSSSSkfdt7poieqnx");

Optionally you can symlink the RecaptchaField files into your project:

    ln -s ../../vendor/atk14/recaptcha-field/src/app/fields/recaptcha_field.php app/fields/recaptcha_field.php
    ln -s ../../vendor/atk14/recaptcha-field/src/app/widgets/recaptcha_widget.php app/widgets/recaptcha_widget.php

Usage in a ATK14 application
----------------------------

In a form:

    <?php
    // file: app/forms/users/create_new_form.php
    class CreateNewForm extends ApplicationForm {

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

In a template (a shared template from the [Atk14Skelet](https://github.com/atk14/Atk14Skelet) is used):

    <h1>User Registration</h1>

    {form}

      <fieldset>
        {render partial="shared/form_field" fields="firstname,lastname,..."}
      </fieldset>

      <fieldset>
        {render partial="shared/form_field" fields="captcha"}
      </fieldset>

      <button type="submit">Register</button>

    {/form}

In a controller:

    <?php
    // file: app/controllers/users_controller.php
    class UsersController extends ApplicationController {
      
      function create_new(){
        if($this->request->post() && ($values = $this->form->validate($this->params))){
          // There's no need to care about the $values["captcha"] since it was unset in CreateNewForm::clean()
          User::CreateNewRecord($values);
          $this->flash->success("Your registration has been successfully performed");
          $this->_redirect_to("main/index");
        }
      }
    }

Example of usage
----------------

The RecaptchaField is used in the [registration form](http://forum.atk14.net/en/users/create_new/) on [ATK14 Forum](http://forum.atk14.net/) for instance.

License
-------

RecaptchaField is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)
