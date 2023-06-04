<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/css2?family=Erica+One&family=Rubik+Dirt&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/dc01741cf6.js" crossorigin="anonymous"></script>

    <title>Cineradar</title>

</head>

<body>

    <header id="header" class="sticky-top">
        
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #000000">

            <div class="container-fluid">

                <a class="navbar-brand" href="index.html" style="font-family: 'Erica One', cursive;">CineRadar</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="mynavbar">

                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">

                            <a class="nav-link" href="index1.php">Accueil</a>

                        </li>

                        <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" type="button" data-bs-toggle="dropdown">Genre</a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <?php

                                    $sql = "SELECT * FROM genre;";

                                    $stmt = $pdo->query($sql);

                                    while($genre = $stmt->fetch(PDO::FETCH_ASSOC)){

                                        echo "<li>";
                                            echo "<a class='dropdown-item' href='fiche_genre.php?id=$genre[id]'>".$genre['name']."</td>";
                                        echo "</li>";
                                    }

                            ?>


                            <li>

                                <a class="dropdown-item disabled" href=""></a>

                            </li>


                        </ul>

                        </li>
                        
                        <li class="nav-item">

                            <a class="nav-link" href="membre.php">Membre</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="abonnement.php">Abonnement</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="seance.php">Séance</a>

                        </li>

                    </ul>

                    <ul class="navbar-nav d-flex flex-row me-1">

                        <li class="nav-item">

                            <a href="" class="btn btn-light m-2">Inscription</a>

                        </li>

                        <li class="nav-item">

                            
                            <a href="" class="btn btn-danger m-2">Connexion</a>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <div class="container py-4 justify-content-center">