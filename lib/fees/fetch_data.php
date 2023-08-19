<?php
// Database connection info 
$dbDetails = array(
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
    'db'   => 'aitech_payment'
);

// DB table to use 
$table = 'fees_list';

// Table's primary key 
$primaryKey = 'fees_id';

// Array of database columns which should be read and sent back to DataTables. 
// The `db` parameter represents the column name in the database.  
// The `dt` parameter represents the DataTables column identifier. 
$columns = array(
    array('db' => 'fees_title', 'dt' => 0),
    array('db' => 'fees_description',  'dt' => 1),
    array(
        'db'        => 'year_included',
        'dt'        => 2,
        'formatter' => function ($d, $row) {
            if ($d == 1) {
                $d = 'All';
            } elseif ($d == 2) {
                $d = '1st Year';
            } elseif ($d == 3) {
                $d = '2nd Year';
            } elseif ($d == 4) {
                $d = '3rd Year';
            } elseif ($d == 5) {
                $d = '4th Year';
            }
            return $d;
        }
    ),
    array('db' => 'cost',      'dt' => 3),
    array(
        'db'        => 'deadline',
        'dt'        => 4,
        'formatter' => function ($d, $row) {
            return date('jS M Y', strtotime($d));
        }
    ),array(
        'db'        => 'fees_id',
        'dt'        => 5,
        'formatter' => function ($d, $row) {
            $d = '<button type="button" id="'. $d . '" class="btn btn-primary update me-2" name="update"><i class="bi bi-pencil-square"></i></button><button type="button" id="'. $d . '" class="btn btn-danger delete" name="delete"><i class="bi bi-trash"></i></button>';
            return $d;
        }
    )
);

// Include SQL query processing class 
require '../databaseHandler/ssp.class.php';

// Output data as json format 
echo json_encode(
    SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
);
