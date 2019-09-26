<?php
require_once('controllers/login.php');
$login = new login();
if (!$login->check()) {
    require("login.php");
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>CPT backup manager - Backups</title>
        <link type="text/css" href="<?php echo URL ?>/libraries/fontawesome-free-5.10.2-web/css/all.css"
              rel="stylesheet">
        <script src="<?php echo URL ?>/libraries/jquery-3.4.1.min.js"></script>
        <style>
            html, body {
                margin: 0;
                height: 100vh;
                padding: 0;
                background-color: white;
                font-family: "Trebuchet MS";
            }

            .row {
                width: 100%;
            }

            div {
                display: inline-block;
                margin: 0;
                padding: 0;
                border: 0;
            }

            .col-1 {
                width: 8%;
            }

            .col-2 {
                width: 16%;
            }

            .col-3 {
                width: calc(25% - 2px);
            }

            .col-4 {
                width: 33%;
            }

            .col-5 {
                width: 41%;
            }

            .col-6 {
                width: 49%;
            }

            .col-7 {
                width: 58%;
            }

            .col-8 {
                width: 66%;
            }

            .col-9 {
                width: calc(75% - 2px);
            }

            .col-10 {
                width: 83%;
            }

            .col-11 {
                width: 91%;
            }

            .col-12 {
                width: 100%;
            }

            .spacing-top-sm {
                margin-top: 2%;
            }

            .spacing-top-md {
                margin-top: 4%;
            }

            .spacing-top-lg {
                margin-top: 8%;
            }

            .spacing-top-xl {
                margin-top: 16%;
            }

            .spacing-left-sm {
                margin-left: 2%;
            }

            .spacing-left-md {
                margin-left: 4%;
            }

            .spacing-left-lg {
                margin-left: 8%;
            }

            .spacing-left-xl {
                margin-left: 16%;
            }

            .spacing-bottom-sm {
                margin-bottom: 2%;
            }

            div.navbar {
                position: sticky;
                top: 0;
                left: 0;
                font-size: 20px;
                box-shadow: 0 10px 30px 2px rgba(0, 0, 0, 0.2);
                background-color: rgba(255, 255, 255, 0.8);
            }

            div.bar {
                margin: 5px;
                margin-left: 40px;
                float: left;
            }

            div.profile {
                float: right;
                margin: 5px;
                margin-right: 40px;
            }

            div.navbar ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            div.navbar ul li {
                float: left;
            }

            div.navbar ul li a {
                display: block;
                color: #666;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
                margin-left: 1px;
                margin-right: 1px;
                cursor: pointer;
            }

            div.navbar div.bar ul li a:hover {
                color: black;
                margin: 0;
                border-right: 1px solid #ccc;
                border-left: 1px solid #ccc;
            }

            div.navbar div.profile ul li a:hover {
                color: black;
                font-weight: bold;
            }


            .error {
                background-color: #fba !important;
            }

            .success {
                background-color: #afc !important;
            }

            #war {
                width: 25vw;
                z-index: 10;
                position: fixed;
                top: 60px;
                left: calc(100vw - 25vw - 20px);
                display: none;
                background-color: #fff;
                box-shadow: 0 0 10px 3px rgba(0, 0, 0, 0.2);
            }

            #war ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
            }

            #war li {
                padding: 15px;
                transition: 0.2s;
                cursor: pointer;
            }

            #war li:hover {
                border-left: 5px solid #6ce;
            }

            .ta-center {
                text-align: center;
            }

            .active {
                color: black !important;
                font-weight: bold;
            }

            .active:hover {
                border: none !important;
                margin-left: 1px !important;
                margin-right: 1px !important;
            }

            .dashboard span {
                padding: 10%;
                cursor: pointer;
            }

            span:hover .fa-times {
                color: red;
            }

            span:hover .fa-pencil-alt {
                color: orange;
            }

            span:hover .fa-check {
                color: green;
            }

            .dashboard {
                border-radius: 2px;
                width: 80vw;
            }

            .dashboard tr:hover {
                box-shadow: 0 0 10px 3px #ccc;
            }

            .dashboard tr:nth-child(even) {
                min-width: 10vw;
                background-color: #eee;
            }

            .dashboard td {
                text-align: center;
                width: 20vw;
                padding: 15px;
                border-left: 1px solid #ccc;
                border-right: 1px solid #ccc;
            }

            .error {
                border-left: 10px solid red !important;
            }

            .success {
                border-left: 10px solid greenyellow !important;
            }

            .modify {
                display: none;
                width: 100%;
            }

            <?php if(isset($alerts)) { ?>
            .fa-bell {
                color: rgba(255, 0, 0, 0.8);
            }

            .fa-bell:hover {
                color: rgb(200, 0, 0);
            }

            <?php } ?>

            a {
                color: black;
                text-decoration: none;
            }

            .hide {
                display: none;
            }

            input[type="text"], input[type="password"] {
                background-color: #eee;
                padding: 8px;
                border-radius: 8px;
                border: 2px solid lightgray;
                width: 100%;
            }

            input:active {
                border-color: #eee;
            }

            input {
                outline: none;
            }

            input[type="submit"] {
                padding: 10px;
                background-color: orange;
                border: none;
                border-radius: 10px;
                color: white;
            }

            input[type="submit"]:hover {
                box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.1);
            }

        </style>
    </head>
    <body>
    <?php if (isset($alerts)) { ?>
        <div id="war">
            <h3 class="ta-center">Notifiche</h3>
            <div class="spacing-bottom-sm">
                <ul>
                    <?php
                    foreach ($alerts as $alert) {
                        if ($alert['level'] == 2) {
                            if ($login->admin()) {
                                echo "<a href='" . URL . "users/home'><li>" . $alert['content'] . "</li></a>";
                            }
                        } else {
                            echo
                                "<a href='" . URL . "backup/home'><li>" . $alert['content'] . "</li></a>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    <div class="row navbar">
        <div class="bar">
            <ul>
                <li><a href="<?php echo URL . 'login/index' ?>"><span>Home</span></a></li>
                <li><a href="<?php echo URL . 'backup/home' ?>"><span>Backups</span></a></li>
                <li><a class="active"><span>Utenti</span></a></li>
            </ul>
        </div>
        <div class="profile">
            <ul>
                <li><a><span><i class="fas fa-user"></i></span></a></li>
                <li><a id="bell"><span><i class="fas fa-bell"></i></span></a></li>
                <li><a href="<?php echo URL . 'login/logout' ?>"><span><i class="fas fa-sign-out-alt"></i></span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <table class="spacing-left-md spacing-top-md dashboard" cellspacing="0">
            <tr>
                <th>
                    NOME
                </th>
                <th>
                    E-MAIL
                </th>
                <th>
                    TIPO
                </th>
                <th>
                    AZIONI
                </th>
            </tr>
            <?php
            foreach ($users as $user):?>
                <tr>

                    <td>
                        <?php echo $user['name'] . ' ' . $user['lastname'] ?>
                    </td>
                    <td>
                        <?php echo $user['email'] ?>
                    </td>
                    <td>
                        <?php if ($user['access'] == 0) {
                            echo 'Disabilitato';
                        } elseif ($user['access'] == 1) {
                            echo 'Responsabile';
                        } else {
                            echo 'Amministratore';
                        } ?>
                    </td>
                    <td>
                        <?php if ($user['access'] == 0): ?>
                        <center><span><a href="<?php echo URL . "users/verify/" . $user['id'] ?>"><i
                                            class="fa fa-check"> </i></a></span><?php endif; ?>
                            <a onclick="modifyTab('<?php echo "#um" . $user['id'] ?>')"><span><i
                                            class="fas fa-pencil-alt"> </i></span></a><?php if ($user['pass'] != $_COOKIE['backup_site']): ?>
                                <span><a href="<?php echo URL . "users/delete/" . $user['id'] ?>"><i
                                            class="fas fa-times"> </i></a></span><?php endif; ?></center>
                    </td>
                </tr>
                <tr class="hide" id="<?php echo "um" . $user['id'] ?>">
                    <form action="<?php echo URL."users/modify/".$user['id'] ?>" method="post">
                        <td><input type="text" placeholder="<?php echo $user['name'] ?>" style="width: 40%" name="mName">
                            <input class="spacing-left-sm" type="text" placeholder="<?php echo $user['lastname'] ?>"
                                   style="width: 40%" name="mLastname"></td>
                        <td><input type="text" placeholder="<?php echo $user['email'] ?>" style="width: 80%" name="mEmail"></td>
                        <td>
                            <select name="mAccess">
                                <option value="2" <?php if ($user['access'] == 2){echo "selected"; }?>>Amministratore</option>
                                <?php if ($user['pass'] != $_COOKIE['backup_site']): ?>
                                    <option value="1" <?php if ($user['access'] == 1){echo "selected"; }?>>Responsabile</option>
                                    <option value="0" <?php if ($user['access'] == 0){echo "selected"; }?>>Disabilitato</option>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td><input type="submit" value="modifica"></td>
                    </form>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    </body>
    <script>

        $('#bell').click(function () {
            $('#war').toggle(400);
        });

        function modifyTab(id) {
            $(id).slideToggle();
        }
    </script>
    </html>
<?php } ?>