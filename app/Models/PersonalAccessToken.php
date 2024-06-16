<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Traits\UUID;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory, UUID;

    protected $table = 'personal_access_tokens';

    public function tokenable()
    {
        return $this->morphTo('tokenable', "tokenable_type", "tokenable_id", "id");
    }
}
