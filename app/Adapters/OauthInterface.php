<?php

namespace App\Adapters;

use App\Models\Credential;

interface OauthInterface
{
    public function authenticate(Credential $credential);

    public function getAuthUrl($redirectUrl, array $state = []): string;

    public function createCredential($authCode, array $state = []): Credential;

    public function getType(): string;
}
