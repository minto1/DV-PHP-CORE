<?php

namespace App\Helpers;

use Hash;
use Session;
use App\User;
use App\Helpers\Jwt as jwt;

trait auth
{
    /**
     * Hash password.
     *
     * @param type $password
     *
     * @return string
     *
     * @internal param type $hash
     * @internal param array $rules
     */
    public static function password_hash($password)
    {
        return Hash::make($password);
    }

    /**
     * compare password hash.
     *
     * @param string $user_input
     * @param string $hash
     *
     * @return bool
     */
    public static function compare_hash($user_input, $hash)
    {
        return Hash::check($user_input, $hash);
    }

    /**
     * Check if current user is admin.
     *
     * @return mixed
     */
    public static function is_admin_login()
    {
        return (Session()->has('user')) ? true : false;
    }

    /**
     * Get authenticated user cred.
     *
     * @param $force_auth
     *
     * @return array
     */
    public static function get_authenticated_user_cred($force_auth)
    {
        $user_token = request()->header('devless-user-token');
        $user_cred = [];

        if (self::is_admin_login() && $force_auth == true) {
            $admin = User::where('role', 1)->first();
            $user_cred['id'] = $admin->id;
            $user_cred['token'] = 'non for admin';
        } elseif ($user_token != null && $user_token != 'null' &&
                ($force_auth == true || $force_auth == false)) {
            $user_data = self::verify_user_token($user_token);

            if (isset($user_data->id)) {
                $user_cred =
                    [
                        'id' => $user_data->id,
                        'token' => $user_data->session_token,

                    ];
            } else {
                self::interrupt(628, null, [], true);
            }
        } elseif ($force_auth == true) {
            self::interrupt(628, null, [], true);
        }

        return $user_cred;
    }

    /**
     * Verify user token.
     *
     * @param $user_token
     *
     * @return mixed
     */
    public static function verify_user_token($user_token)
    {
        $secret = config('app')['key'];

        $jwt = new jwt();

        $jwt_payload = json_decode($jwt->decode($user_token, $secret, true));

        if ($user_token == 'null') {
            Self::interrupt(633, null, [], true);
        }
        $user_data = User::where('session_token', $jwt_payload->token)
               ->first();
        if ($user_data !== null) {
            $d1 = new \DateTime($user_data->session_time);
            $d2 = new \DateTime();
            $interval = $d1->diff($d2);

            if ($interval->h >= 1 || $interval->days > 0) {
                $user_data->session_token = '';
                $user_data->save();
                Self::interrupt(633, null, [], true);
            }

            $user_data->session_time = self::session_timestamp();
            $user_data->save();
        }

        return $user_data;
    }
}
