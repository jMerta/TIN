<?php

include 'connect.php';
$errors = array();
if(isset($_POST['user_name']))
{
    if(!ctype_alnum($_POST['user_name']))
    {
        $errors[] = 'Login może zawierać tylko litery i cyfry.';
    }
    if(strlen($_POST['user_name']) > 30)
    {
        $errors[] = 'Za długi nick';
    }
    if(strlen($_POST['user_name']) < 2)
    {
        $errors[] = 'Login musi być dłuższy niż 2 znaki';
    }
}
else
{
    $errors[] = 'Nie może być pusty.';
}
if(isset($_POST['user_pass']))
{
    if($_POST['user_pass'] != $_POST['user_pass_check'])
    {
        $errors[] = 'Hasła nie są identyczne.';
    }
}
else
{
    $errors[] = 'Hasło musi być wpisane.';
}
if(!empty($errors)) //sprawdza czy są błędy i je wypisuje
{
    echo 'W formularzu są błędy';
    echo '<ul>';
    foreach($errors as $key => $value)
    {
        echo '<li>' . $value . '</li>';
    }
    echo '</ul>';
    echo 'Wróc do <a href="signup.php"> rejestracji</a>';
}
else
{
//    $username = mysqli_real_escape_string($baza,);
//    $user_email = mysqli_real_escape_string($baza,);
    //zapisuje konto

    $query  = "BEGIN WORK;";
    $result = $baza->query($query);

    $sql = "INSERT INTO
                    users(user_name, user_pass, user_email, user_date)
                VALUES('" . mysqli_real_escape_string($baza,$_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysqli_real_escape_string($baza,$_POST['user_email']) . "',
                        CURRENT_TIMESTAMP())";
    $result = $baza->query($sql);
    if(!$result)
    {
        //błąd
        echo 'Coś poszło nie tak. Proszę spróbować później.';

            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
//            echo $username;
            echo "Errno: " . $baza->errno . "\n";
            echo "Error: " . $baza->error . "\n";
        exit;
    }
    else
    {

        $sql = "COMMIT;";
        $result = $baza->query($sql);

        echo 'Rejestracja się powiodła. Możesz się teraz zalogować <a href="signin.php">Zaloguj się</a> i uczestniczyć w forum';
    }
}


?>