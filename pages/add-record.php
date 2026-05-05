<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="add-record.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>

    <div class="container">

        <!-- Search Area -->
        <div class="search-section">
            <label for="studentSearch">Search Student:</label>

            <div class="search-row">
                <input type="text" id="studentSearch" class="search-input" />
                <button class="search-button">Search</button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">

            <!-- Profile Image and ID -->
            <div class="profile-section">
                <div class="profile-box">
                    <div class="avatar">
                        <div class="avatar-head"></div>
                        <div class="avatar-body"></div>
                    </div>
                </div>

                <div class="student-id">Student ID: 5512</div>
            </div>

            <!-- Student Details -->
            <div class="details-section">
                <div class="student-name-label">Student Name:</div>
                <div class="student-name text-uppercase">Juan Dela Cruz</div>

                <div class="program-label">Program:</div>
                <div class="program-name">Bachelor of Secondary Education</div>

                <div class="divider"></div>

                <label class="diagnosis-label" for="diagnosis">Diagnosis:</label>

                <div class="select-wrapper">
                    <select id="diagnosis" class="diagnosis-select">
                        <option>Kalibanga</option>
                        <option>Hilanat</option>
                        <option>Ubo</option>
                    </select>
                </div>

                <div class="button-row">
                    <a href="dashboard.php"><button class="cancel-button">Cancel</button></a>
                    <button class="save-button">Save</button>
                </div>
            </div>

        </div>

    </div>

</body>

</html>