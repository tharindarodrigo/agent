<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole{
	protected $fillable = [];


	public function user()
	{
		return $this->belongsToMany('User','assigned_roles');
	}


}

