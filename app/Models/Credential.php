<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Relation;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use App\Adapters\OauthInterface;
use App\Adapters\GoogleAdapter;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $table = 'credentials';

    protected $fillable = ['user_id', 'data', 'type'];

    public static function boot()
    {
        parent::boot();
    }

    public function user(): Relation
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function initAdapter(): OauthInterface
    {
        switch ($this->type) {
            case 'google':
                $adapter = new GoogleAdapter();
                break;
            default:
                throw new BadRequestHttpException('Invalid OAuth type');
        }

        $adapter->authenticate($this);
        return $adapter;
    }

    public function getAccessToken(): array
    {
        return json_decode($this->data, true) ?? [];
    }

    public function setAccessToken(array $accessToken)
    {
        $accessToken = array_merge($this->getAccessToken(), $accessToken);
        $this->data = json_encode($accessToken);
        return $this;
    }

    public function setUserId($uid)
    {
        $this->user_id = $uid;
        return $this;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
