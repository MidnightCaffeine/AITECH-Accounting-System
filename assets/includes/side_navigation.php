<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link 
            <?php
            if ($page != 'Home') {
                echo 'collapsed';
            }
            ?>
            " href="home.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

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

        <li class="nav-item">
            <a class="nav-link 
            <?php
            if ($page != 'Logs') {
                echo 'collapsed';
            }
            ?>
            " href="logs.php">
                <i class="bi bi-file-earmark-richtext"></i>
                <span>Log</span>
            </a>
        </li>
    </ul>
</aside>