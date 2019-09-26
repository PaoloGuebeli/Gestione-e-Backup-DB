<?php
    require_once ('controllers/login.php');
    $login = new login();
    if(!isset($first)){
        $first = false;
    }
    $invalid = true;
    if($first){
        $invalid = false;
    }else{
        if($login->check()){
            $invalid = false;
        }
    }
    if($invalid){
        $login->index();
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CPT backup manager - Home</title>
    <link type="text/css" href="<?php echo URL?>/libraries/fontawesome-free-5.10.2-web/css/all.css" rel="stylesheet">
    <script src="<?php echo URL?>/libraries/jquery-3.4.1.min.js"></script>
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

        .spacing-bottom-sm{
            margin-bottom: 2%;
        }

        div.navbar {
            position: sticky;
            top: 0;
            left: 0;
            font-size: 20px;
            box-shadow: 0 10px 30px 2px rgba(0,0,0,0.2);
            background-color: rgba(255,255,255,0.8);
        }

        div.bar{
            margin: 5px;
            margin-left: 40px;
            float: left;
        }

        div.profile{
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
        }

        .dashboard table{
            border-radius: 2px;
            width: 80vw;
        }
        
        .dashboard tr:hover{
            box-shadow: 0 0 10px 3px #ccc;
        }

        .dashboard tr:nth-child(even){
            background-color: #eee;
        }

        .dashboard td{
            text-align: center;
            width: 20vw;
            cursor: pointer;
        }

        .dashboard td{
            padding: 15px;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }

        .error{
            border-left: 10px solid red !important;
        }

        .success{
            border-left: 10px solid greenyellow !important;
        }

        #war{
            width: 25vw;
            z-index: 10;
            position: fixed;
            top: 60px;
            left: calc(100vw - 25vw - 20px);
            //display: none;
            background-color: #fff;
            box-shadow: 0 0 10px 3px rgba(0,0,0,0.2);
            display: none;
        }

        #war ul{
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        #war li{
            padding: 15px;
            transition: 0.2s;
            cursor: pointer;
        }
        
        #war li:hover{
            border-left: 5px solid #6ce;
        }

        .ta-center{
            text-align: center;
        }

        .active {
            color: black !important;
            font-weight: bold;
        }

        .active:hover{
            border: none !important;
            margin-left: 1px !important;
            margin-right: 1px !important;
        }

        <?php if(isset($alerts)) { ?>
        .fa-bell{
            color: rgba(255,0,0,0.8);
        }
        <?php } ?>

        a{
            color: black;
            text-decoration: none;
        }

    </style>
</head>
<body>
<?php if(isset($alerts)) { ?>
<div id="war">
    <h3 class="ta-center">Notifiche</h3>
    <div class="spacing-bottom-sm">
        <ul>
            <?php
                foreach ($alerts as $alert) {
                    if ($alert['level'] == 2) {
                        if ($login->admin()) {
                            echo "<a href='".URL."users/home'><li>".$alert['content']."</li></a>";
                        }
                    } else {
                        echo
                        "<a href='".URL."backup/home'><li>".$alert['content']."</li></a>";
                     }
                }
            ?>
        </ul>
    </div>
</div>
<?php }?>
<div class="row navbar">
    <div class="bar">
        <ul>
            <li><a class="active"><span>Home</span></a></li>
            <li><a href="<?php echo URL?>backup/home"><span>Backups</span></a></li>
            <?php if($login->admin()): ?><li><a href="<?php echo URL?>users/home"><span>Utenti</span></a></li><?php endif; ?>
        </ul>
    </div>
    <div class="profile">
        <ul>
            <li><a><span><i class="fas fa-user"></i></span></a></li>
            <li><a id="bell"><span><i class="fas fa-bell"></i></span></a></li>
            <li><a href="<?php echo URL.'login/logout' ?>"><span><i class="fas fa-sign-out-alt"></i></span></a></li>
        </ul>
    </div>
</div>


<div class="row">
    <div class="dashboard  spacing-top-md spacing-left-md">
        <table cellspacing="0">
            <tr>
                <th>
                    NOME
                </th>
                <th colspan="2">
                    ULTIMO BACKUP
                </th>
                <th>
                    PROSSIMO BACKUP
                </th>
            </tr>
            <tr>
                <td class="success">
                    Backup sito supsi
                </td>
                <td>
                    10.09.2019
                </td>
                <td>
                    Eseguito con successo
                </td>
                <td>
                    15.09.2019
                </td>
            </tr>
            <tr>
                <td class="error">
                    Backup sito CPT
                </td>
                <td>
                    12.09.2019
                </td>
                <td>
                    Errore nell'esecuzione
                </td>
                <td>
                    13.09.2019
                </td>
            </tr>
        </table>
    </div>
</div>
</body>

<script>

    $('#bell').click(function () {
        $('#war').toggle(400);
    });
</script>
</html>
<?php } ?>