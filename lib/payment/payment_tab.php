<div class="mt-4 mb-2"></div>
<table id="paymentTable" class="display table table-bordered">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>To Pay</th>
            <th>Deadline</th>
            <th>Balance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">

        <?php
        $select = $pdo->prepare("SELECT * FROM fees_list WHERE year_included = '$year_level' OR  year_included = 'All' ORDER BY fees_id ASC");
        $select->execute();

        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $a = 0;
            $fees_id = [$row["fees_id"]];
            $title = [$row["fees_title"]];
            $description = [$row["fees_description"]];
            $cost = [$row["cost"]];
            $deadline = [$row["deadline"]];

            $checkStatus = $pdo->prepare("SELECT * FROM payment_list WHERE student_id = $id AND fees_id = $fees_id[$a] ");
            $checkStatus->execute();

            $result = $checkStatus->fetchAll();
            if (empty($result)) {
        ?>
                <tr>
                    <td><?php echo $title[$a]; ?> </td>
                    <td><?php echo $description[$a]; ?></td>
                    <td><?php echo $cost[$a]; ?></td>
                    <td><?php echo $deadline[$a]; ?></td>
                    <td><?php echo $cost[$a]; ?></td>
                    <td>
                        <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-success payNew me-2" name="pay_new">
                            <i class="bi bi-wallet2">
                                <span> Pay</span>
                            </i>
                        </button>
                    </td>
                </tr>
            <?php
            } elseif ($result[0]['status'] != 1) {
                $balance = [$cost[$a] - $result[0]['cost']];
            ?>
                <tr>
                    <td><?php echo $title[$a]; ?></td>
                    <td><?php echo $description[$a]; ?></td>
                    <td><?php echo $cost[$a]; ?></td>
                    <td><?php echo $deadline[$a]; ?></td>
                    <td><?php echo $balance[$a]; ?></td>
                    <td>
                        <button type="button" id="<?php echo $fees_id[$a]; ?>" class="btn btn-primary payNew me-2" name="pay_new">
                            <i class="bi bi-wallet2">
                                <span> Pay</span>
                            </i>
                        </button>
                    </td>
                </tr>
        <?php

            }

            $a++;
        }
        ?>

    </tbody>
</table>