<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model {

	protected $fillable = ['cardNumber', 'expiry', 'brand', 'country', 'token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
