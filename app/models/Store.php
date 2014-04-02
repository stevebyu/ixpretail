<?php

class Store extends Illuminate\Database\Eloquent\Model {

	protected $fillable = array('name');

	public function users(){
		return $this->hasMany('User');
	}

	public function counts(){
		return $this->hasMany('Count');
	}

}
?>