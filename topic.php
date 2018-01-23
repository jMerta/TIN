<?php

include 'connect.php';
include 'header.php';

mysqli_query($baza,"SET CHARSET 'utf8'");
$sql1 =  "SELECT
             topic_id,
             topic_subject
        FROM
             topics
        WHERE
             topics.topic_id = " . $_GET['id'];

$sql2 = "SELECT
                posts.post_topic,
                posts.post_content,
                posts.post_date,
                posts.post_by,
                users.user_id,
                users.user_name,
                users.user_lvl
        FROM
                posts
        LEFT JOIN
                 users
                ON
                posts.post_by = users.user_id
        WHERE
          posts.post_topic = " .  $_GET['id'];


$result = $baza->query($sql1);

if(!$result= $baza->query($sql1))
{
    echo 'Nie można wyświetlić tematu. Spróbuj ponownie później.';
    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $baza->errno . "\n";
    echo "Error: " . $baza->error . "\n";
    exit;
}
else {
    if (mysqli_num_rows($result) == 0) {
        echo 'Taki temat nie istnieje';
    } else {
        //wyświetla tematy
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<h2>Posty w   ′' . $row['topic_subject'] . '′ </h2>';
        }


        $result2 = mysqli_query($baza, $sql2);


        if (!$result2) {
            echo 'Nie można wyświetlić tematów.Spróbuj ponownie później.';
        } else {
            if (mysqli_num_rows($result) == 0) {
                echo 'Nie ma tematów w tym dziale.';
            } else {

                echo '<table class="table table-condensed">';
                echo '<thead>
                                 <tr>
                                    <th>Autor</th>
                                    <th>Post</th>
                                 </tr>
                              </thead>';
                if ($stmt2 = $baza->prepare($sql2)) {
                    $stmt2->execute();
                    $stmt2->bind_result($id_post_topic, $post_content, $post_date, $post_by, $post_by_user_id, $post_by_name, $user_lvl);

                    while ($stmt2->fetch()) {
                        if ($user_lvl == 1) {
                            $ranga = "Admin";
                        } else {
                            $ranga = "Zwykły użytkownik";
                        }
                        echo '<tbody>';
                        echo '<tr>';
                        echo '<td>';
                        echo "<p>$post_by_name</p><p>$ranga</p><p>$post_date</p>";
                        echo '</td>';
                        echo '<td>';
                        echo "<p>$post_content</p>";
                        echo '</td>';
                        echo '</tr>';
                        echo '</tbody>';
                    }
                }
                echo '<tfoot>';
                echo "<tr><td>Odpowiedz w tym temacie </td>";
                echo '<td>';

                include 'reply.php';
                echo "</td></tr>";
                echo '</tfoot>';
                echo '</table>';

            }
        }
    }
}



include 'footer.php';
?>