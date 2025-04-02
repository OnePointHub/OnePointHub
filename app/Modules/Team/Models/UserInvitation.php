<?php

namespace App\Modules\Team\Models;

use Illuminate\Database\Eloquent\Model;

class UserInvitation extends Model
{
    protected $fillable = [
        'email',
        'invitation_token',
        'registered_at',
    ];

    public function generateInvitationToken(): void
    {
        $this->invitation_token = substr(md5(rand(0, 9).$this->email.time()), 0, 32);
    }

    public function getLink(): string
    {
        return urldecode(route('register').'?invitation_token='.$this->invitation_token);
    }
}
