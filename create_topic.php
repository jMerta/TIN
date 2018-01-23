<?php

include 'connect.php';
include 'header.php';

echo '<h2>Stwórz nowy wątek</h2>';
if($_SESSION['signed_in'] == false)
{

    echo '<div id="loader"> </div>
<div style="display:none;" id="content" class="animate-bottom">Musisz się <a href="/forum/signin.php">zalogować</a> by stworzyć nowy wątek.
</div>';
}
else
{

    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {

        $sql = "SELECT
            cat_id,
            cat_name,
            cat_desc
        FROM
            categories;";

        $result = $baza->query($sql);

        if(!$result)
        {
            echo 'Problem z połączeniem do bazy danych.';
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $baza->errno . "\n";
            echo "Error: " . $baza->error . "\n";
            exit;
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                if($_SESSION['user_lvl'] == 1)
                {
                    echo '<div id="loader"> </div>
<div style="display:none;" id="content" class="animate-bottom">Brakuje działów. <a href="create_cat">Stwórz nowy </a></div>';
                }
                else
                {
                    echo '<div id="loader"> </div>
<div style="display:none;" id="content" class="animate-bottom">Admin musi stworzyć nowy dzial by można było tworzyć nowe tematy.</div>';
                }
            }
            else
            {
                $query ="Select cat_id, cat_name from categories;";

                echo '<div id="loader"> </div>
<div style="display:none;" id="content" class="animate-bottom">
<form class="form-horizontal" role="form" method="post" action="">
        <div class="form-group">
        <label class="control-label col-sm-2" for="topic_subject">Nazwa tematu:</label>
        <div class="col-sm-10"><input type="text" name="topic_subject" placeholder="Wpisz nazwę tematu"/>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="topic_cat" >Wybierz dział :</label>';
                echo '<div class="col-sm-10"> <select name="topic_cat">';
                if ($stmt = $baza->prepare($query)){
                    $stmt->execute();
                    $stmt->bind_result($id,$name);

                while($stmt->fetch()){
                echo '<option value="' . $id . '">' . $name . '</option>';
                }
                echo '</select>';
                $stmt->close();}
                echo '</div></div>

        <div class="form-group">
        <label class="control-label col-sm-2" for="post_content" />Treść posta</label>
        <div class="col-sm-10">
        <textarea name="post_content" placeholder="Wpisz treść posta"/></textarea>
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default" value="Stwórz temat">Stwórz temat!</button>
        </div>
        </div>
     </form>
     </div>';


            }
        }
    }
    else
    {

        $query  = "BEGIN WORK;";
        $result = $baza->query($query);

        if(!$result)
        {
            echo 'Wystąpił błąd podczas tworzenia tematu. Spróbuj ponownie później.';
        }
        else
        {
            $sql = "INSERT INTO
                        topics(topic_subject,
                               topic_date,
                               topic_cat,
                               topic_by)
                   VALUES('" . mysqli_real_escape_string($baza,$_POST['topic_subject']) . "',
                                CURRENT_TIMESTAMP(),
                               " . mysqli_real_escape_string($baza,$_POST['topic_cat']) . ",
                               " . $_SESSION['user_id'] . "
                               )";

            $result = $baza->query($sql);
            if(!$result)
            {
                echo 'Coś poszło nie tak. Proszę spróbować później.';
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $baza->errno . "\n";
            echo "Error: " . $baza->error . "\n";
                exit;
                $sql = "ROLLBACK;";
                $result = $baza->query($sql);
            }
            else
            {
                $topicid = mysqli_insert_id($baza);

                $sql = "INSERT INTO
                            posts(post_content,
                                  post_date,
                                  post_topic,
                                  post_by)
                        VALUES
                            ('" . mysqli_real_escape_string($baza,$_POST['post_content']) . "',
                                  CURRENT_TIMESTAMP(),
                                  " . $topicid . ",
                                  " . $_SESSION['user_id'] . "
                            )";
                $result = $baza->query($sql);

                if(!$result)
                {
                    echo 'Coś poszło nie tak. Proszę spróbować później.';
                    echo "Error: Our query failed to execute and here is why: \n";
                    echo "Query: " . $sql . "\n";
                    echo "Errno: " . $baza->errno . "\n";
                    echo "Error: " . $baza->error . "\n";
                    exit;
                    $sql = "ROLLBACK;";
                    $result = $baza->query($sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = $baza->query($sql);

                    echo 'Udało ci się stworzyć temat <a href="topic.php?id='. $topicid . '">Twój wątek</a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>