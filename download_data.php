<?php
include 'database.php';

// Fetch data from the faculty_fill_data table
$sql = "SELECT * FROM faculty_fill_data";
$result = $con->query($sql);

// Collect all TGT and PGT data
$tgtData = [];
$pgtData = [];
$facultyData = [];

while ($row = $result->fetch_assoc()) {
    $facultyData[$row['id']] = $row;

    // Fetch TGT info
    $sql_tgt = "SELECT * FROM tgt_info WHERE faculty_fill_data_id = " . $row['id'];
    $result_tgt = $con->query($sql_tgt);
    while ($row_tgt = $result_tgt->fetch_assoc()) {
        $tgtData[$row['id']][] = $row_tgt;
    }

    // Fetch PGT info
    $sql_pgt = "SELECT * FROM pgt_info WHERE faculty_fill_data_id = " . $row['id'];
    $result_pgt = $con->query($sql_pgt);
    while ($row_pgt = $result_pgt->fetch_assoc()) {
        $pgtData[$row['id']][] = $row_pgt;
    }
}

// Find maximum TGT and PGT entries
$maxTGT = max(array_map('count', $tgtData));
$maxPGT = max(array_map('count', $pgtData));

// Generate CSV headers dynamically
$csvData = "ID,Name,Department,School,Board,Date,Principal Name,Principal Contact No.,";
for ($i = 1; $i <= $maxTGT; $i++) {
    $csvData .= "TGT{$i} Name,TGT{$i} Contact,TGT{$i} DOB,TGT{$i} DOA,TGT{$i} Subject,TGT{$i} Email,";
}
for ($i = 1; $i <= $maxPGT; $i++) {
    $csvData .= "PGT{$i} Name,PGT{$i} Contact,PGT{$i} DOB,PGT{$i} DOA,PGT{$i} Subject,PGT{$i} Email,";
}
$csvData .= "Stream,12th Strength,Topic Covered,Visit Remark,Data Collected\n";

// Generate CSV rows
foreach ($facultyData as $id => $row) {
    $csvRow = "{$row['id']},{$row['name']},{$row['department']},{$row['schools']},{$row['board']},{$row['date']},{$row['pname']},{$row['pcont']},";

    // Add TGT data
    if (isset($tgtData[$id])) {
        foreach ($tgtData[$id] as $tgt) {
            $csvRow .= "{$tgt['tgt_name']},{$tgt['tgt_contact']},{$tgt['dob']},{$tgt['doa']},{$tgt['subject']},{$tgt['email']},";
        }
        for ($i = count($tgtData[$id]); $i < $maxTGT; $i++) {
            $csvRow .= ",,,,,,";
        }
    } else {
        $csvRow .= str_repeat(",", $maxTGT * 6);
    }

    // Add PGT data
    if (isset($pgtData[$id])) {
        foreach ($pgtData[$id] as $pgt) {
            $csvRow .= "{$pgt['pgt_name']},{$pgt['pgt_contact']},{$pgt['dob']},{$pgt['doa']},{$pgt['subject']},{$pgt['email']},";
        }
        for ($i = count($pgtData[$id]); $i < $maxPGT; $i++) {
            $csvRow .= ",,,,,,";
        }
    } else {
        $csvRow .= str_repeat(",", $maxPGT * 6);
    }

    // Add remaining fields
    $csvRow .= "{$row['stream']},{$row['twelve']},{$row['topic_covered']},{$row['visit_remark']},{$row['data_collected']}\n";

    // Append row to CSV data
    $csvData .= $csvRow;
}

// Set the headers for CSV file download
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="faculty_data.csv"');

// Output the CSV data
echo $csvData;

$con->close();
?>
