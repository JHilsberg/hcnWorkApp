<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'number'];


    public function getAllTeams()
    {
        return $this->lists('name', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\User', 'team_id');
    }

}
