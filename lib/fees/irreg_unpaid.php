<?php
session_start();
include_once '../databaseHandler/connection.php';


if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];

    $year_group = "Irregular";

    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $fee_cost = $row["cost"];
        $year_include = $row["year_included"];
    }
    if ($year_include == 'All' || $year_include == $year_group) {

        $query = "SELECT s.student_id, s.firstname, s.lastname, s.middlename, s.year_group, s.section 
    FROM students s 
    WHERE NOT EXISTS (
        SELECT 1 
        FROM payment_list p 
        WHERE s.student_id = p.student_id 
        AND p.fees_id = :fees_id
    );";
        $stmt = $pdo->prepare($query);
        // $stmt->bindParam(':year_group', $year_group);
        $stmt->bindParam(':fees_id', $fees_id);
        if ($stmt->execute()) {

            $unpaid_students = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($unpaid_students)) {
                echo "No Data Found";
            } else {

                foreach ($unpaid_students as $student) {
                    if ($student['year_group'] == $year_group) {

?>
                        <tr>
                            <th><?php echo $student['firstname'] . " " . $student['middlename'] . " " . $student['lastname']; ?></th>
                            <th><?php echo  $student['year_group'] . " - " . $student['section']; ?></th>
                            <th><?php echo $fee_cost; ?></th>
                        </tr>
        <?php
                    }
                }
            }
        }
    } else {
        ?>
        <tr>
            <td colspan="3">
                <?php echo "This Year Group Is Not Included on The Fee"; ?>
            </td>
        </tr>
<?php
    }
}
