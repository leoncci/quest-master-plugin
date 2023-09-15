<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lose</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php

    use models\Player;

    require_once "../models/Player.php"; // Include the Player class

    session_start(); // Start the session

    // Check if the player object is stored in the session
    if (isset($_SESSION['user'])) {
        $player = new Player($_SESSION['user']); // Create a new Player object using the user from session
    } else {
        echo "not working";
    }
    ?>
    <div class="header">
        <h1 class="text-primary" style="padding-top: 20px; text-align: center;">Find the Treasure</h1>
    </div>
    <div class="container">
        <hr class="border border-primary border-3 opacity-75">
        <h2 class="text-primary" style="padding-top: 20px; text-align: center;">
            <?php
            echo $player->getUser();
            if ($player->getWin()) {
                echo " à gagné avec " . $player->getXp() . " XP";
            } else {
                echo " à perdu";
            }
            ?>
        </h2>
        <div>
            <div style="text-align: center;">
                <form action="../controllers/controller.php" method="post" class="w-50 mx-auto">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="">Username</span>
                        </div>
                        <input type="text" class="form-control " name="username" id="usernameInput">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2 mx-auto">Commencer une partie</button>
                </form>
            </div>
        </div>
        <div class="col-md-3 pl-5 pr-5">
            <table class="table border">
                <thead class="thead-dark">
                <tr>
                    <th>Classement</th>
                    <th>Username</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}questmaster ORDER BY score DESC LIMIT 10");
                $position = 0;
                foreach ($results as $row) {
                    $position += 1;
                    ?>
                    <tr>
                        <td><?php echo $position; ?></td>
                        <td>
                            <?php
                            echo esc_html($row->username);
                            ?>
                        </td>
                        <td>
                            <?php
                            echo esc_html($row->score);
                            ?>
                        </td>

                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
