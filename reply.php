<?php

if(!$_SESSION['signed_in'])
{
    echo 'Zaloguj się by odpowiedzieć.';
}
else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        echo '<form class="form-horizontal" role="form" method="post" action="" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
        <div class="form-group">
        <label class="control-label col-sm-2" for="reply-content">Twoja odpowiedź:</label>
        <div class="col-sm-10"><textarea name="reply-content" placeholder="Napisz odpowiedź..." style="width: 100%";/></textarea>
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" value="Wyślij">Wyślij!</a></button>
        </div>
        </div>
     </form>';
    } else {

        mysqli_query($baza,"set names 'utf8'");
        $sql = "
                    INSERT INTO
                    posts(post_content,
                          post_date,
                          post_topic,
                          post_by)
                VALUES ('" . $_POST['reply-content'] . "',
                        NOW(),
                        " . mysqli_real_escape_string($baza, $_GET['id']) . ",
                        " . $_SESSION['user_id'] . ")";

        if (!$result = $baza->query($sql)) {
            echo 'Coś poszło nie tak. Sprobuj ponownie.';
            mysqli_close($baza);
        } else {
            mysqli_close($baza);
            echo 'Wysłano odpowiedź w temacie. Kliknij   <a href="topic.php?id=' . htmlentities($_GET['id']) . '">TUTAJ</a> aby sprawdzić.';
        }


    }
}


?>