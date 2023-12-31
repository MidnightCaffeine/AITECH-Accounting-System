<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link 
            <?php
            if ($page != 'Home') {
                echo 'collapsed';
            }
            ?>
            " href="<?php if ($_SESSION['userType'] == 1) {
                        echo 'admin_dashboard.php';
                    } else {
                        echo 'home.php';
                    } ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php
        if ($_SESSION['userType'] == 1) {
        ?>
            <li class="nav-item">
                <a class="nav-link
            <?php
            if ($page != 'Students') {
                echo 'collapsed';
            }
            ?>
            " href="students.php">
                    <i class="bi bi-people"></i>
                    <span>Students</span>
                </a>
            </li>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['userType'] == 1) {
        ?>
            <li class="nav-item">
                <a class="nav-link
            <?php
            if ($page != 'Fees') {
                echo 'collapsed';
            }
            ?>
            " href="fees.php">
                    <i class="bi bi-cash"></i>
                    <span>Fees</span>
                </a>
            </li>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['userType'] != 1) {
        ?>
            <li class="nav-item">
                <a class="nav-link 
            <?php
            if ($page != 'Payments') {
                echo 'collapsed';
            }
            ?>
            " href="payments.php">
                    <i class="bi bi-wallet2"></i>
                    <span>Payments</span>
                </a>
            </li>
        <?php
        }
        ?>

        <?php
        if ($_SESSION['userType'] == 1) {
        ?>
            <li class="nav-item">
                <a class="nav-link
            <?php
            if ($page != 'Backup And Restore') {
                echo 'collapsed';
            }
            ?>
            " href="backupAndRestore.php">
                    <i class="bi bi-file-zip"></i>
                    <span>Backup And Restore</span>
                </a>
            </li>
        <?php
        }
        ?>

        <li class="nav-item">
            <a class="nav-link 
            <?php
            if ($page != 'Logs') {
                echo 'collapsed';
            }
            ?>
            " href="<?php if ($_SESSION['userType'] == 1) {
                        echo 'logs.php';
                    } else {
                        echo 'client_logs.php';
                    } ?>">
                <i class="bi bi-file-earmark-richtext"></i>
                <span>Log</span>
            </a>
        </li>
    </ul>
</aside>