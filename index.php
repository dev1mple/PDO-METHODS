<?php require_once 'dbConfig.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Get the total quantity of medicines sold to each customer</h1>
    <?php
    $stmt = $pdo->prepare("SELECT Customers.customer_id AS Customer_id, 
    Customers.first_name AS Customer_name, 
    SUM(SalesDescription.quantity) AS total_quantity
FROM SalesDescription
JOIN Sales ON Sales.sale_id = SalesDescription.sale_id
JOIN Customers ON Sales.customer_id = Customers.customer_id
GROUP BY Customers.customer_id;
    ");
        
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        $customers = $stmt->fetchAll();
    } else {
        echo "Query Failed";
        exit; // Stops further execution if query fails
    }
    ?>

    <table> 
        <tr>
            <th>Customer Id</th>
            <th>Customer Name</th>
            <th>Total Quantity</th>
        </tr>
        
    <?php if (!empty($customers)): ?>
        <?php foreach ($customers as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Customer_id']); ?></td>
            <td><?php echo htmlspecialchars($row['Customer_name']); ?></td>
            <td><?php echo htmlspecialchars(number_format($row['total_quantity'], 2)); ?></td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No data found</td>
        </tr>
    <?php endif; ?>
    </table>
</body>
</html>
