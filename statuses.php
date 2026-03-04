<?php

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lead Statuses</title>
</head>
 <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            padding: 20px;
        }
        nav a {
            margin-right: 15px;
            text-decoration: none;
            color: #007bff;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h2 {
            margin-top: 20px;
        }
        form {
            margin-bottom: 20px;
        }
        input, button {
            padding: 5px 10px;
            margin-right: 10px;
            margin-top: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f1f3f5;
        }
    </style>
<body>

<nav>
    <a href="index.php">Add Lead</a> |
    <a href="statuses.php">Lead Statuses</a>
</nav>

<h2>Lead Statuses</h2>

<form method="GET">
    Date From: <input type="datetime-local" name="date_from">
    Date To: <input type="datetime-local" name="date_to">
    <button type="submit">Filter</button>
</form>

<?php


$max_ago = strtotime("-60 days");
$default_from = strtotime("-30 days");


if (isset($_GET['date_from'])) {
    $from_ts = strtotime(str_replace("T", " ", $_GET['date_from']));
    $date_from = $from_ts < $max_ago ? date("Y-m-d H:i:s", $max_ago) : date("Y-m-d H:i:s", $from_ts);
} else {
    $date_from = date("Y-m-d H:i:s", $default_from);
}


$date_to = isset($_GET['date_to']) 
    ? str_replace("T", " ", $_GET['date_to']) . ":00"
    : date("Y-m-d H:i:s");


$data = [
    "date_from" => $date_from,
    "date_to" => $date_to,
    "page" => 0,
    "limit" => 100
];

$ch = curl_init("https://crm.belmar.pro/api/v1/getstatuses");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "token: ba67df6a-a17c-476f-8e95-bcdb75ed3958"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));


curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


$response = curl_exec($ch);

if ($response === false) {
    die("Curl error: " . curl_error($ch));
}

curl_close($ch);

$result = json_decode($response, true);

if (!empty($result['status']) && $result['status'] == 1) {

    if (is_string($result['data'])) {
        $leads = json_decode($result['data'], true);
    } elseif (is_array($result['data'])) {
        $leads = $result['data'];
    } else {
        $leads = [];
    }

    if (empty($leads)) {
        echo "<p>--------</p>";
    } else {
        echo "<table border='1' cellpadding='5' cellspacing='0'>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>FTD</th>
                </tr>";
        foreach ($leads as $lead) {
            $status = !empty($lead['status']) ? $lead['status'] : 'new';
            $ftd = $lead['ftd'] ?? '';
            echo "<tr>
                    <td>{$lead['id']}</td>
                    <td>{$lead['email']}</td>
                    <td>{$status}</td>
                    <td>{$ftd}</td>
                  </tr>";
        }
        echo "</table>";
    }

} else {
    echo "Error: " . ($result['error'] ?? 'Unknown error');
}
?>

</body>
</html>