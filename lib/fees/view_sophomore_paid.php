<?php
session_start();
include_once '../databaseHandler/connection.php';

$sections = ["A", "B", "C", "D", "E", "F", "G", "H", "I"];

if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];


    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $fee_cost = $row["cost"];
    }

    $query = "SELECT * FROM payment_list WHERE fees_id = $fees_id";
    $paid = $pdo->prepare($query);
    if ($paid->execute()) {

        $result = $paid->fetchAll();
        foreach ($result as $row) {
            $year = $row['year_level'];
            if (!empty($result)) {
                if ($year == 2) {
?>
                    <tr>
                        <th><?php echo $row['fullname']; ?></th>
                        <th><?php echo  $row['year_level'] . " - " . $sections[$row['section'] - 1]; ?></th>
                        <th><?php echo  $fee_cost - $row['cost']; ?></th>
                    </tr>

<?php
                }
            }
        }
    }
}
