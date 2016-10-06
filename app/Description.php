<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Description extends Model
{
	use SoftDeletes; // use the softdelete traits
	public $fillable = ['author','title','description'];
	
    public function hamburger(){
		return $this->belongsTo(Hamburger::class);
	}
	
	public function scopeOfHamburger($query, $hamburgerId){
		return $query->where('hamburger_id', $hamburgerId);
	}
	
}
