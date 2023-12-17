<?php
session_start();
include_once '../databaseHandler/connection.php';

if (isset($_POST['datas'][0])) {

    $fees_id = $_POST['datas'][0];
    $year_group = "1st Year";

    $fee_query = "SELECT * FROM fees_list WHERE fees_id = $fees_id";
    $fee = $pdo->prepare($fee_query);
    $fee->execute();
    while ($row = $fee->fetch(PDO::FETCH_ASSOC)) {
        $fee_cost = $row["cost"];
        $year_include = $row["year_included"];
    }

    if ($year_include == 'All' || $year_include == $year_group) {
        $query = "SELECT * FROM payment_list WHERE fees_id = $fees_id";
        $paid = $pdo->prepare($query);
        if ($paid->execute()) {

            $result = $paid->fetchAll();
            foreach ($result as $row) {
                $year = $row['year_level'];
                if (!empty($result)) {
                    if ($year == $year_group) {
?>
                        <tr>
                            <th><?php echo $row['fullname']; ?></th>
                            <th><?php echo  $row['year_level'] . " - " . $row['section']; ?></th>
                            <th><?php echo  $fee_cost - $row['cost']; ?></th>
                        </tr>

                    <?php
                    } else {
                    ?>
                        <tr>
                            <td colspan="3">
                                <?php echo "No Data Found"; ?>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="3">
                            <?php echo "No Data Found"; ?>
                        </td>
                    </tr>
        <?php
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
