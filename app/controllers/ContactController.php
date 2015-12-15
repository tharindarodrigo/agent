<?php

class ContactController extends BaseController
{

    public function message()
    {
        return View::make('account.user');
    }

    public function getContact()
    {
        return View::make('pages.contact');
    }

    public function postContact()
    {
        require_once(public_path().'/recaptcha/recaptchalib.php');
        $private_key = "6LeqigQTAAAAAG8dmp7aH1HuPeJqB3lfJ_Fjx3xw";
        $resp = recaptcha_check_answer($private_key,
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid) {
            // What happens when the CAPTCHA was entered incorrectly
            return Redirect::route('get-contact')
                ->with('global', 'Human user verification did not match. Try again!');

        } else {
            // Your code here to handle a successful verification

            $validator = Validator::make(Input::all(),

                array(
                    'name' => 'required|max:50',
                    'email' => 'required|email',
                    'comments' => 'required',
                    'phone' => 'numeric'
                )
            );

            if ($validator->fails()) {

                return Redirect::route('get-contact')
                    ->withInput()
                    ->withErrors($validator);

            } else {

                $name = Input::get('name');
                $email = Input::get('email');
                $phone = Input::get('phone');
                $comments = Input::get('comments');

                Mail::send('emails.contact', array('name' => $name, 'email' => $email, 'comments' => $comments), function ($message) use ($name, $email, $comments, $phone) {

                    $message->from($email, $name);

                    $message->to('info@srilankahotels.travel', 'Thilina Herath')->subject('Contact us emails');

                });

                // Redirect to page
                return Redirect::route('default-message')
                    ->with('global', 'Your message has been sent. Thank You!');
            }
        }
    }

}