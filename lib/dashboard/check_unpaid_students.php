<?php
session_start();
include_once '../databaseHandler/connection.php';

$sections = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];

if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];
    $year_include = $_POST['datas'][1];

    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $fee_cost = $row["cost"];
    }

    $query = "SELECT * FROM students";
    $statement = $pdo->prepare($query);
    if ($statement->execute()) {

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $a = 0;
            $student_id = [$row["student_id"]];
            $firstname = [$row["firstname"]];
            $middlename = [$row["middlename"]];
            $lastname = [$row["lastname"]];
            $year_group = [$row["year_group"]];
            $section = [$row["section"]];

            $checkStatus = $pdo->prepare("SELECT * FROM payment_list WHERE student_id = $student_id[$a] AND fees_id = $fees_id");
            $checkStatus->execute();

            $result = $checkStatus->fetchAll();
            if (empty($result) && $year_include == 5 || $year_include == $year_group[$a]) {

?>
                <tr>
                    <th><?php echo $firstname[$a] . " " . $middlename[$a] . " " . $lastname[$a]; ?></th>
                    <th><?php echo  $year_group[$a] . " - " . $sections[$section[$a] - 1]; ?></th>
                    <th><?php echo $fee_cost; ?></th>
                </tr>
            <?php
            } elseif ($result[0]['status'] != 1 && $year_include == 5 || $year_include == $year_group[$a]) {
            ?>
                <tr>
                    <th><?php echo $firstname[$a] . " " . $middlename[$a] . " " . $lastname[$a]; ?></th>
                    <th><?php echo  $year_group[$a] . " - " . $sections[$section[$a] - 1]; ?></th>
                    <th><?php echo $fee_cost - $result[0]['cost']; ?></th>
                </tr>

<?php
            }


            $a++;
        }
    }
}
