<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\URL;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use App\Adapters\GoogleAdapter;
use App\Models\User;
use App\Models\Credential;
use App\Http\Resources\ContentResource;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class OauthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->user = $auth->user();
    }


    public function oauth(Request $request, $type)
    {
        $adapter = $this->getAdapter($type);
        $redirectUrl = url("/oauth/{$type}/callback");

        $state = [
            'redirect_uri' => $redirectUrl,
        ];

        $authUrl = $adapter->getAuthUrl($redirectUrl, $state);
        return redirect($authUrl);
    }

    public function callback(Request $request, $type)
    {
        $adapter = $this->getAdapter($type);
        $authCode = $request->get('code');
        $state = $adapter->deserialize($request->get('state')) ?? [];

        $credential = $adapter->createCredential($authCode, (array)$state);
        $credential = Credential::updateOrCreate(
            array_only($credential->toArray(), ['type', 'user_id']),
            array_except($credential->toArray(), ['user_id'])
        );

        if ($state['referer']) {
            return redirect($state['referer']);
        }
        return $credential;
    }

    protected function getAdapter($type)
    {
        switch (strtolower($type)) {
            case 'google':
                return new GoogleAdapter();
            default:
                throw new BadRequestHttpException('Invalid OAuth type');
        }
    }
}
