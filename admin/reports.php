<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
        .chart-container {
            margin-bottom: 40px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .section-title {
            margin-bottom: 20px;
            color: #343a40;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h1 class="text-center section-title">Reports</h1>

        
        <div class="chart-container">
            <h3 class="section-title">User Activity - Signups</h3>
            <canvas id="userActivityChart" width="400" height="200"></canvas>
        </div>

        
        <div class="chart-container">
            <h3 class="section-title">Sales Overview</h3>
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script>
        
        const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
        const userActivityChart = new Chart(userActivityCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], 
                datasets: [{
                    label: 'User Signups',
                    data: [10, 15, 12, 25, 18],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: { responsive: true }
        });

        
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'], 
                datasets: [{
                    label: 'Sales',
                    data: [1000, 2000, 1500, 3000, 2500], 
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            },
            options: { responsive: true }
        });
    </script>

</body>
</html>
