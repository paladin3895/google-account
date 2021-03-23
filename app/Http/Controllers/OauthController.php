<?php

namespace App\Http\Controllers;

use App\Http\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class OauthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function oauth(Request $request, $type)
    {
        return Socialite::driver($type)->redirect();
    }

    public function callback(Request $request, $type)
    {
        $user = Socialite::driver($type)->user();
        $user = User::updateOrCreate([
            'email' => $user->getEmail(),
        ], [
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'oauth_id' => $user->getId(),
            'photo' => $user->getAvatar(),
        ]);

        Auth::login($user);
        return redirect(route('home'));
    }
}
