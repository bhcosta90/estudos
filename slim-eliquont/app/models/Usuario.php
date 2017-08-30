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

		return $automovel->get();
	}

	public $gerarToken = false;

	public function setSenhaAttribute($value)
	{
		$this->attributes['senha'] = $value ? password_hash($value, PASSWORD_DEFAULT) : null;
	}

	public function valida($senha){
		return password_verify($senha, $this->attributes['senha']) ? $this : false;
	}

	public function save(array $options = array()){
		if($this->gerarToken){
			$this->token = md5(time() . rand(1,9999));
		}

		parent::save($options);
	}
}
