<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model {

	public $fillable = [
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

    public function ships() {
        return $this->hasMany('App\Ship');
    }

}
