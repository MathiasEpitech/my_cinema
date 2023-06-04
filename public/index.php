<?php
require_once('../inc/connec.inc.php');

session_start();

if (isset($_GET['movie'])){

    $NameMovie = $_GET["movie"];

    $sql = "SELECT * FROM movie WHERE title LIKE '%$NameMovie%';";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$NameMovie]);
}
if(isset($_GET['genre'])) {

    $test = $_GET["genre"];

    $sql = "SELECT * FROM movie_genre INNER JOIN genre ON  movie_genre.id_genre = genre.id JOIN movie ON movie.id = movie_genre.id_movie WHERE genre.id LIKE $test;";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$test]);
}

require_once('../inc/header.inc.php')   
?>
    <h1>Bientvenue</h1>

    <form action="" method="get">

        <div>

            <input type="text" name="movie" id="movie">

            <input type="submit" value="Rechercher" id="search" name="search">

        </div>

        <div class="d-flex">

                <select id="cars" name="genre">
                    <option value="0"></option>
                    <option value="1">Action</option>
                    <option value="3">Adventure</option>
                    <option value="2">Animation</option>
                    <option value="7">Biography</option>
                    <option value="5">Comedy</option>
                    <option value="8">Crime</option>
                    <option value="4">Drama</option>
                    <option value="13">Family</option>
                    <option value="9">Fantasy</option>
                    <option value="10">Horror</option>
                    <option value="6">Mystery</option>
                    <option value="12">Romance</option>
                    <option value="11">Sci-Fi</option>
                    <option value="14">Thriller</option>

                </select>

                <input type="submit">

        </div>

    </form>

    <table>
    <thead>
        <tr>
        <th>Id genre</th>
        <th>Title</th>
        <th>Director</th>
        <th>Duration</th>
        <th>Date de sortie</th>
        <th>Notation</th>
        <th>Id movie</th>
        <th>Genre</th>
        </tr>
    </thead>
    <tbody>

        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>

            <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['director']); ?></td>
            <td><?php echo htmlspecialchars($row['duration']); ?></td>
            <td><?php echo htmlspecialchars($row['release_date']); ?></td>
            <td><?php echo htmlspecialchars($row['rating']); ?></td>
            <td><?php echo htmlspecialchars($row['id_movie']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            </tr>

        <?php endwhile; ?>

        

    </tbody>
 </table>

 <?php
require_once('../inc/footer.inc.php')
?>