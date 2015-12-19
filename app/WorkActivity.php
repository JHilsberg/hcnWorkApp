<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkActivity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'work_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'prover_id', 'description', 'active', 'hours', 'proven', 'date'];

    public function getDateValue() {
        return date('d.m.Y', strtotime($this->attributes['date']));
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function prover()
    {
        return $this->belongsTo('App\User', 'prover_id');
    }
}
