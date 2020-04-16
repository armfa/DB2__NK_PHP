<?php

//Dana Geßler	
//16.04.2020


class benutzerController extends Benutzer{

    public function check_login_controller($Benutzername, $Passwort){
        $this->check_login($Benutzername, $Passwort);
    }
}
