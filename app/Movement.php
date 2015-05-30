<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model {

	protected $fillable = ['type', 'stop_id'];

    public function __toString() {
        return "Conteneur #{$this->container->id} - " . ($this->type == 'C' ? 'Chargement' : 'Déchargement');
    }

    public function container() {
        return $this->belongsTo('App\Container');
    }

    public function stop() {
        return $this->belongsTo('App\Stop');
    }

}
