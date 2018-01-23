<?php

include 'connect.php';
include 'header.php';

mysqli_query($baza,"SET CHARSET 'utf8'");
$sql = "SELECT
            cat_id,
            cat_name,
            cat_desc
        FROM
            categories
        WHERE
              cat_id = " . $_GET['id'];

$result = mysqli_query($baza,$sql);

if(!$result)
{
    echo 'Nie można wyświetlić działu. Spróbuj ponownie później.';
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
        echo 'Taki dział nie istnieje';
    }
    else
    {
        //wyświetla tematy
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Wątki w  ′' . $row['cat_name'] . '′ </h2>';
        }

        $sql = "SELECT
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . $_GET['id'];

        $result = mysqli_query($baza,$sql);

        if(!$result)
        {
            echo 'Nie można wyświetlić tematów.Spróbuj ponownie później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'Nie ma tematów w tym dziale.';
            }
            else
            {
                echo '<div class="table-responsive">';
                echo '<table class="table">
                    <thead>
                      <tr>
                        <th>Temat</th>
                        <th>Stworzony</th>
                      </tr>
              </thead>';

                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>';
                    echo '<h4><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h4>';
                    echo '</td>';
                    echo '<td>';
                    echo date('d-m-Y', strtotime($row['topic_date']));
                    echo '</td>';
                    echo '</tr>';
                    echo '</tbody>';
                }
                echo '</table>';
                echo '</div>';
            }
        }
    }
}

include 'footer.php';
?>