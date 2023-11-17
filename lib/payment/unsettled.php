<div class="mt-4 mb-2"></div>
<table id="paidTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Paid On</th>
            <th>Cost</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">

        <?php
        $select = $pdo->prepare("SELECT * FROM fees_list WHERE year_included = '$year_level' OR  year_included = 5 ORDER BY fees_id ASC");
        $select->execute();

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $a = 0;
            $fees_id = [$row["fees_id"]];
            $title = [$row["fees_title"]];
            $description = [$row["fees_description"]];
            $cost = [$row["cost"]];
            $deadline = [$row["deadline"]];

            $checkStatus = $pdo->prepare("SELECT * FROM payment_list WHERE student_id = $id AND fees_id = $fees_id[$a] ORDER BY date ASC");
            $checkStatus->execute();

            $result = $checkStatus->fetchAll();
            if (empty($result)) {
        ?>
            <?php
            } elseif ($result[0]['status'] == 1) {
                $balance = [$cost[$a] - $result[0]['cost']];
            ?>
                <tr>
                    <td><?php echo $title[$a]; ?></td>
                    <td><?php echo $description[$a]; ?></td>
                    <td><?php echo $result[0]['date']; ?></td>
                    <td><?php echo $result[0]['cost']; ?></td>
                </tr>
        <?php

            }

            $a++;
        }
        ?>

    </tbody>
</table>