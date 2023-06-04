<?php
require_once('../inc/init.inc.php');

require_once('../inc/header.inc.php');   
?>
    <h1>Rechercher un fims</h1>

    <div class="d-flex">

    <form action="" method="get">

        <div class="">

            <input type="text" name="movie" id="movie">

            <input type="submit" value="Rechercher" id="search" name="search">

            <?php 
            
                if (isset($_GET['movie'])){

                    $test = $_GET["movie"];

                    $sql = "SELECT movie.* 
                    FROM movie
                    LEFT JOIN movie_genre ON  movie.id = movie_genre.id_movie 
                    LEFT JOIN genre ON movie_genre.id_genre = genre.id
                    LEFT JOIN distributor ON movie.id_distributor = distributor.id
                    WHERE (movie.title LIKE '%$test%' OR genre.name LIKE '%$test%' OR distributor.name LIKE '%$test%');";

                    $stmt = $pdo->query($sql);

                    echo "<table>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>Id</th>";
                            echo "<th>Title</th>";
                            echo "<th>Director</th>";
                            echo "<th>Duration</th>";
                            echo "<th>Date de sortie</th>";
                            echo "<th>Notation</th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                                    echo "<tr>";
                                        echo "<td>".$row['id']."</td>";
                                        echo "<td>".$row['title']."</td>";
                                        echo "<td>".$row['director']."</td>";
                                        echo "<td>".$row['duration']."</td>";
                                        echo "<td>".$row['release_date']."</td>";
                                        echo "<td>".$row['rating']."</td>";
                                    echo "</tr>";
                        }
                    echo "</tbody>";
                    echo "</table>";


                }

            ?>

        </div>
    </form>

    </div>

    

 <?php
require_once('../inc/footer.inc.php')
?>