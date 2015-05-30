<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	protected $fillable = [
        'name',
        'address',
        'country',
    ];

    public function __toString() {
        return $this->name;
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function containers() {
        return $this->hasMany('App\Container');
    }

}
