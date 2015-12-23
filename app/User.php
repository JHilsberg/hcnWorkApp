<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'surname', 'email', 'password', 'team_id', 'is_prover', 'is_admin'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function isAdmin()
    {
        $user = Auth::user();

        return $user->is_admin;
    }

    public function isProver()
    {
        $user = Auth::user();

        return $user->is_prover;
    }

    public function getAllProvers(){
        $provers= $this::select(
            DB::raw("CONCAT(first_name,' ',surname) AS full_name, id"))->where('is_prover', 1)
            ->orderBy('surname', 'asc')->lists('full_name', 'id');
        return $provers;
    }

    public function workActivities()
    {
        return $this->hasMany('App\WorkActivity');
    }

    public function proveWorkActivities()
    {
        return $this->hasMany('App\WorkActivity', 'prover_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Team');
    }
}
