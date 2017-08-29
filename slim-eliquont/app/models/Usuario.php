<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Usuario extends Eloquent {

	/**
	* The database table used by the model.
	*
	* @var string
	*/
	protected $table = 'usuario';

	public function getTaxi(){
		$automovel = (new Automovel)
		->whereNull('remove_at')
		->where(function($query){
			$query->where('id_usuario', '=', $this->id);
		})
		->orderBy('nome', 'asc')
		->orderBy('created_at', 'desc');

		getSQL($automovel);

		return $automovel->get();
	}
}
