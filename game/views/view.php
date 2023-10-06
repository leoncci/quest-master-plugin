<?php

use models\Chest;
use models\Monster;

require_once '../controllers/controller.php';
require_once '../models/Player.php';
require_once '../models/Monster.php';
require_once '../models/Chest.php';
require_once '../db/connect.php';
$path = preg_replace( '/wp-content(?!.*wp-content).*/', '', __DIR__ );
require_once( $path . 'wp-load.php' );

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
            <!-- Button to trigger the modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemModal">
                Show Items
            </button>
            <!-- Modal -->
            <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="itemModalLabel">Munissez vous d'une arme</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Item cards go here -->
                            <div class="card-deck">
                                <?php
                                global $wpdb;
                                $table_name = $wpdb->prefix . 'shop';
                                $items = $wpdb->get_results("SELECT * FROM $table_name");

                                if (!empty($items)) {
                                    foreach ($items as $item) {
                                        echo '<div class="card">';
                                        echo '<div class="card-body">';
                                        echo '<h3 class="card-title">'.$item->name. '</h3>';
                                        echo '<p class="card-text">Puissance: ' . $item->power . '</p>';
                                        echo '<p class="card-text">Vie: ' . $item->health . '</p>';
                                        echo '<p class="card-text">Prix: $' . $item->price . '</p>';
                                        echo '<button class="btn btn-primary btn-buy" data-item-id="<?php echo $item->id; ?>" data-item-power="<?php echo $item->power; ?>" data-item-health="<?php echo $item->health; ?>" data-item-price="<?php echo $item->price; ?>">Buy</button>
';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p>No items available in the shop.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <div class="row">

    </div>
    <br />

</body>

</html>