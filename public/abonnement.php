<?php
require_once ('../inc/init.inc.php');

//--------------------------------------------------
//SUPPRESSION (toujours avant l'affichage)
//debug( $_GET );

if( isset($_GET['action']) && $_GET['action'] == 'suppression' ){ //SI il y a une 'action' dans l'URL -ET- que cette 'action' est égale à 'suppression'

	//Requête de suppression DELETE :
	$pdo->exec(" DELETE FROM membership WHERE id_user = '$_GET[id_user]' ");
	//SUppression dans la table 'article' A CONDITION que dans la colonne 'id_article' se soit égale à l'id récupérée dans l'URL

	//redirection vers l'affichage des produits
	header('location:?action=affiabo');
}

//--------------------------------------------------
//INSERTION des abonnement et modification :
if( !empty( $_POST ) ){ //SI on a validé le formulaire et qu'il N'EST PAS VID

	if( isset( $_GET['action']) && $_GET['action'] == 'modification' ){ 
        
        //SI il existe 'actoin' dans l'URL et que cette 'action' est égale à 'modification', alors on effectue un UPDATE

		$pdo->exec("UPDATE membership SET id_subscription = $_POST[id] WHERE id_user = $_GET[id_user]");

		//rediraction vers l'affichage
		header('location:?action=affichage');
	}



	elseif( empty( $error ) ){ //SI la variable $error est VIDE, c'est que le formulaire à été correctement rempli et donc on fait l'insertion

	$pdo->exec("INSERT INTO membership(id_user, id_subscription)
        VALUES ('$_GET[id_user]',
                '$_POST[id]'
                )
                ");

	// 	//rediraction vers l'affichage
	header('location:?action=affichage');
	}
}

//--------------------------------------------------
//VOIR LES INFO D'UN USER:
if( isset($_GET['action']) && $_GET['action'] == 'voirprofil' ){


    $r = $pdo->query(" SELECT * FROM membership 
    INNER JOIN user ON  membership.id_user = user.id
    INNER JOIN subscription ON membership.id_subscription = subscription.id
    WHERE id_user = '$_GET[id_user]'
    ");
        

    $content .= "<table class='table table-bordered' cellpadding='5'>";
            $content .= "<tr>";

            $nombre_colonne = $r->columnCount();

            for( $i = 0; $i < $nombre_colonne; $i++ ){

                $info_colonne = $r->getColumnMeta( $i );

                $content .= "<th> $info_colonne[name] </th>";

            }
                $content .= "<th> Suppression </th>";
                $content .= "<th> Modification </th>";
            $content .= "</tr>";

        while( $user = $r->fetch( PDO::FETCH_ASSOC ) ){			
        //debug( $user );

            $content.= "<tr>";

        foreach( $user as $indice => $valeur ){

                $content .= "<td> $valeur </td>";
                
        }

                $content.= '<td>
                                <a href="?action=suppression&id_user='.$user['id'].'" onclick="return( confirm(\'Voulez vous supprimer : '. $user['firstname'].' '.$user['lastname'].' ?\') )" >
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>';

                $content.= '<td>
                                <a href="?action=modification&id_user='.$user['id'].'" >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>';

            $content.= "</tr>";
        }
    $content .= "</table>";

}

//--------------------------------------------------
//INSERTION des abonnement et modification :
if( isset($_GET['action']) && $_GET['action'] == 'affichage' ){ //SI il existe 'action' dans l'URL - ET - que cette 'action' est égale à 'affichage' (c'est que l'on a cliqué sur le lien)

    //récupération des infos en bdd (select)
    // $r = $pdo->query(" SELECT * FROM user ");

    $r = $pdo->query("SELECT * 
    FROM user
    INNER JOIN membership ON  user.id = membership.id_user
    INNER JOIN subscription ON membership.id_subscription = subscription.id");

    $content .= "<h2>Listing des membres</h2>";
    $content .= "<p>Nombre de membres dans notre cinema : ". $r->rowCount() ."</p>";
    $content .= "<a class='btn btn-secondary' href='?action=ajouterabo'>Ajouter des abonnements</a><br>";
        //rowCount() permet de retourner le nombre de ligne de résultat retournée par la requête ($r)
        
    $content .= "<table class='table table-bordered' cellpadding='5'>";

        $content.="<thead>";
            $content .= "<tr>";
                $content.="<th>Id</th>";
                $content.="<th>Adress mail</th>";
                $content.="<th>Prenom</th>";
                $content.="<th>Nom</th>";
                $content.="<th>Date de naissance</th>";
                $content.="<th>type abonemment</th>";
                $content.="<th>Description</th>";
                $content .= "<th> Id subscription </th>";
                $content .= "<th> Modification </th>";
            $content.="</tr>";
        $content.="</thead>";
        $content.="<tbody>";
        while($user = $r->fetch(PDO::FETCH_ASSOC)){

            $content.="<tr>";
                $content.="<td>".$user['id_user']."</td>";
                $content.="<td>".$user['email']."</td>";
                $content.="<td>".$user['firstname']."</td>";
                $content.="<td>".$user['lastname']."</td>";
                $content.="<td>".$user['birthdate']."</td>";
                $content.="<td>".$user['name']."</td>";
                $content.="<td>".$user['description']."</td>";
                $content.="<td>".$user['id_subscription']."</td>";
                $content.='<td><a href="?action=modification&id_user='.$user['id_user'].'" ><i class="fa-solid fa-pen-to-square"></i></a></td>';
            $content.="</tr>";
        }
        $content.="</tbody>";
    $content.="</table>";

        while( $user = $r->fetch( PDO::FETCH_ASSOC ) ){			
            //fetch() : retourne un tableau (ici, $ligne) avec les valeurs en BDD indéxés par les champs de la table 'user' grâce au paramètre PDO::FETCH_ASSOC
                //Ici, $ligne va retourner UN tableau correspondant à UNE LIGNE de résultat issue du jeu de résultat de la requêtes ($r : object PDOStatement)
            //Une ligne correspond à UN user !
            //On utilise une boucle while pour afficher TOUTES les lignes TANT QU'il y en a à afficher car fetch() retourne la ligne suivante d'un jeu de résultat

            //debug( $user );

            $content.= "<tr>";

                foreach( $user as $indice => $valeur ){

                        $content .= "<td> $valeur </td>";
                    
                }

                //Ci-dessous: on fait passer des infos dans l'URL: une action de suppression ET l'id de l'user que l'on souhaite supprimer
                //On a ajouté du JS pour avoir la possibilité d'annuler la suppression car DELETE est irreversible
                $content.= '<td>
                                <a href="?action=suppression&id_user='.$user['id'].'" onclick="return( confirm(\'Voulez vous supprimer : '. $user['firstname'].' '.$user['lastname'].' ?\') )" >
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>';

                $content.= '<td>
                                <a href="?action=modification&id_user='.$user['id'].'" >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>';

            $content.= "</tr>";
        }
    $content .= "</table>";
}

if( isset($_GET['action']) && $_GET['action'] == 'affiabo' ){ 

    $r = $pdo->query(" SELECT * FROM membership 
                        INNER JOIN user ON  membership.id_user = user.id
                        INNER JOIN subscription ON membership.id_subscription = subscription.id
    ");
    
    $content .= "<h2>Listing des abonnement</h2>";
    $content .= "<p>Nombre d'abonnement dans notre cinema : ". $r->rowCount() ."</p>";
         
    $content .= "<table class='table table-bordered' cellpadding='5'>";
        $content .= "<tr>";
    
            $nombre_colonne = $r->columnCount();
    
            for( $i = 0; $i < $nombre_colonne; $i++ ){
    
                $info_colonne = $r->getColumnMeta( $i );
    
                $content .= "<th> $info_colonne[name] </th>";
    
            }
            $content .= "<th> Voir </th>";
            $content .= "<th> Modification </th>";
            $content .= "<th> Suppression </th>";
        $content .= "</tr>";
    
        while( $menbership = $r->fetch( PDO::FETCH_ASSOC ) ){			

            $content.= "<tr>";
    
                foreach( $menbership as $indice => $valeur ){
    
                        $content .= "<td> $valeur </td>";
                    
                }
                $content.= '<td>
                                <a href="?action=voirprofil&id_user='.$menbership['id_user'].'" >
                                <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>';
    
                $content.= '<td>
                                <a href="?action=modification&id_user='.$menbership['id_user'].'" >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>';

                $content.= '<td>
                                <a href="?action=suppression&id_user='.$menbership['id_user'].'" onclick="return( confirm(\'Voulez vous supprimer l abonnement '. $menbership['name'].' de '. $menbership['firstname'].' '.$menbership['lastname'].' ?\') )" >
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>';
    
            $content.= "</tr>";
        }
    $content .= "</table>";
}

if( isset( $_GET['action']) && $_GET['action'] == 'ajouterabo' ){ 
        
    $r = $pdo->query("SELECT user.id,user.email,user.firstname,user.lastname,membership.id_subscription FROM user 
    LEFT JOIN membership ON user.id= membership.id");
    
    $content .= "<h2>Listing des membres</h2>";
    $content .= "<p>Nombre de membres dans notre cinema : ". $r->rowCount() ."</p>";
         
    $content .= "<table class='table table-bordered' cellpadding='5'>";

    $content.="<thead>";
        $content .= "<tr>";
            $content.="<th>Id</th>";
            $content.="<th>Adress mail</th>";
            $content.="<th>Prenom</th>";
            $content.="<th>Nom</th>";
            $content.="<th>Id_subscription</th>";
            $content .= "<th> Ajouter </th>";
        $content.="</tr>";
    $content.="</thead>";
    $content.="<tbody>";
    while($menbership = $r->fetch( PDO::FETCH_ASSOC )){

        $content.="<tr>";
            $content.="<td>".$menbership['id']."</td>";
            $content.="<td>".$menbership['email']."</td>";
            $content.="<td>".$menbership['firstname']."</td>";
            $content.="<td>".$menbership['lastname']."</td>";
            $content.="<td>".$menbership['id_subscription']."</td>";
            $content.='<td><a href="?action=ajout&id_user='.$menbership['id'].'" ><i class="fa-solid fa-plus"></i></a></td>';
        $content.="</tr>";
    }
    $content.="</tbody>";
$content.="</table>";
}

//----------------------------------------------------------------------------
?>
<?php require_once '../inc/header.inc.php'; ?>

<h1>GESTION DES userS</h1>

<!-- 2 liens pour gérer soit l'affichage soit le formulaire selon l'action passée dans l'URL -->


<!--<a href="?action=ajout">Ajouter un nouvel user</a><br>-->
<a href="?action=affichage">Affichage des users ayant un abonnement</a><br>
<!-- <a href="?action=rechercher">Rechercher un membre par son nom et/ou son prénom</a><hr> -->
<a href="?action=affiabo">Affichage des users ayant un abonnement +</a><hr>

<?php echo $error; //affichage ?>
<?= $content; //affichage ?>

<?php  

if( isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification') ) : 
    //SI il existe 'action' dans l'URL - ET - que cette 'action' est égale à 'ajout'  
    //(c'est que l'on a cliqué sur le lien et on affiche le <form>) ou à 'modification'(c'est que l'on a cliqué sur l'icone modifier) 

    if( isset( $_GET['id_user']) ){ //SI il existe 'id_user' dans l'URL, c'est que l'on est dans le cadre d'une modification !

        //Récupération des infos de l'user à modifier pour pré-remplir le formulaire
        $r = $pdo->query("SELECT user.id,user.firstname,user.lastname,membership.id_subscription FROM user LEFT JOIN membership ON user.id= membership.id
        WHERE user.id = '$_GET[id_user]' ");

        $user_actuel = $r->fetch( PDO::FETCH_ASSOC );
            //debug( $user_actuel );
    }
    //---------------------------------------------------
    if( isset($user_actuel['']) ){ 
    // //SI $user_actuel['categorie'] existe, c'est que l'on est dans le cadre d'une modification, donc, on déclare une variable et on stocke la valeur correspondante récupérée en bdd que l'on affichera dans l'attribut value="" de l'input correspondant

        $testabo = $user_actuel['id'];
    }
    else{ //SINON, c'est que l'on est dans le cadre d'un ajout on déclare cette même variable avec "rien" à l'intérieur que l'on affichera dans l'attribut value="" de l'input correspondant

         $testabo = '';
    }

    //Version ternaire
    $idUser = ( isset($user_actuel['id_user']) ) ? $user_actuel['id_user'] : '';
    $id = ( isset($user_actuel['id']) ) ? $user_actuel['id'] : '';
    $nom = ( isset($user_actuel['lastname']) ) ? $user_actuel['lastname'] : '';
    $prenom = ( isset($user_actuel['firstname']) ) ? $user_actuel['firstname'] : '';
    $abo = ( isset($user_actuel['name']) ) ? $user_actuel['name'] : '';
    $des = ( isset($user_actuel['description']) ) ? $user_actuel['description'] : '';



    $sql = "SELECT * FROM subscription";
    $stmt = $pdo->query($sql);
    //-----------------------------------------------------------------------
    ?>

    <form method='POST'>

        <input class="disabled" type="text" name="id" value="<?= $id ?>" disabled><br><br>
        <label>Prenom :</label><br>
        <input class="disabled" type="text" name="prenom" value="<?= $prenom?>" disabled><br><br>       
        <label>Nom :</label><br>
        <input type="nom" name="nom" value="<?= $nom ?>" disabled><br><br>

        <label for="name">Abonnement :</label><br>

        <select id="name" name="id">

            <option value="1">---<?= $abo ?>---</option>

            <?php


                while($user_abo = $stmt->fetch(PDO::FETCH_ASSOC)){
                        
                    echo "<option value=".$user_abo['id'].">".$user_abo['name']."</option>";

                }


            ?>

        </select><br><br>


        <input type="submit"  name="submit" class="btn btn-secondary">

    </form>

<?php endif; ?>

<?php require_once '../inc/footer.inc.php'; ?>