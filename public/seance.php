<?php
require_once ('../inc/init.inc.php');

if( isset($_GET['action']) && $_GET['action'] == 'ajout' ){

    $r = $pdo->query(" SELECT * FROM room
    ");

    $content.="<label for='room'>Choisir une salle :</label><br>";

    while($room = $r->fetch(PDO::FETCH_ASSOC)){
                                
        $content.= "<a class='btn btn-danger' href='?action=select&id=".$room['id']."' > ".$room['name']." </a><br><br>";

    }

}


if( isset( $_GET['action']) && $_GET['action'] == 'select' ){

    if( isset( $_GET['id']) ){

        $content.= "<form method='POST'>";
        
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

        $content.="</form>";

        if(isset($_POST['genre'])){


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
                            <a class="btn btn-secondary" href="?action=add&id='.$_GET['id'].'&id_movie='.$row['id'].'" >
                                <i class="fa-solid fa-plus"></i>
                            </a>
                                </td>';
                        $content.=  "</tr>";
                    }
                    $content.=  "</tbody>";
                    $content.=  "</table>";

        }

    }

}

if( isset( $_GET['action']) && $_GET['action'] == 'add' ){

    if( isset( $_GET['id']) && isset($_GET['id_movie'])){

        $r = $pdo->query(" SELECT * FROM room
        ");
        $content.="<form method='POST'>";
        $content.="<label for='room'>Choisir une salle :</label><br>";
        $content.="<input type='datetime-local' name='datetime'>";
        $content.="<input type='submit'>";
        $content.="</form>";
    }

}

if(isset($_POST['datetime'])){

        
    $room = $_GET['id'];
    $movie = $_GET['id_movie'];
    $date = $_POST['datetime'];


    $pdo->exec("INSERT INTO movie_schedule(id_movie,id_room,date_begin)
    VALUES ('$movie', '$room', '$date');");

    // 	//rediraction vers l'affichage
    header('location:?action=affichage');

}


if( isset($_GET['action']) && $_GET['action'] == 'rechercher' ){

    $content .="<form method='post'>";

    $content .="<label>Date a rechercher :</label><br>";
    $content .="<input type='text' name='rech' value=''><br><br>";

    $content .="<input type='submit' class='btn btn-secondary'>";
    $content .="</form>";
    
    if (isset($_POST['rech'])){

        $date_string = $_POST["rech"];
        $timestamp = strtotime($date_string);
        $formatted_date = date("Y-m-d H:i:s", $timestamp);

        $r = $pdo->query("SELECT * FROM movie_schedule
        INNER JOIN movie ON movie_schedule.id_movie=movie.id
        INNER JOIN room ON movie_schedule.id_room=room.id
        WHERE date_begin = '$formatted_date'");

        $content .= "<p>Nombre de séance a cette date dans notre basesdedonner : ". $r->rowCount() ."</p>";
        

        $content .= "<table class='table table-bordered' cellpadding='5'>";
        $content .= "<thead class='bg-dark text-white'>";
            $content .= "<tr>";
                $content.="<th>Id</th>";
                $content.="<th>Date </th>";
                $content .= "<th>Film</th>";
                $content .= "<th>Salle de projection</th>";
            $content .= "</tr>";
        $content .= "</thead>";
        $content.="<tbody>";
        while($row = $r->fetch(PDO::FETCH_ASSOC)){

            $content.=  "<tr>";
            $content.=  "<td>".$row['id']."</td>";
            $content.=  "<td>".$row['date_begin']."</td>";
            $content.=  "<td>".$row['title']."</td>";
            $content.=  "<td>".$row['name']."</td>";
            $content.=  "</tr>";
        }
        $content.=  "</tbody>";
        $content.=  "</table>";

    }
}

if( isset($_GET['action']) && $_GET['action'] == 'affichage' ){ //SI il existe 'action' dans l'URL - ET - que cette 'action' est égale à 'affichage' (c'est que l'on a cliqué sur le lien)

    //récupération des infos en bdd (select)
    $r = $pdo->query(" SELECT * FROM movie_schedule 
    INNER JOIN room ON movie_schedule.id_room = room.id
    ");

    // $r = $pdo->query("SELECT * 
    // FROM user
    // LEFT JOIN membership ON  user.id = membership.id_user
    // LEFT JOIN subscription ON membership.id_subscription = subscription.id");

    $content .= "<h2>Listing des seances</h2>";
   $content .= "<p>Nombre de membres dans notre cinema : ". $r->rowCount() ."</p>";
        $content .= "<a class='btn btn-secondary' href='?action=ajout'>Ajouter des Seance</a><br>";
    $content .= "<table class='table table-bordered text-center' cellpadding='5'>";
        $content .= "<thead class='bg-dark text-white'>";

            $content .= "<tr>";


                $nombre_colonne = $r->columnCount();

                for( $i = 0; $i < $nombre_colonne; $i++ ){

                    $info_colonne = $r->getColumnMeta( $i );


                    $content .= "<th> $info_colonne[name] </th>";

                }


            $content .= "</tr>";
        $content .= "</thead>";
        while( $seance = $r->fetch( PDO::FETCH_ASSOC ) ){			

            $content.= "<tr>";

                foreach( $seance as $indice => $valeur ){

                        $content .= "<td> $valeur </td>";
                    
                }

            $content.= "</tr>";
        }
    $content .= "</table>";
}

//----------------------------------------------------------------------------
?>
<?php require_once '../inc/header.inc.php'; ?>

<h1>Espace des Seances</h1>

<!-- 2 liens pour gérer soit l'affichage soit le formulaire selon l'action passée dans l'URL -->


<!--<a href="?action=ajout">Ajouter un nouvel user</a><br>-->
<a href="?action=affichage">Affichage des seance</a><br><br>
<a href="?action=rechercher">Rechercher une séance par date</a><hr>

<?php echo $error; //affichage ?>
<?= $content; //affichage ?>


<?php require_once '../inc/footer.inc.php'; ?>