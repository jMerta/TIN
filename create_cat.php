<!DOCTYPE html>
<?php

include 'connect.php';
include 'header.php';
if($_SESSION['user_lvl'] == 1) {
    echo '<h2>Stwórz nowy dział</h2>';
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo '
<div id="loader"> </div>
<div style="display:none;" id="content" class="animate-bottom">
        <div class="form-group">
        <label class="control-label col-sm-2" for="cat_name">Nazwa działu:</label>
        <div class="col-sm-10"><input type="text" name="cat_name" placeholder="Wpisz nazwę działu"/>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="cat_desc" >Opis działu:</label>
        <div class="col-sm-10">
        <textarea name="cat_desc" placeholder="Wpisz opis działu"/></textarea>
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" value="Add category">Dodaj dział!</button>
        </div>
        </div>
     </form>
    </div> ';
    } else {
        //zapisuje dział do db
        $sql = "INSERT INTO categories(cat_name, cat_desc)
       VALUES('" . mysqli_real_escape_string($baza, $_POST['cat_name']) . "',
             '" . mysqli_real_escape_string($baza, $_POST['cat_desc']) . "');";

        if (!$result = $baza->query($sql)) {
            //błąd
            echo 'Coś poszło nie tak. Proszę spróbować później.';/*
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $baza->errno . "\n";
            echo "Error: " . $baza->error . "\n";*/
            exit;
        } else {
            echo 'Powstał nowy dział';
        }
    }
}
else {
    echo "<h3>Tylko admin może dodawać nowe działy</h3>";
}
?>