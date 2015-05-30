<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model {

	protected $fillable = [
        'name',
        'capacity'
    ];

    public function __toString() {
        return $this->name;
    }

    public function company() {
        return $this->belongsTo('App\Company');
    }

    public function stops() {
        return $this->hasMany('App\Stop');
    }

    public function containers() {
        return $this->hasMany('App\Container');
    }

}
