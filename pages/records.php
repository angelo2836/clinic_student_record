<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="records.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="records-page">
        <div class="records-card">
            <div class="records-header">
                <div class="records-search">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M10 4a6 6 0 1 0 3.874 10.582l4.272 4.272 1.414-1.414-4.272-4.272A6 6 0 0 0 10 4Zm0 2a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z" />
                    </svg>
                    <input type="text" placeholder="Search records..." />
                </div>

                <a href="add-record.php"><button class="add-record-btn">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19 11H13V5h-2v6H5v2h6v6h2v-6h6z" />
                        </svg>
                        Add Record
                    </button>
                </a>
            </div>

            <div class="records-table-wrapper">
                <table class="records-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Name</th>
                            <th>Date of Birth</th>
                            <th>Age</th>
                            <th>Phone</th>
                            <th>Diagnosis</th>
                            <th class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $sql = "SELECT * FROM student where status = 'active'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                    ?>
                            <td class="col-no"><?php echo $count++; ?></td>
                            <td class="col-id"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="col-name"><?php echo htmlspecialchars($row['bdate']); ?></td>
                            <td class="col-program"><?php echo htmlspecialchars($row['age']); ?></td>
                            <td class="col-program"><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td class="col-program"><?php echo htmlspecialchars($row['diagnosis']); ?></td>

                            <td class="action-col">
                                <div class="action-buttons">
                                    <button class="icon-btn edit-btn" title="Edit">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25Zm2.92 2.33H5v-.92l8.06-8.06.92.92L5.92 19.58ZM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0L15.13 5.1l3.75 3.75 1.83-1.81Z" />
                                        </svg>
                                    </button>


                                    <button class="icon-btn delete-btn open-delete-modal" title="Delete" type="button"
                                        data-id="01" data-name="John Carter">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M6 7h12l-1 14H7L6 7Zm3-3h6l1 2h4v2H4V6h4l1-2Zm1 5v9h2V9h-2Zm4 0v9h2V9h-2Z" />
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                        <?php
                                }
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</body>

</html>