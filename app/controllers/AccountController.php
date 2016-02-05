<?php

class AccountController extends \BaseController
{
    public function index()
    {
        return View::make('account.sign-in');
    }

    public function signUp()
    {
        return View::make('account.sign-up');
    }

    public function createAccount()
    {
        $validator = Validator::make($data = Input::all(), User::$rules);

        if ($validator->fails()) {

            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['role'] = Input::get('user_role');
        $data['country_id'] = Input::get('country');
        $data['password'] = Hash::make($data['password']);
        $data['code'] = str_random(60); //Activation code

        $user = User::create($data);
        if ($user) {

            $data['user_id'] = $user->id;

            if ($data['role'] == 'Agent') {
                $data['market_id'] = Market::where('market', 'All Market')->first()->id;
                $role = Role::where('name', $data['role'])->first();

                $user->attachRole($role);
                Agent::create($data);

                Mail::send('emails.auth.signup', array('first_name' => $data['first_name'], 'role' => $data['role']), function ($massage) use ($user) {
                    $massage->to($user->email, $user->first_name)
                        ->subject('Thank You for Signing Up');
                });

                Mail::send('emails.auth.signup', array('first_name' => $data['first_name'], 'role' => $data['role']), function ($massage) use ($user) {
                    $massage->to('tharinda@exotic-intl.com', 'Tharinda')
                        ->subject('Thank You for Signing Up');
                });

                Session::flash('global', 'Thank you for signing up with us as an ' . $data['role'] . '. We will contact you within 24 hours');
                return View::make('pages.message');
            }

            if ($data['role'] == 'Hotelier') {
                Mail::send('emails.auth.signup', array('first_name' => $data['first_name'], 'role' => $data['role']), function ($massage) use ($user) {
                    $massage->to($user->email, $user->first_name)
                        ->subject('Thank You for Signing Up');
                });

                Session::flash('global', 'Thank you for signing up with us as an ' . $data['role'] . '. We will contact you within 24 hours');
                return View::make('pages.message');
            }

            // send email

            Mail::send('emails.auth.activate', array('link' => URL::to('account/activate', $data['code']), 'first_name' => $data['first_name']), function ($massage) use ($user) {
                $massage->to($user->email, $user->first_name)->subject('Activate your account');
            });

            Session::flash('global', 'Your account has been created! We have sent you an email to activate your account');

            return View::make('pages.message');

        }

        return 'There was an error';

    }

    public function activateAccount($code)
    {
        $user = User::where('code', '=', $code)->where('active', '=', 0)->first();
        if ($user) {

            $user->active = 1;
            $user->code = '';

            if ($user->save()) {
                Session::flash('global', 'Your account is activated..! Now you can sign in..!');
                return View::make('account/lo');
            }
        }

        Session::flash('global', 'Unable to activate your account.. please try again later');
        return View::make('pages.message');
    }

    public function getSignIn()
    {
        return View::make('account.sign-in');
    }

    public function  signIn()
    {


        $validator = Validator::make(Input::all(),

            array(
                'email' => 'required|email',
                'password' => 'required',
            )
        );

        if ($validator->fails()) {
            //dd($validator->errors());
            //Redirect to the sign in page
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();

        } else {

//            dd('asdasd');


            $remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt(array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'active' => 1
            ), $remember);

            //self::writeLog('Sign In: ' . date('Y-m-s H:i:s') . ' User ID: ' . Auth::id(), '- from' . Request::getClientIp());

            if ($auth) {

                if (Entrust::hasRole('Agent')) {
                    $agent = User::find(Auth::id())->agent()->first();
                    Session::put('market', $agent->market_id);

                }

                return Redirect::intended('/reservations');

            } else {
                return Redirect::back()
                    ->with('global', 'check your username and password');
            }

        }

    }

    public function sendActivationCode($id)
    {
        $user = User::find($id);
        $mail = Mail::send('emails.auth.activate', array('link' => URL::to('account/activate', $user->code), 'first_name' => $user->first_name), function ($massage) use ($user) {
            $massage->to($user->email, $user->first_name)
                ->subject('Activate your account');
        });


        Session::flash('global', 'Email Sent to <b>' . $user->email . '</b>');
        return Redirect::back();

    }

    public function getSignOut()
    {
        Session::forget('market');
        //Session::forget();
        self::writeLog('Sign Out: ' . date('Y-m-s H:i:s') . ' User ID: ' . Auth::id() . '- from: ' . Request::getClientIp());
        Auth::logout();
        return Redirect::to('account/sign-in');
    }

    public function profileActive()
    {
        return View::make('pages.message');
    }

    public function getActivationEmail()
    {
        Session::flash('global', 'Your account has been created! We have sent you an email to activate your account');
        return View::make('pages.message');
    }

    public function updateProfile()
    {
        $validator = Validator::make(Input::all(),

            array(
                'first_name' => 'max:50',
                'last_name' => 'max:50',
                'current_password' => 'required',
                'new_password' => 'min:6',
                'password_again' => 'same:new_password',
            )
        );

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator);
        } else {

            $user = User::find(Auth::user()->id);

            $first_name = Input::get('first_name');
            $last_name = Input::get('last_name');
            $old_password = Input::get('current_password');
            $password = Input::get('new_password');

            if (Hash::check($old_password, $user->getAuthPassword())) {


                $user->password = Hash::make($password);

                if ($first_name) {
                    $user->first_name = $first_name;
                }
                if ($last_name) {
                    $user->last_name = $last_name;
                }

                if ($user->save()) {
                    Session::flash('global', 'Your credentials have been updated');
                    Auth::logout();
                    return Redirect::back();

                }

                return Redirect::route('profile-edit-user-post')
                    ->with('global', 'please check again');
            }
            return Redirect::back()
                ->with('wrong-password', 'Your password is wrong');
        }

    }

    public function getForgotPassword()
    {
        return View::make('account.forgot');
    }

    public function postForgotPassword()
    {

        $validator = Validator::make(Input::all(),

            array(
                'email' => 'required|email'
            )
        );

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {

            $user = User::where('email', '=', Input::get('email'));

            if ($user->count()) {

                $user = $user->first();

                // Generate a new code and password
                $code = str_random(60);
//                $password = str_random(10);

                $user->code = $code;
                //$user->password_temp = Hash::make($password);

                if ($user->save()) {
                    Mail::send('emails.auth.forgot', array('link' => URL::to('account/recover', $code), 'first_name' => $user->first_name), function ($message) use ($user) {
                        $message->to($user->email, $user->first_name)->subject('Acount Recovery Request');
                    });

                    Session::flash('global', 'we have sent you an email');
                    return View::make('pages.message');
                }
            }
        }

        return Redirect::route('account-forgot-password')
            ->with('global', 'Could not request new password');
    }

    public function recoverAccount($code)
    {
        $user = User::where('code', '=', $code);

        if ($user->count()) {

            //dd($user->first());

            Session::put('my-account', $user->first());

            return View::make('account.recover',compact('code'));


        }

        return App::abort(404);
    }

    public function postRecoverPassword($code)
    {
//        dd($code);

        if (Session::has('my-account')) {
            $user = Session::pull('my-account');
            if ($user->code == $code) {

                $input = Input::all();

                $validator = Validator::make(Input::all(), array(
                    'password' => 'min:6',
                    'confirm_password' => 'same:password',
                ));
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator);
                }

                $user->password = Hash::make($input['password']);
                $user->code = '';

                if ($user->save()) {
                    Session::flash('global', 'Your account has been recovered and you can sign in with your new password');
                    return View::make('pages.message');
                }

                return Redirect::route('account/sign-in')
                    ->with('global', 'Could not recover your account.');
            }
        }

        return Redirect::route('account/sign-in')
            ->with('global', 'Could not recover your account.');

    }

    public function activateUser($id)
    {
        $user = User::find($id);
        $user->active = 1;
        $user->save();
        return Redirect::back();
    }

    public function deactivateUser($id)
    {
        $user = User::find($id);
        $user->active = 0;
        $user->save();
        return Redirect::back();

    }

    private function writeLog($content)
    {
        File::append(public_path() . '/user-log.txt', $content . "\n");
    }

    public function getChangePassword()
    {
        return View::make('account.profile.change-password');
    }

    public function changePassword()
    {
        $this->updateProfile();
    }


}
