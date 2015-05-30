<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Container extends Model {

	public $fillable = [
        'capacity',
        'ship_id',
    ];

    public function __toString() {
        return strval($this->ship) . ' - Conteneur #'.$this->id;
    }

    public function ship() {
        return $this->belongsTo('App\Ship');
    }

    public function movements() {
        return $this->hasMany('App\Movement');
    }

}
