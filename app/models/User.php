<?php

class User extends Illuminate\Database\Eloquent\Model {

	protected $fillable = array('username');

	protected $hidden = array('password');

	public function store()
	{
		return $this->belongsTo('Store');
	}


}

?>
