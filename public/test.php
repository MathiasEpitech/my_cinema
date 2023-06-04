<?php

if (isset($_GET['movie'])) {

    $test = $_GET["movie"];

    $sql = "SELECT * FROM movie WHERE title LIKE '%$test%';";

    $stmt = $pdo->prepare("SELECT * FROM movie WHERE title= :title;");

    $stmt = $pdo->prepare($sql);
//Ici le ":string" siginifie placeholder, remplacé plus tard par une variable via bindParam
$stmt->bindParam("movie_title", $movie_title, PDO::PARAM_STR);

    $stmt->execute([$test]); //Let's go

}

$sql = "SELECT * FROM movie INNER JOIN movie_genre ON  movie.id = movie_genre.id_movie JOIN genre ON genre.id = movie_genre.id_genre";

$stmt = $pdo->query($sql);