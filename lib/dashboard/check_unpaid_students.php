<?php
session_start();
include_once '../databaseHandler/connection.php';


if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];
    $year_include = $_POST['datas'][1];
    $year_group = "1st Year";

    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $fee_cost = $row["cost"];
    }

    $query = "SELECT s.student_id, s.firstname, s.lastname, s.middlename, s.year_group, s.section FROM students s LEFT  JOIN payment_list p ON s.student_id = p.student_id WHERE s.year_group = :year_group AND p.fees_id = :fees_id AND p.student_id is NULL";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':year_group', $year_group);
    $stmt->bindParam(':fees_id', $fees_id);
    if ($stmt->execute()) {

        $unpaid_students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($unpaid_students as $student) {
?>
            <tr>
                <th><?php echo $student['firstname'] . " " . $student['middlename'] . " " . $student['lastname']; ?></th>
                <th><?php echo  $student['year_group'] . " - " . $student['section']; ?></th>
                <th><?php echo $fee_cost; ?></th>
            </tr>
<?php
        }

        // while ($row = $unpaid->fetch(PDO::FETCH_ASSOC)) {
        // }
    }
}
?>