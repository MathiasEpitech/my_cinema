<?php
require_once ('../inc/init.inc.php');

if( isset($_GET['action']) && $_GET['action'] == 'ajout' ){


    $content.= "<form method='post'>";

        $content.="<select id='genre' name='genre'>";
        $content.="<option value='0'></option>";
        $content.="<option value='1'>Action</option>";
        $content.="<option value='3'>Adventure</option>";
        $content.="<option value='2'>Animation</option>";
        $content.="<option value='7'>Biography</option>";
        $content.= "<option value='5'>Comedy</option>";
        $content.= "<option value='8'>Crime</option>";
        $content.= "<option value='4'>Drama</option>";
        $content.= "<option value='13'>Family</option>";
        $content.= "<option value='9'>Fantasy</option>";
        $content.= "<option value='10'>Horror</option>";
        $content.= "<option value='6'>Mystery</option>";
        $content.= "<option value='12'>Romance</option>";
        $content.= "<option value='11'>Sci-Fi</option>";
        $content.= "<option value='14'>Thriller</option>";

        $content.= "<input type='submit'>";

            if(isset($_POST['genre'])) {

                $test = $_POST["genre"];

                $sql = "SELECT * FROM movie_genre INNER JOIN genre ON  movie_genre.id_genre = genre.id JOIN movie ON movie.id = movie_genre.id_movie WHERE genre.id LIKE $test;";

                $stmt = $pdo->query($sql);

                $content.= "<table  class='table table-bordered text-center' cellpadding='5'>";
                    $content.= "<thead class='bg-dark text-white'>";
                        $content.= "<tr>";
                            $content.=  "<th>Id</th>";
                            $content.=  "<th>Title</th>";
                            $content.=  "<th>Director</th>";
                            $content.=  "<th>Duration</th>";
                            $content.=  "<th>Date de sortie</th>";
                            $content.=  "<th>Notation</th>";
                            $content.=  "<th>Id movie</th>";
                            $content.=  "<th>Genre</th>";
                            $content.=  "<th>Action</th>";
                $content.=  "</tr>";
                $content.=  "</thead>";
                $content.=  "<tbody>";
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                            $content.=  "<tr>";
                            $content.=  "<td>".$row['id']."</td>";
                            $content.=  "<td>".$row['title']."</td>";
                            $content.=  "<td>".$row['director']."</td>";
                            $content.=  "<td>".$row['duration']."</td>";
                            $content.=  "<td>".$row['release_date']."</td>";
                            $content.=  "<td>".$row['rating']."</td>";
                            $content.=  "<td>".$row['id_genre']."</td>";
                            $content.=  "<td>".$row['name']."</td>";
                            $content.= '<td>
                                <a class="btn btn-secondary" href="?action=add&id_movie='.$row['id'].'&id_user='.$_GET['id_user'].'" >
                                    <i class="fa-solid fa-plus"></i>
                                </a>
                                    </td>';
                            $content.=  "</tr>";
                        }
                        $content.=  "</tbody>";
                        $content.=  "</table>";

                }

    $content.= "</form>";

}


if( isset( $_GET['action']) && $_GET['action'] == 'add' ){

        
    $pdo->exec("INSERT INTO movie_histo(id_movie, id_user)
            VALUES ('$_GET[id_movie]', '$_GET[id_user]')");

    //rediraction vers l'affichage
    header('location:?action=historique&id_user='.$_GET["id_user"].'');

}


if( isset($_GET['action']) && $_GET['action'] == 'rechercher' ){

    $content .="<form method='post'>";

    $content .="<label>Titre</label><br>";
    $content .="<input type='text' name='rech' value=''><br><br>";

    $content .="<input type='submit' class='btn btn-secondary'>";
    $content .="</form>";
    
    if (isset($_POST['rech'])){

        $test = $_POST["rech"];

        $r = $pdo->query("SELECT * FROM user
        WHERE (firstname LIKE '%$test%' OR lastname LIKE '%$test%' 
        OR CONCAT(firstname, ' ',lastname)LIKE '%$test%'
        OR CONCAT(lastname, ' ',firstname)LIKE '%$test%')");

        $content .= "<p>Nombre de membres dans notre basesdedonner : ". $r->rowCount() ."</p>";
        

        $content .= "<table class='table table-bordered' cellpadding='5'>";
                $content .= "<tr>";

                $nombre_colonne = $r->columnCount();

                for( $i = 0; $i < $nombre_colonne; $i++ ){

                    $info_colonne = $r->getColumnMeta( $i );

                    $content .= "<th> $info_colonne[name] </th>";

                }
                    $content .= "<th> Voir profil </th>";
                $content .= "</tr>";

            while( $user = $r->fetch( PDO::FETCH_ASSOC ) ){			
        //debug( $user );

                $content.= "<tr>";

            foreach( $user as $indice => $valeur ){

                    $content .= "<td> $valeur </td>";
                
            }

                    $content.= '<td>
                                    <a class="btn btn-primary" href="?action=voirprofil&id='.$user['id'].'" >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>';

                $content.= "</tr>";
            }
        $content .= "</table>";

    }
}

if( isset($_GET['action']) && $_GET['action'] == 'affichage' ){ //SI il existe 'action' dans l'URL - ET - que cette 'action' est égale à 'affichage' (c'est que l'on a cliqué sur le lien)

    //récupération des infos en bdd (select)
    $r = $pdo->query(" SELECT * FROM user ");

    // $r = $pdo->query("SELECT * 
    // FROM user
    // LEFT JOIN membership ON  user.id = membership.id_user
    // LEFT JOIN subscription ON membership.id_subscription = subscription.id");

    $content .= "<h2>Listing des membres</h2>";
    $content .= "<p>Nombre de membres dans notre cinema : ". $r->rowCount() ."</p>";
        //rowCount() permet de retourner le nombre de ligne de résultat retournée par la requête ($r)
        
    $content .= "<table class='table table-bordered text-center' cellpadding='5'>";
        $content .= "<thead class='bg-dark text-white'>";

            $content .= "<tr>";


                $nombre_colonne = $r->columnCount();
                //columnCount() : retourne le nombre de colonnes issues du jeu de résultat ($r) retourné par la requête
                    //debug( $nombre_colonne ); //Ici, 5 colonnes

                for( $i = 0; $i < $nombre_colonne; $i++ ){

                    $info_colonne = $r->getColumnMeta( $i );
                    //getColumnMeta( int ) : retourne des informations sur les colonnes issues du jeu de résultat ($r) retourné par la requête
                        //debug( $info_colonne );

                    $content .= "<th> $info_colonne[name] </th>";

                }
                $content .= "<th> Voir </th>";

            $content .= "</tr>";
        $content .= "</thead>";
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
                                <a class="btn btn-primary" href="?action=voirprofil&id='.$user['id'].'" >
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </td>';

            $content.= "</tr>";
        }
    $content .= "</table>";
}

//--------------------------------------------------
//VOIR LES INFO D'UN USER:
if( isset($_GET['action']) && $_GET['action'] == 'voirprofil' ){


    $r = $pdo->query(" SELECT * FROM user
    WHERE id = '$_GET[id]'
    ");
        

    $content .= "<table class='table table-bordered text-center' cellpadding='5'>";
        $content .= "<thead class='bg-dark text-white'>";
            $content .= "<tr>";

            $nombre_colonne = $r->columnCount();

            for( $i = 0; $i < $nombre_colonne; $i++ ){

                $info_colonne = $r->getColumnMeta( $i );

                $content .= "<th> $info_colonne[name] </th>";

            }
                $content .= "<th> Voir historique </th>";
            $content .= "</tr>";
        $content .= "</thead>";
        while( $user = $r->fetch( PDO::FETCH_ASSOC ) ){			
        //debug( $user );

            $content.= "<tr>";

        foreach( $user as $indice => $valeur ){

                $content .= "<td> $valeur </td>";
                
        }

                $content.= '<td>
                                <a class="btn btn-success" href="?action=historique&id_user='.$user['id'].'" >
                                    <i class="fa-solid fa-list"></i>
                                </a>
                            </td>';

            $content.= "</tr>";
        }
    $content .= "</table>";

}

//VOIR LES HISTORIQUE D'UN USER:
if( isset($_GET['action']) && $_GET['action'] == 'historique' ){


    $sql=(" SELECT * FROM movie_histo
    INNER JOIN movie ON movie_histo.id_movie = movie.id
    INNER JOIN user ON movie_histo.id_user = user.id
    WHERE id_user = '$_GET[id_user]'
    ");
    // debug($sql);

    $stmt = $pdo->query($sql);
    // debug($stmt);
    $results = $stmt->fetchAll();
    // debug($results);
        
    $content .= "<div class='text-center'>";
        $content .= '<a class="btn btn-secondary" href="?action=ajout&id_user='.$_GET['id_user'].'">Ajouter des films a mon histoire</a><br>';
    $content .= "</div>";   
    $content .= "<table class='table table-bordered text-center' cellpadding='5'>";
        $content .= "<thead class='bg-dark text-white'>";
            $content .= "<tr>";
                $content.="<th>Id</th>";
                $content.="<th>Titre</th>";
                $content .= "<th> Director </th>";
            $content .= "</tr>";
        $content .= "</thead>";
        $content.="<tbody>";
        foreach( $results as $histo ){
            $content.="<tr>";
                $content.="<td>".$histo['id']."</td>";
                $content.="<td>".$histo['title']."</td>";
                $content.="<td>".$histo['director']."</td>";
            $content.="</tr>";
        }
        $content.="</tbody>";
    $content .= "</table>";

}


//----------------------------------------------------------------------------
?>
<?php require_once '../inc/header.inc.php'; ?>

<h1>Espace des membres</h1>

<!-- 2 liens pour gérer soit l'affichage soit le formulaire selon l'action passée dans l'URL -->


<!--<a href="?action=ajout">Ajouter un nouvel user</a><br>-->
<a href="?action=affichage">Affichage des users</a><br>
<a href="?action=rechercher">Rechercher un membre par son nom et/ou son prénom</a><hr>

<?php echo $error; //affichage ?>
<?= $content; //affichage ?>


<?php require_once '../inc/footer.inc.php'; ?>