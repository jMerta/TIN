<!DOCTYPE html>

<?php
include 'connect.php';
include 'header.php';

$sql = "SELECT
            cat_id,
            cat_name,
            cat_desc,
            (select topic_id from topics where topic_cat = categories.cat_id ORDER by topic_id desc limit 1) as topid,
            (select topic_subject from topics where topic_id=topid)
        FROM
            categories;";


$result = $baza->query($sql);
if(!$result = $baza->query($sql))
{
    echo 'Nie można wyświetlić działów. Spróbuj ponownie później.';
    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $baza->errno . "\n";
    echo "Error: " . $baza->error . "\n";
    exit;
}
else {
    if (mysqli_num_rows($result) == 0) {
        echo 'Nie ma działów.';
    } else {
        echo '<div class="table-responsive">';
        echo '<table class="table">
            <thead>
              <tr>
                <th>Dział</th>
                <th>Ostatni temat</th>
              </tr>
              </thead>';


        $result = mysqli_query($baza, $sql);
        if ($stmt = $baza->prepare($sql)) {
            $stmt->execute();
            $stmt->bind_result($id, $name, $desc,$topid,$sub);


            while ($stmt->fetch()) {

                echo '<tbody>';
                echo '<tr>';
                echo '<td >';
                echo "<h4><a href=category.php?id=$id> $name </a> <SMALL> $desc </SMALL></h4>";



                echo '</td>';
                        echo '<td>';
                        echo '<a href="topic.php?id=' . $topid . '">' . $sub . '</a>';
                        echo '</tr>';
                        echo '</td>';
                        echo '</tbody>';

                }
                echo '</table>';
                echo '</div>';
            }
        }

}
include 'footer.php';
?>