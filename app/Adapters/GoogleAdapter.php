<?php

namespace App\Adapters;

use App\Models\User;
use App\Models\Credential;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class GoogleAdapter implements OauthInterface
{
    protected $client;

    protected $service;

    public function __construct()
    {
        $client = new \Google_Client();
        $client->setScopes([
            \Google_Service_Calendar::CALENDAR_READONLY,
            \Google_Service_Calendar::CALENDAR,
        ]);

        $credentialsPath = base_path('config/google-oauth.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Google credentials file not exists');
        }
        $client->setAuthConfig($credentialsPath);
        $client->setAccessType('offline');

        $this->client = $client;
        $this->service = new \Google_Service_Calendar($client);
    }

    public function serialize(array $state)
    {
        return base64_encode(json_encode($state));
    }

    public function deserialize($stateString)
    {
        return json_decode(base64_decode($stateString), true);
    }

    public function authenticate(Credential $credential)
    {
        $client = $this->client;
        $accessToken = $credential->getAccessToken();
        $client->setAccessToken($accessToken);
        if ($client->isAccessTokenExpired()) {
            $accessToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $credential->setAccessToken($accessToken);
        }
    }

    public function getAuthUrl($redirectUrl, array $state = []): string
    {
        $this->client->setState($this->serialize($state));
        $this->client->setRedirectUri($redirectUrl);
        $this->client->setPrompt('consent');
        return $this->client->createAuthUrl();
    }

    public function createCredential($authCode, array $state = []): Credential
    {
        $userId = $state['user_id'] ?? null;
        $redirectUrl = $state['redirect_uri'] ?? null;

        $client = $this->client;
        $client->setRedirectUri($redirectUrl);
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        }

        return (new Credential([
            'type' => 'google'
        ])) ->setUserId($userId)
            ->setAccessToken($client->getAccessToken());
    }

    public function getType(): string
    {
        return 'google';
    }
}
