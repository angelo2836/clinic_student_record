<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard-content.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
     
    <div class="dashboard-home">
        <!-- Top Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon aqua">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 13h8V3H3v10Zm10 8h8V3h-8v18ZM3 21h8v-6H3v6Z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>Total Students</h4>
                    <h2>1,245</h2>
                    <p class="up">+12% from last month</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 1a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-8 0c-.29 0-.62.02-.97.05C5.12 14.3 2 15.22 2 18v2h5v-2c0-1.47.81-2.86 2.23-3.95A9.95 9.95 0 0 0 8 14Z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>Clinic Visits</h4>
                    <h2>328</h2>
                    <p class="up">+8% this week</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Zm-1 10h-5v5h-2v-5H6v-2h5V6h2v5h5v2Z"/>
                    </svg>
                </div>
                <div class="stat-info">
                    <h4>New Records</h4>
                    <h2>56</h2>
                    <p class="down">Updated today</p>
                </div>
            </div>
        </div>

        <!-- Chart Card -->
        <div class="chart-card">
            <div class="chart-header">
                <div>
                    <h3>Monthly Clinic Overview</h3>
                    <p>Student visits for the last 6 months</p>
                </div>

                <select class="chart-filter">
                    <option>Last 6 Months</option>
                    <option>Last 12 Months</option>
                    <option>This Year</option>
                </select>
            </div>

            <div class="chart-area">
                <div class="chart-bars">
                    <div class="bar-group">
                        <div class="bar" style="height: 90px;"></div>
                        <span>Jan</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 130px;"></div>
                        <span>Feb</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 105px;"></div>
                        <span>Mar</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 160px;"></div>
                        <span>Apr</span>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 140px;"></div>
                        <span>May</span>
                    </div>
                    <div class="bar-group active">
                        <div class="bar" style="height: 190px;"></div>
                        <span>Jun</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

