<?php

use models\Chest;
use models\Monster;

require_once '../controllers/controller.php';
require_once '../models/Player.php';
require_once '../models/Monster.php';
require_once '../models/Chest.php';
require_once '../db/connect.php';

$monster = new Monster();
$chest = new Chest();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monster Game</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public\css\style.css">
    <style>
        @font-face {
            font-family: 'Gothic';
            src: url('../public/assets/fonts/gothic.ttf') format('truetype');
            /* You can also use 'woff' format for broader browser support */
        }

        .title {
            font-family: 'Gothic', sans-serif;
            font-weight:900;
            font-size: 70px;
            /* Use 'Gothic' as the font-family name */
        }
    </style>
</head>

<body>

    <div class="row mt-">
        <div class="col-3">

        </div>
        <div class="col-6">
            <!-- <div class="text-center">
                <a href="../index.php"><img src="../public/assets/bandeau.jpg" alt="Logo" style="width: 100%;"></a>
            </div> -->
        </div>
    </div>

    <div class="container text-center">
        <div class="header">
            <h1 class=" title" style=" text-align: center;">Quest Master</h1>
            <hr class="border border-dark border-2 opacity-75">
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="game-board">
                    <?php
                    $boardSize = 21;
                    for ($row = 1; $row < $boardSize; $row++) {

                        for ($col = 1; $col < $boardSize; $col++) {
                            echo '<div class="cell';
                            if ($player->getPositionX() === $col && $player->getPositionY() === $row) {
                                echo ' player"><img src="../public/assets/sword_player.png"">';
                            } elseif ($chest->getPositionX() === $col && $chest->getPositionY() === $row) {
                                echo ' chest"><img src="../public/assets/bloquer.png"width="100%"" >';
                            } else {
                                $isMonsterHere = false;
                                foreach ($monster->getMonsters() as $monsterData) {
                                    if ($monsterData["positionX"] === $col && $monsterData["positionY"] === $row) {
                                        $isMonsterHere = true;
                                        break;
                                    }
                                }
                                if ($isMonsterHere) {
                                    echo ' monster"><img src="../public/assets/bloquer.png"width="100%"">';
                                } else {
                                    echo '">';
                                }
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-3" style="right: 90px;">

                <p>Déplacez-vous sur la carte :</p>
                <div class="w-100 mx-auto text-center">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="../controllers/controller.php?direction=0"><i class="fa-solid fa-arrow-up fa-3x black "></i></a>
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <a href="../controllers/controller.php?direction=3"><i class="fa-solid fa-arrow-left fa-3x black"></i></a>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="../controllers/controller.php?direction=1"><i class="fa-solid fa-arrow-right fa-3x black"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="../controllers/controller.php?direction=2"><i class="fa-solid fa-arrow-down fa-3x black"></i></a>
                        </div>
                        <div class="col-4"></div>
                    </div>
                    <!-- Reset button -->

                    <div class="row"></div>
                </div>
                <p>Vos caractéristiques :</p>
                <div>
                    <div class="col-md-12 text-center mt-4" id="carac">
                        <i class="fa-solid fa-heart fa-2x" style="color: red;">&nbsp;<?= $player->getPV() ?></i>
                        <br />
                        <br />
                        <i class="fa-solid fa-bolt fa-2x" style="color: orange;">&nbsp;<?= $player->getPower() ?></i>
                        <br />
                        <br />
                        <i class="fa-solid fa-2x" style="color: blue;">XP&nbsp;<?= $player->getXp() ?></i>
                    </div>
                </div>
                <br>
                <div class="border border-rounded p-3" style="width: 100%;">
                    <?= findChest() ?>
                </div>
                <div class="w-100 mx-auto text-center mt-3">
                    <a class="btn btn-danger" href="../controllers/controller.php?reset=true">Nouvelle Partie</a>
                </div>
            </div>

        </div>
    </div>
    <!-- Inside your modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Modal content...</p>
            <button id="redirectButton">Continue</button>
        </div>
    </div>
    <script>

    </script>
    <!-- <div style="text-align: center; padding-top: 20px;">
        <img src="../public/assets/footer.jpg" alt="Logo">
    </div> -->

    <?php ?>

    <script src="../public/script.js"></script>

    <div class="row">

    </div>
    <br />

</body>

</html>