<?php 
include('../config/function.php');


// Database connection ($conn) goes here...

$from = $_GET['from'] ?? date('Y-m-d');
$to = $_GET['to'] ?? date('Y-m-d');

// --- 1. CARD DATA: Daily, Monthly, and Total Profit ---
// Note: Replace 'total_amount * 0.2' with your actual profit calculation 
// (e.g., total_amount - cost_price) if you have a cost column.

// Daily Profit (Today)
$dailyQuery = "SELECT SUM(total_amount) as revenue FROM orders WHERE DATE(order_date) = CURDATE()";
$dailyRes = mysqli_query($conn, $dailyQuery);
$dailyData = mysqli_fetch_assoc($dailyRes);

// Monthly Profit (Current Month)
$monthlyQuery = "SELECT SUM(total_amount) as revenue FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
$monthlyRes = mysqli_query($conn, $monthlyQuery);
$monthlyData = mysqli_fetch_assoc($monthlyRes);

// Lifetime Total Revenue
$totalQuery = "SELECT SUM(total_amount) as revenue FROM orders";
$totalRes = mysqli_query($conn, $totalQuery);
$totalData = mysqli_fetch_assoc($totalRes);

// --- 2. TABLE DATA: Selected Date Range ---
$tableQuery = "SELECT 
                DATE(order_date) as date,
                COUNT(id) as total_invoices,
                SUM(total_amount) as total_income,
                SUM(discount) as total_discount
               FROM orders 
               WHERE DATE(order_date) BETWEEN '$from' AND '$to'
               GROUP BY DATE(order_date)
               ORDER BY DATE(order_date) DESC";

$tableRes = mysqli_query($conn, $tableQuery);
$tableData = [];
while($row = mysqli_fetch_assoc($tableRes)) {
    // Logic: Profit = Income - (Estimated Cost)
    // If you don't have cost, this is just demonstrating the column
    $row['estimated_profit'] = $row['total_income'] * 0.25; // Example: 25% margin
    $tableData[] = $row;
}

// Return JSON
echo json_encode([
    'cards' => [
        'daily' => number_format($dailyData['revenue'] ?? 0, 2, '.', ''),
        'monthly' => number_format($monthlyData['revenue'] ?? 0, 2, '.', ''),
        'total' => number_format($totalData['revenue'] ?? 0, 2, '.', '')
    ],
    'table' => $tableData
]);



?>