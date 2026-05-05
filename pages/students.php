
<?php
if (isset($_GET['add'])) {

?>
<div class="modal fade"
     id="alertModal"
     tabindex="-1"
     aria-hidden="true"
     data-bs-backdrop="static"
     data-bs-keyboard="false">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow rounded-4">

            <!-- Header -->
            <div class="modal-header justify-content-center border-0 pb-0">
            <h5 class="modal-title fw-semibold text-success">
                ✅ Saved Successfully
            </h5>
            </div>

            <!-- Body -->
            <div class="modal-body text-center py-3">
            <p class="mb-0 text-muted">
                Your changes have been saved successfully.
            </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-center border-0 pt-0">
            <button
                type="button"
                class="btn btn-success px-4 rounded-pill"
                data-bs-dismiss="modal">
                Continue
            </button>
            </div>
        </div>
    </div>
</div>
<?php
}


if (isset($_GET['delete'])) {

?>
    <div class="modal fade"
        id="alertModal"
        tabindex="-1"
        aria-hidden="true"
        data-bs-backdrop="static"
        data-bs-keyboard="false">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow rounded-4">

                <!-- Header -->
                <div class="modal-header justify-content-center border-0 pb-0">
                <h5 class="modal-title fw-semibold text-danger">
                    ⚠️ Removing Student!
                </h5>
                </div>

                <!-- Body -->
                 <form action="delete_student.php" method="POST">
                    <div class="modal-body text-center py-3">
                        <p class="mb-0 text-muted">
                            Are you sure that you want to remove this student?
                        </p>
                        </div>

                    <!-- Footer -->
                    <div class="modal-footer justify-content-center border-0 pt-0">
                        <button
                            type="button"
                            class="btn btn-secondary px-4 rounded-pill"
                            data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <input type="hidden" name="record_id" value="<?php echo $_GET['delete'];?>">
                        <button
                            type="submit"
                            class="btn btn-danger px-4 rounded-pill"
                            data-bs-dismiss="modal">
                            Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    
    </div>
<?php
}



// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "clinic");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SETTINGS
$limit = 20;

// GET SECTION + PAGE
$section = $_GET['section'] ?? 'student';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1);

// GET SEARCH
$search = trim($_GET['search'] ?? '');

// OFFSET
$offset = ($page - 1) * $limit;

// =========================
// BUILD SEARCH QUERY
// =========================
$whereSql = "";
$params = [];
$types = "";

if ($search !== "") {
    $whereSql = " WHERE stud_id LIKE ? OR name LIKE ? OR program LIKE ?";
    $searchTerm = "%" . $search . "%";
    $params = [$searchTerm, $searchTerm, $searchTerm];
    $types = "sss";
}

// =========================
// FETCH DATA
// =========================
$sql = "SELECT * FROM student where status = 'active'" . $whereSql . " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if ($search !== "") {
    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

// =========================
// TOTAL ROWS
// =========================
$countSql = "SELECT COUNT(*) AS total FROM student" . $whereSql;
$countStmt = $conn->prepare($countSql);

if ($search !== "") {
    $countStmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}

$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalPages = max(1, ceil($totalRow['total'] / $limit));

// Prevent invalid page overflow
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <!-- Optional: keep Bootstrap if needed elsewhere -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="students.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</head>

<body>

    <div class="page-wrap">
        <div class="table-card">
            <!-- Toolbar -->
            <div class="table-header">

                <form class="table-search" id="searchForm">
                    <input type="hidden" name="section" value="<?php echo htmlspecialchars($section); ?>">

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M10 4a6 6 0 1 0 3.874 10.582l4.272 4.272 1.414-1.414-4.272-4.272A6 6 0 0 0 10 4Zm0 2a4 4 0 1 1 0 8 4 4 0 0 1 0-8Z" />
                    </svg>

                    <input type="text" id="searchInput" name="search" placeholder="Search students..."
                        value="<?php echo htmlspecialchars($search); ?>">
                </form>


                <button class="add-student-btn" type="button" id="openAddStudentModal">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 11H13V5h-2v6H5v2h6v6h2v-6h6z" />
                    </svg>
                    Add Student
                </button>

            </div>

            <!-- Single table only -->
            <div class="table-scroll" id="studentTableContainer">
                <table class="student-table">
                    <thead>
                        <tr>
                            <th class="col-no">No.</th>
                            <th class="col-id">Student ID</th>
                            <th class="col-name">Name</th>
                            <th class="col-program">Program</th>
                            <th class="action-col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <?php if ($result && $result->num_rows > 0):
                            $count = $offset + 1;
                            while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="col-no"><?php echo $count++; ?></td>
                            <td class="col-id"><?php echo htmlspecialchars($row['stud_id']); ?></td>
                            <td class="col-name"><?php echo htmlspecialchars($row['name']); ?></td>
                            <td class="col-program"><?php echo htmlspecialchars($row['program']); ?></td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button class="icon-btn edit-btn" title="Edit" type="button">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25Zm2.92 2.33H5v-.92l8.06-8.06.92.92L5.92 19.58ZM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0L15.13 5.1l3.75 3.75 1.83-1.81Z" />
                                        </svg>
                                    </button>
                                    <a href="dashboard.php?section=records&delete=<?php echo $row['id']?>">
                                    <button class="icon-btn delete-btn open-delete-modal" title="Delete" type="button"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($row['name']); ?>">
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path
                                                d="M6 7h12l-1 14H7L6 7Zm3-3h6l1 2h4v2H4V6h4l1-2Zm1 5v9h2V9h-2Zm4 0v9h2V9h-2Z" />
                                        </svg>
                                    </button></a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        <?php else: ?>

                        <tr class="empty-row">
                            <td colspan="5">
                                <?php if ($search !== ""): ?>
                                No students found for "<strong><?php echo htmlspecialchars($search); ?></strong>".
                                <?php else: ?>
                                No data found.
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Footer / Pagination aligned right -->

            <?php
                $range = 2; // number of page links to show on each side of the current page
            ?>

            <div class="table-footer">
                <ul class="custom-pagination" id="paginationContainer">
                    <!-- Previous -->
                    <?php if ($page > 1): ?>
                    <li>
                        <a href="#" data-page="<?php echo $page - 1; ?>" class="pagination-link">‹</a>
                    </li>
                    <?php else: ?>
                    <li class="disabled"><span>‹</span></li>
                    <?php endif; ?>

                    <!-- First page -->
                    <?php if ($page > ($range + 1)): ?>
                    <li>
                        <a href="#" data-page="1" class="pagination-link">1</a>
                    </li>
                    <?php if ($page > ($range + 2)): ?>
                    <li class="ellipsis"><span>…</span></li>
                    <?php endif; ?>
                    <?php endif; ?>

                    <!-- Page numbers -->
                    <?php for ($i = $page - $range; $i <= $page + $range; $i++): ?>
                    <?php if ($i > 0 && $i <= $totalPages): ?>
                    <?php if ($i == $page): ?>
                    <li class="active"><span><?php echo $i; ?></span></li>
                    <?php else: ?>
                    <li>
                        <a href="#" data-page="<?php echo $i; ?>" class="pagination-link">
                            <?php echo $i; ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endfor; ?>

                    <!-- Last page -->
                    <?php if ($page < ($totalPages - $range)): ?>
                    <?php if ($page < ($totalPages - $range - 1)): ?>
                    <li class="ellipsis"><span>…</span></li>
                    <?php endif; ?>
                    <li>
                        <a href="#" data-page="<?php echo $totalPages; ?>" class="pagination-link">
                            <?php echo $totalPages; ?>
                        </a>
                    </li>
                    <?php endif; ?>

                    <!-- Next -->
                    <?php if ($page < $totalPages): ?>
                    <li>
                        <a href="#" data-page="<?php echo $page + 1; ?>" class="pagination-link">›</a>
                    </li>
                    <?php else: ?>
                    <li class="disabled"><span>›</span></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal-overlay" id="addStudentModal">
        <div class="student-form-modal">
            <div class="student-form-header">
                <div>
                    <h3>Add Student</h3>
                    <p>Fill in the student details below.</p>
                </div>

                <button type="button" class="student-form-close" id="closeAddStudentModal" aria-label="Close modal">
                    &times;
                </button>
            </div>
            <form action="add-student.php" method="POST" class="student-form">
                <div class="student-form-grid">
                    <div class="student-form-group">
                        <label for="stud_id">Student ID</label>
                        <input type="text" id="stud_id" name="stud_id" placeholder="Enter student ID" required>
                    </div>
                    <div class="student-form-group">
                        <label for="stud_id">Birth Date</label>
                        <input type="text" id="stud_id" name="bdate" placeholder="Enter Birth Date" required>
                    </div>
                    <div class="student-form-group full-width">
                        <label for="name">Student Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter full name" required>
                    </div>
                    <div class="student-form-group">
                        <label for="stud_id">Age</label>
                        <input type="text" id="stud_id" name="age" placeholder="Enter Age" required>
                    </div>

                    <div class="student-form-group">
                        <label for="program">Program</label>
                        <input type="text" id="program" name="program" placeholder="Enter program" required>
                    </div>
                    <div class="student-form-group">
                        <label for="program">Phone Number</label>
                        <input type="text" id="program" name="pnumber" placeholder="Enter Phone Number" required>
                    </div>
                </div>
                <div class="student-form-footer">
                    <button type="button" class="student-cancel-btn" id="cancelAddStudentBtn">Cancel</button>
                    <button type="submit" class="student-submit-btn">Save Student</button>
                </div>
            </form>
        </div>
    </div>


    <script>
    let currentPage = <?php echo $page; ?>;
    let currentSearch = '<?php echo addslashes($search); ?>';

    function loadStudents(page = 1, search = '') {
        const params = new URLSearchParams();
        params.append('page', page);
        params.append('search', search);

        fetch('../get_students_ajax.php?' + params.toString())
            .then(response => response.json())
            .then(data => {
                updateTable(data);
                updatePagination(data);
                currentPage = data.page;
                currentSearch = data.search;
            })
            .catch(error => console.error('Error loading students:', error));
    }

    function updateTable(data) {
        const tbody = document.getElementById('studentTableBody');

        if (!data.hasResults) {
            let message = 'No data found.';
            if (data.search !== '') {
                message = `No students found for "<strong>${escapeHtml(data.search)}</strong>".`;
            }
            tbody.innerHTML = `<tr class="empty-row"><td colspan="5">${message}</td></tr>`;
            return;
        }

        let html = '';
        const offset = data.offset;

        data.rows.forEach((row, index) => {
            const count = offset + index + 1;
            html += `
                <tr>
                    <td class="col-no">${count}</td>
                    <td class="col-id">${escapeHtml(row.stud_id)}</td>
                    <td class="col-name">${escapeHtml(row.name)}</td>
                    <td class="col-program">${escapeHtml(row.program)}</td>
                    <td class="action-col">
                        <div class="action-buttons">
                            <button class="icon-btn edit-btn" title="Edit" type="button">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25Zm2.92 2.33H5v-.92l8.06-8.06.92.92L5.92 19.58ZM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0L15.13 5.1l3.75 3.75 1.83-1.81Z" />
                                </svg>
                            </button>
                            <button class="icon-btn delete-btn open-delete-modal" title="Delete" type="button"
                                data-id="${row.id}"
                                data-name="${escapeHtml(row.name)}">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M6 7h12l-1 14H7L6 7Zm3-3h6l1 2h4v2H4V6h4l1-2Zm1 5v9h2V9h-2Zm4 0v9h2V9h-2Z" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;

        document.querySelectorAll(".open-delete-modal").forEach(btn => {
            btn.addEventListener("click", function() {
                const modal = document.getElementById("deleteModal");
                const input = document.getElementById("deleteRecordId");
                const nameText = document.getElementById("deleteRecordName");
                const id = this.getAttribute("data-id");
                const name = this.getAttribute("data-name");

                input.value = id;
                nameText.textContent = name;
                modal.style.display = "flex";
            });
        });
    }

    function updatePagination(data) {
        const container = document.getElementById('paginationContainer');
        const page = data.page;
        const totalPages = data.totalPages;
        const range = 2;

        let html = '';

        // Previous
        if (page > 1) {
            html += `<li><a href="#" data-page="${page - 1}" class="pagination-link">‹</a></li>`;
        } else {
            html += '<li class="disabled"><span>‹</span></li>';
        }

        // First page
        if (page > (range + 1)) {
            html += `<li><a href="#" data-page="1" class="pagination-link">1</a></li>`;
            if (page > (range + 2)) {
                html += '<li class="ellipsis"><span>…</span></li>';
            }
        }

        // Page numbers
        for (let i = page - range; i <= page + range; i++) {
            if (i > 0 && i <= totalPages) {
                if (i === page) {
                    html += `<li class="active"><span>${i}</span></li>`;
                } else {
                    html += `<li><a href="#" data-page="${i}" class="pagination-link">${i}</a></li>`;
                }
            }
        }

        // Last page
        if (page < (totalPages - range)) {
            if (page < (totalPages - range - 1)) {
                html += '<li class="ellipsis"><span>…</span></li>';
            }
            html += `<li><a href="#" data-page="${totalPages}" class="pagination-link">${totalPages}</a></li>`;
        }

        // Next
        if (page < totalPages) {
            html += `<li><a href="#" data-page="${page + 1}" class="pagination-link">›</a></li>`;
        } else {
            html += '<li class="disabled"><span>›</span></li>';
        }

        container.innerHTML = html;

        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageNum = this.getAttribute('data-page');
                loadStudents(pageNum, currentSearch);
            });
        });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');

        // Auto-search on input change
        searchInput.addEventListener('input', function() {
            loadStudents(1, this.value);
        });

        // Pagination links
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageNum = this.getAttribute('data-page');
                loadStudents(pageNum, currentSearch);
            });
        });
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("deleteModal");
        const cancelBtn = document.getElementById("cancelDeleteBtn");

        cancelBtn.addEventListener("click", function() {
            modal.style.display = "none";
        });

        modal.addEventListener("click", function(e) {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                modal.style.display = "none";
            }
        });
    });
    </script>


    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const addStudentModal = document.getElementById("addStudentModal");
        const openAddStudentModalBtn = document.getElementById("openAddStudentModal");
        const closeAddStudentModalBtn = document.getElementById("closeAddStudentModal");
        const cancelAddStudentBtn = document.getElementById("cancelAddStudentBtn");

        function openAddStudentModal() {
            if (!addStudentModal) return;
            addStudentModal.classList.add("show");
            document.body.classList.add("modal-open");
        }

        function closeAddStudentModal() {
            if (!addStudentModal) return;
            addStudentModal.classList.remove("show");
            document.body.classList.remove("modal-open");
        }

        if (openAddStudentModalBtn) {
            openAddStudentModalBtn.addEventListener("click", openAddStudentModal);
        }

        if (closeAddStudentModalBtn) {
            closeAddStudentModalBtn.addEventListener("click", closeAddStudentModal);
        }

        if (cancelAddStudentBtn) {
            cancelAddStudentBtn.addEventListener("click", closeAddStudentModal);
        }

        if (addStudentModal) {
            addStudentModal.addEventListener("click", function(e) {
                if (e.target === addStudentModal) {
                    closeAddStudentModal();
                }
            });
        }

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape" && addStudentModal && addStudentModal.classList.contains("show")) {
                closeAddStudentModal();
            }
        });
    });


// ======================alert modal confirm added==================
document.addEventListener("DOMContentLoaded", function () {
  let modal = new bootstrap.Modal(document.getElementById("alertModal"));
  modal.show();
});
// ======================delete modal==================

document.addEventListener("DOMContentLoaded", function () {
  let modal1 = new bootstrap.Modal(document.getElementById("deleteModal"));
  modal1.show();
});

</script>
</body>
</html>