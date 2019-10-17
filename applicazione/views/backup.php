<?php
require_once('controllers/login.php');
require_once('models/validate.php');
$login = new login();
if (!validate::check()) {
	$login->index();
} else {
	?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="shortcut icon" href="<?php echo URL ?>/images/logo.png">
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

            #closeButton {
                display: none;
                position: fixed;
                top: 50px;
                left: calc(100vw - 100px);
                width: 25px;
                height: 25px;
                border-radius: 10px;
                background-color: rgba(200, 10, 10, 0.8);
                color: white;
                z-index: 10001;
                padding: 7px 0 1px 14px;
                cursor: pointer;
            }

            #closeButton:hover {
                background-color: rgb(200, 10, 10);
            }

            .cover {
                background-color: rgba(0, 0, 0, 0.3);
                position: fixed;
                z-index: 10000;
                width: 100vw;
                height: 100vh;
                top: 0;
                left: 0;
            }

            #creationTab {
                <?php if(!isset($_POST['creationError'])): ?> display: none;
            <?php endif; ?>
            }

            .error {
                background-color: #fba !important;
            }

            .success {
                background-color: #afc !important;
            }

            a {
                color: black;
                text-decoration: none;
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

            span:hover .fa-file-alt {
                color: blue;
            }

            span:hover .fa-play {
                color: green;
            }

            .dashboard table {
                border-radius: 2px;
                width: 80vw;
            }

            .dashboard tr:hover {
                box-shadow: 0 0 10px 3px #ccc;
            }

            .dashboard tr:nth-child(even) {
                background-color: rgba(0, 200, 255, 0.1);
            }

            .dashboard td {
                text-align: center;
                width: 26vw;
            }

            .dashboard td {
                padding: 15px;
                border-left: 1px solid #ccc;
                border-right: 1px solid #ccc;
            }

            .modify {
                display: none;
                width: 100%;
            }

            .btn {
                background-color: limegreen;
                border: none;
                color: white;
                outline: none;
                border-radius: 20px;
                padding: 10px;
            }

            .round {
                padding: 8px 9px 8px 11px;
                width: 15px;
                border-radius: 20px;
            }

            .btn:hover {
                box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.1);
            }

            input {
                outline: none;
            }

            input[type="text"], input[type="password"] {
                background-color: #eee;
                padding: 8px;
                border-radius: 8px;
                border: 2px solid lightgray;
            }

            input:active {
                border-color: #eee;
            }

            <?php if(isset($alerts)) { ?>
            .fa-bell {
                color: rgba(255, 0, 0, 0.8);
            }

            <?php } ?>

            .creationForm {
                background-color: #fff;
                border: solid 2px gray;
                border-radius: 10px;
                top: 20vh;
                left: 30vw;
                width: 40vw;
                height: 60vh;
                position: fixed;
                margin: 0;
            }

            .hide{
                display: none;
            }

            select {
                border: 2px solid lightgray;
                background-color: #eee;
                padding: 8px;
                border-radius: 8px;
                outline: none;
            }

            select:hover {
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }


            @media only screen and (max-width: 1400px) {

                .creationForm {
                    top: 10vh;
                    left: 20vw;
                    width: 60vw;
                    height: 80vh;
                }
            }

            @media only screen and (max-width: 600px) {

                .creationForm {
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    border: none;
                    border-radius: 0;
                    background-color: rgba(255, 255, 255, 0.7);
                }
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
							if (validate::admin()) {
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
    <div class="cover" id="creationTab">
        <div id="closeButton"><i class="fa fa-times"></i></div>
        <form method="post" action="<?php echo URL ?>login/addUser" class="creationForm" id="creationForm">
            <div class="row spacing-top-lg spacing-left-xl col-8">
                <h2 class="title" style="text-align: left">Aggiungi DB</h2>
                <input type="text" placeholder="Nome" name="name">
                <input type="text" placeholder="Host" name="host">
                <input type="text" placeholder="Username" name="username">
                <input type="password" placeholder="Password" name="password">

                <h3 class="spacing-top-lg" style="margin-bottom: 0">Impostazioni</h3>
                <span class="spacing-top-md">Usa impostazioni esistenti: <input type="radio" id="ex" name="createSettings" checked onclick="toggleCreate()"></span>
                <span class="spacing-left-sm">Crea nuove impostazioni: <input id="cr" class="spacing-top-sm" type="radio"
                                                                              name="createSettings" onclick="toggleCreate()"></span>
                <div id="exists" class="row">
                    <select class="spacing-top-sm" name="settings">
						<?php foreach ($settings as $setting): ?>
                            <option value="2"><?php echo $setting['name'] ?></option>
						<?php endforeach; ?>
                    </select>
                </div>

                <div class="hide row spacing-top-sm" id="create">
                    <h4 style="margin: 0">NOME</h4>
                    <input type="text" placeholder="Nome" name="sName">
                    <h4 style="margin-bottom: 0" class="spacing-top-sm">GIORNI</h4>
                    <span class="spacing-left-sm"> LU <input type="checkbox"></span>
                    <span class="spacing-left-sm"> MA <input type="checkbox"></span>
                    <span class="spacing-left-sm"> ME <input type="checkbox"></span>
                    <span class="spacing-left-sm"> GI <input type="checkbox"></span>
                    <span class="spacing-left-sm"> VE <input type="checkbox"></span>
                    <span class="spacing-left-sm"> SA <input type="checkbox"></span>
                    <span class="spacing-left-sm"> DO <input type="checkbox"></span>
                    <h4 style="margin-bottom: 0" class="spacing-top-sm">ORA</h4>
                    <input type="time" id="stime" step="3600" name="sTime" required>
                </div>

                <div class="row spacing-top-md">
                    <input class="col-4 btn" type="submit" value="CREA">
                </div>
				<?php if (isset($_POST['creationError'])): ?><p
                        class="error"><?php echo $_POST['creationError'] ?></p><?php endif; ?>
            </div>
        </form>
    </div>
    <div class="row navbar">
        <div class="bar">
            <ul>
                <li><img src="<?php echo URL ?>/images/logo.png" alt="logo" width="50" height="50"/></li>
                <li><a href="<?php echo URL ?>login/index"><span>Home</span></a></li>
                <li><a class="active"><span>Backups</span></a></li>
				<?php if (validate::admin()): ?>
                    <li><a href="<?php echo URL ?>users/home"><span>Utenti</span></a></li><?php endif; ?>
            </ul>
        </div>
        <div class="profile">
            <ul>
                <li><a id="bell"><span><i class="fas fa-bell"></i></span></a></li>
                <li><a href="<?php echo URL . 'login/logout' ?>"><span><i class="fas fa-sign-out-alt"></i></span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row ">
        <form class="spacing-top-md spacing-left-md">
            <span><div class="btn round " id="new"><i class="fa fa-plus"></i></div></span>
            <span class="spacing-left-md">Cerca: <input type="text" placeholder="nome" name="mName"></span>
        </form>
        <table class="spacing-top-sm spacing-left-md dashboard" cellspacing="0">
            <tr>
                <th>
                    NOME
                </th>
                <th>
                    PROGRAMMA
                </th>
                <th>
                    AZIONI
                </th>
            </tr>
			<?php foreach ($databases as $database): ?>
                <tr>
                    <td>
						<?php echo $database['name']; ?>
                    </td>
                    <td>
						<?php
						$days = array("Lunedi", "Martedi", "Mercoledi", "Giovedi", "Venerdi", "Sabato", "Domenica");
						foreach ($settings as $setting) {
							if ($setting['id'] = $database['settings_id']) {
								echo "Full backup ogni " . $days[$setting['day']] . " alle " . $setting['hour'] . ".00";
							}
						}
						?>
                    </td>
                    <td>
                        <center><a href="<?php echo URL . "backup/startBackup/" . $database['id'] ?>"><span><i
                                            class="fa fa-play"> </i></span></a><span><i
                                        class="far fa-file-alt"> </i></span>
							<?php if (validate::admin()): ?><span><i class="fas fa-pencil-alt"> </i></span><span><i
                                        class="fas fa-times"> </i></span><?php endif; ?></center>
                    </td>
                </tr>
			<?php endforeach; ?>
        </table>
    </div>
    </body>
    <script>

        function toggleCreate(){
            if($('#ex').is(':checked')){
                $('#exists').show();
                $('#create').hide();
            }else{
                $('#exists').hide();
                $('#create').show();
            }
        }

        $('#bell').click(function () {
            $('#war').toggle(400);
        });

        $('#m1').click(function () {
            $('#ma1').slideToggle(100);
        });

        $('#l1').click(function () {
            $('#la1').slideToggle(100);
        });

        $('#new').click(function () {
            $('#creationTab').css('display', 'block');
            $('#closeButton').show();
        });

        $(document).mouseup(function (e) {
            var container = $('#creationTab');

            // Se il target non è il contenitore o un sotto contenitore lo chiude.
            if (!$('#creationForm').is(e.target) && $('#creationForm').has(e.target).length === 0 && !$('#new').is(e.target) && $('#new').has(e.target).length === 0) {
                container.hide();
            }
        });
    </script>
    </html>
<?php } ?>