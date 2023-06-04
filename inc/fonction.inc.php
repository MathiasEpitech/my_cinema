<?php
//fonction débugage : (permet de faire un print() "amélioré")
function debug( $arg ){

	echo "<div style='background:orange; z-index:1000; padding:5px 30px;'>";

		echo '<pre>';
			print_r( $arg );
		echo '</pre>';

	echo '</div>';
}

//---------------------------------------------------------
//fonction userConnect : Si l'utilisateur est connecté
function userConnect(){

	if( isset( $_SESSION['membre'] ) ){ //SI la session/membre EXISTE, cela signifie que l'on est connecté (car on la crée lors de la connexion) et donc on renvoie 'true'

		return true;
	}
	else{ //SINON, c'est que l'on est pas connecté et que session/membre n'existe pas et on renverra 'false'

		return false;
	}
}

//---------------------------------------------------------
//fonction adminConnect() : Si l'admin est connecté
function adminConnect(){

	if( userConnect() && $_SESSION['membre']['statut'] == 1 ){ //SI l'utilisateur est connecté - ET - que son statut est égal à 1, c'est que le membre est un administrateur et donc on renvoie 'true'

		return true;
	}
	else{ //SINON, on renvoie 'false'

		return false;
	}
}

//---------------------------------------------------------
