<?php require_once '../inc/init.inc.php';

//debug($_GET);

if( isset($_GET['id']) ){ //SI il y a 'id_article' dans l'URL, c'est que l'on a choisi délibérément d'afficher la fiche d'un article en particulier

	//On récupère les infos en BDD :
	$r = $pdo->query("SELECT * FROM genre WHERE id = '$_GET[id]' ");

	$genre = $r->fetch( PDO::FETCH_ASSOC );
		//debug( $genre );
}
else{ //SINON, c'est que l'on force l'accès à la page et on le redirige vers la apge d'accueil

	header('location:index1.php');
	exit;
}
//-----------------------------------------
//Créer 2 liens (fil d'ariane) 
//L'un sera pour retourner sur la page d'accueil
$content.= '<div class="d-flex flex-row">';
$content .= "<h3><a href='index1.php'> Accueil </a> /</h3> "; 
//l'aute pour retourner à la catégorie précédente
$content .= "<h3><a href='index1.php?genre=$genre[id]'> ". ucfirst( $genre['name'] ) ."</a> </h3><hr> "; 
$content .='</div>';

?>


<?php require_once '../inc/header.inc.php'; ?>

	<h1>Genre</h1>

	<?php echo $content; //Affichage du contenu
    
    //$sql = "SELECT * FROM movie_genre INNER JOIN genre ON  movie_genre.id_genre = genre.id JOIN movie ON movie.id = movie_genre.id_movie WHERE genre.id LIKE $_GET[id];";
 
    $stmt = $pdo->query("SELECT * FROM movie_genre INNER JOIN genre ON  movie_genre.id_genre = genre.id JOIN movie ON movie.id = movie_genre.id_movie WHERE genre.id LIKE '$_GET[id]' ");

    echo "<table>";
    echo "<thead>";
        echo "<tr>";
            echo "<th>Id</th>";
            echo "<th>Title</th>";
            echo "<th>Director</th>";
            echo "<th>Duration</th>";
            echo "<th>Date de sortie</th>";
            echo "<th>Notation</th>";
            echo "<th>Id movie</th>";
            echo "<th>Genre</th>";
        echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //debug($row);
        echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['title']."</td>";
            echo "<td>".$row['director']."</td>";
            echo "<td>".$row['duration']."</td>";
            echo "<td>".$row['release_date']."</td>";
            echo "<td>".$row['rating']."</td>";
            echo "<td>".$row['id_genre']."</td>";
            echo "<td>".$row['name']."</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>

<?php require_once '../inc/footer.inc.php'; ?>