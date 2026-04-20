<?php

namespace yangpimpollo\L3_infrastructure\Model;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;



#[Fillable(['username', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class my_user extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'my_users';
}