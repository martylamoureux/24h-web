<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model {

	protected $fillable = [
        'date_in',
        'date_out',
    ];

    public function __toString() {
        $str = "{$this->ship} - {$this->getDateInString()}";
        if ($this->date_out !== null)
            $str .= " au {$this->getDateOutString()}";
        return $str;
    }

    public function ship() {
        return $this->belongsTo('App\Ship');
    }

    public function getDateIn() {
        return Carbon::createFromFormat('Y-m-d', $this->date_in);
    }

    public function getDateOut() {
        return Carbon::createFromFormat('Y-m-d', $this->date_out);
    }

    public function getDateInString() {
        if ($this->date_in == null)
            return "";
        return trim(ucwords(strftime("%A %e %B %Y", $this->getDateIn()->getTimestamp())));
    }

    public function getDateOutString() {
        if ($this->date_out == null)
            return "";
        return trim(ucwords(strftime("%A %e %B %Y", $this->getDateOut()->getTimestamp())));
    }

    public function getDateInShortString() {
        if ($this->date_in == null)
            return "";
        return trim(ucwords(strftime("%B %Y", $this->getDateIn()->getTimestamp())));
    }

    public function setDateInAttribute($date) {
        if ($date != "")
            $this->attributes['date_in'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        else
            $this->attributes['date_in'] = null;
    }

    public function setDateOutAttribute($date) {
        if ($date != "")
            $this->attributes['date_out'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        else
            $this->attributes['date_out'] = null;
    }

    public static function getList($ship_id)
    {
        $res = [];
        foreach (static::where('ship_id', $ship_id)->get() as $stop) {
            $res[$stop->id] = strval($stop);
        }
        return $res;
    }

}
