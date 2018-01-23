<!DOCTYPE html>
<?php


include 'connect.php';
include 'header.php';
echo '<h2>Zaloguj się</h2>';


// test czy użytkownik już jest zalogowany
if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Jesteś zalogowany, możesz się <a href="signout.php"> wylogować </a>';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        // Stworzenie formularza
        echo '<form class="form-horizontal" role="form" method="post" action="">
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_name">Nazwa użytkownika:</label>
        <div class="col-sm-10"><input type="text" name="user_name" placeholder="Wpisz nazwę użytkownika"/>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_pass" >Hasło:</label>
        <div class="col-sm-10">
        <input type="password" name="user_pass" placeholder="Wpisz hasło">
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" value="Zaloguj się">Zaloguj się!</button>
        </div>
        </div>
     </form>';
    }
    else
    {
        // Test na poprawne wypełnienie pól
        $errors = array();

        if(!isset($_POST['user_name']))
        {
            $errors[] = 'Musisz podać login';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'Musisz podać hasło.';
        }

        if(!empty($errors))
        {
            echo 'Wystąpil błąd';
            echo '<ul>';
            foreach($errors as $key => $value)
            {
                echo '<li>' . $value . '</li>';
            }
            echo '</ul>';
        }
        else
        {
            //Walidacja danych
            $sql = "SELECT user_id, user_name,user_lvl from users where user_name = '" . mysqli_real_escape_string($baza,$_POST['user_name']) . "'
     AND user_pass = '" . sha1($_POST['user_pass']) . "'";

            $result = mysqli_query($baza,$sql);
            if(!$result)
            {
                echo 'Coś poszło nie tak. Spróbuj ponownie później';
                echo "Error: Our query failed to execute and here is why: \n";
                echo "Query: " . $sql . "\n";
                echo "Errno: " . $baza->errno . "\n";
                echo "Error: " . $baza->error . "\n";
            }
            else
            {
                //nieprawidłowe dane
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'Podałeś nieprawidłowe dane. Spróbuj jeszcze <a href="signin.php"> raz</a>';
                }
                else
                {

                    $_SESSION['signed_in'] = true;

                    //zapisuje informacje o użytkowniku do sesji by móc je później wykorzystać
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_lvl'] = $row['user_lvl'];
                    }

                    echo 'Witaj ' . $_SESSION['user_name'] . '! <a href="index.php">Przejdź do forum</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>