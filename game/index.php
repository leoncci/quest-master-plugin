<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIND THE TREASURE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div>


    <div class="row mt-4">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <div class="header">
                <h1 class="text-primary" style=" text-align: center;">Find the Treasure</h1>
                <hr class="border border-primary border-2 opacity-75">
            </div>

            <form action="<?php echo plugins_url('controllers/controller.php', __FILE__); ?>" method="post"
                  class="w-50 mx-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="">Username</span>
                    </div>
                    <input type="text" class="form-control" name="username" id="usernameInput">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Commencer une partie</button>
            </form>
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
                        <!-- Autres colonnes de votre tableau -->
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="contenu">
    </div>
</div>
</body>

</html>
