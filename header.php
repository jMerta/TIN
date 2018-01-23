

<?php

$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <meta charset="UTF-8"/>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <meta name="description" content="Forum na projekt z TIN">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Dosis:500' rel='stylesheet' type='text/css'>
    <link href="sticky-footer.css" rel="stylesheet">
    <link href="loader.css" rel="stylesheet">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="validator.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script type="text/javascript" src="loader.js"></script>
    <link href="validation.css" rel="stylesheet">
    <title>Forum na TIN(PHP)</title>
</head>
<body style="font-family: 'Open Sans', sans-serif;" onload="sleeper()">


<h1 style="font-family: 'Dosis', sans-serif; text-align: center;" >Jakub Merta<small> Projekt na TIN</small></h1>


<nav class="navbar navbar-inverse" style="height: auto">
    <div class="container-fluid">
        <div class="navbar-header">
    <p class="navbar-brand">Forum</p>
    </div>
    <ul class="nav navbar-nav">
        <li class="<?= ($activePage == 'index') ? 'active':''; ?>"><a href="index.php">Strona główna</a></li>
        <li class="<?= ($activePage == 'create_topic') ? 'active':''; ?>"><a href="create_topic.php">Nowy temat</a></li>
        <li class="<?= ($activePage == 'create_cat') ? 'active':''; ?>"><a href="create_cat.php">Nowy dział</a> </li>
</ul>
<ul class="nav navbar-nav navbar-right">


    <?php if($_SESSION['signed_in']){
    echo '<li><p class="navbar-brand">Witaj ' . $_SESSION['user_name'] . '! </p></li> <li> <a href="logout.php">Wyloguj się</a></li>';

    }
    else {
        echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Rejestracja</a></li>';
        echo '<li><a href="signin.php"><span class="glyphicon glyphicon-log-in"></span> Logowanie</a></li>';
    }
    ?>

</ul>
    </div>
</nav>
        <div class="container">

