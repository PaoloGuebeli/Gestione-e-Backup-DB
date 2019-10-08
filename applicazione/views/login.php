<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="<?php echo URL?>/images/logo.png">
    <title>CPT backup manager - Login</title>
    <script src="<?php echo URL?>/libraries/jquery-3.4.1.min.js"></script>
    <style>

        html, body {
            margin: 0;
            height: 100vh;
            padding: 0;
            background-color: #7df;
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

        .gray {
            background-color: #ccc;
        }

        .side {
            height: 100vh;
            background-color: #fff;
            border-right: 5px solid #6ce;
            width: 25%;
        }

        form {
            margin: 20px;
        }

        .title {
            text-align: left;
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
            background-color: #6cc7e6;
            border: none;
            border-radius: 10px;
            color: white;
        }

        input[type="submit"]:hover {
            box-shadow: 0px 0px 10px 3px rgba(0, 0, 0, 0.1);
        }

        .linked {
            color: dodgerblue;
            text-decoration: underline;
            cursor: pointer;
        }

        .linked:hover{
            color: #0870da;
        }

        .linked:active {
            color: gray;
        }

        #creationTab {
            <?php if(!isset($_POST['creationError'])): ?>display: none;<?php endif; ?>
        }

        .creationForm {
            background-color: #fff;
            border: solid 2px gray;
            border-radius: 10px;
            top: 20vh;
            left: 37.5vw;
            width: 25vw;
            height: 60vh;
            position: fixed;
            margin: 0;
        }


        #closeButton{
            display: none;
            position: fixed;
            top: 20px;
            left: calc(100vw - 50px);
            width: 20px;
            height: 20px;
            border: 1px solid black;
            background-color: rgba(200,10,10,0.6);
            color: white;
            z-index: 10001;
            padding-left: 11px;
            cursor: pointer;
        }

        #closeButton:hover{
            background-color: rgb(200,10,10);
        }
        
        .error{
            color: #a00;
            font-weight: bold;
        }

        @media only screen and (max-width: 1400px) {
            .side {
                width: 50%;
            }

            .creationForm {
                top: 10vh;
                left: 20vw;
                width: 60vw;
                height: 80vh;
            }
        }

        @media only screen and (max-width: 600px) {
            .side {
                width: 100%;
                border: none;
            }

            .creationForm {
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                border: none;
                border-radius: 0;
                background-color: rgba(255,255,255,0.7);
            }
        }
    </style>
</head>
<body>
<div class="cover" id="creationTab">
    <div id="closeButton"> X </div>
    <form method="post" action="<?php echo URL?>login/addUser" class="creationForm" id="creationForm">
        <div class="row spacing-top-lg spacing-left-xl col-8">
            <h2 class="title" style="text-align: left">RICHIEDI ACCOUNT</h2>
            <input class="spacing-top-sm" type="text" placeholder="Nome" name="name">
            <input class="spacing-top-sm" type="text" placeholder="Cognome" name="lastname">
            <input class="spacing-top-sm" type="text" placeholder="E-mail" name="email">
            <input class="spacing-top-sm" type="password" placeholder="Password" name="password">
            <div class="row spacing-top-md">
                <input class="col-4" type="submit" value="RICHIEDI">
            </div>
            <?php if(isset($_POST['creationError'])): ?><p class="error"><?php echo $_POST['creationError'] ?></p><?php endif; ?>
        </div>
    </form>
</div>
<div class="row" id="container">
    <div class="side" id="login">
        <div class="row">
            <center>
                <form action="<?php echo URL?>login/verify" method="post">
                    <div class="col-8 spacing-top-xl">
                        <h2 class="title">
                            CPT BACKUP MANAGER
                        </h2>
                        <input type="text" placeholder="E-mail" name="email">
                        <input class="spacing-top-sm" type="password" placeholder="Password" name="pass">
                        <?php if(isset($_POST['error'])): ?><p class="error"><?php echo $_POST['error'] ?></p><?php endif; ?>
                        <div class="linked spacing-top-sm" id="passReset">Hai dimenticato la password?</div>
                        <div class="row spacing-top-md">
                            <input class="col-4" type="submit" value="LOGIN">
                        </div>
                        <div class="linked spacing-top-md" id="new">Richiedere account</div>
                    </div>
                </form>
            </center>
        </div>
    </div>
</div>
</body>
<script>

    $('#new').click(function () {
        $('#creationTab').css('display', 'block');
        $('#closeButton').show();
    });

    $(document).mouseup(function(e)
    {
        var container = $('#creationTab');

        // if the target of the click isn't the container nor a descendant of the container
        if (!$('#creationForm').is(e.target) && $('#creationForm').has(e.target).length === 0 && !$('#new').is(e.target))
        {
            container.hide();
        }
    });

</script>
</html>