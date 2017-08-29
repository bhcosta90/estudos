<?php

class UsuarioSeed {

    function run()
    {
        $user = new Usuario;
        $user->login = time();
        $user->senha = password_hash('123456', PASSWORD_DEFAULT);
        $user->save();
    }
}
