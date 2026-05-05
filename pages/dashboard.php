<?php
session_start();

if (isset($_SESSION['user'])) {

$conn = new mysqli("localhost", "root", "", "clinic");

// pagination setup
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // prevent 0 or negative

$offset = ($page - 1) * $limit;

// main query (adjust table name if needed)
$sql = "SELECT * FROM student LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// total rows (for page count)
$totalResult = $conn->query("SELECT COUNT(*) as total FROM student");
$totalRow = $totalResult->fetch_assoc();
$totalPages = ceil($totalRow['total'] / $limit);

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboard.css">
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
      
<?php
if (isset($_GET['deletemodal'])) {
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
                ✅ Deleted Successfully
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


    <script>

        var modal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
        modal.show();

        document.getElementById('okBtn').addEventListener('click', function () {
            window.location.href = "dashboard.php?section=records";
        });
    </script>

<?php } ?>


<div class="dashboard">
    
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="brand mt-3">
        <div class="brand-text">
          <h5>Saint Michael College of Hindang, Leyte</h5>
          <p>Clinic<br>Dashboard</p>
        </div>
      </div>

      <div class="nav">
        <a href="dashboard.php?section=student" onclick="showSection('student', this)">
          <svg viewBox="0 0 24 24"><path d="M4 4h7v7H4V4Zm9 0h7v7h-7V4ZM4 13h7v7H4v-7Zm9 0h7v7h-7v-7Z"/></svg>
          Dashboard
        </a>        
        
        <a href="dashboard.php?section=records" onclick="showSection('records', this)">
          <svg viewBox="0 0 24 24"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 1a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-8 0c-.29 0-.62.02-.97.05C5.12 14.3 2 15.22 2 18v2h5v-2c0-1.47.81-2.86 2.23-3.95A9.95 9.95 0 0 0 8 14Z"/></svg>
          Students
        </a>
        <a href="dashboard.php?section=student1" onclick="showSection('student1', this)">
          <svg viewBox="0 0 24 24"><path d="M16 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm-8 1a3 3 0 1 0-3-3 3 3 0 0 0 3 3Zm8 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Zm-8 0c-.29 0-.62.02-.97.05C5.12 14.3 2 15.22 2 18v2h5v-2c0-1.47.81-2.86 2.23-3.95A9.95 9.95 0 0 0 8 14Z"/></svg>
          Records
        </a>

      </div>

      <div>
        <button class="btn btn-logout" onclick="window.location.href='session_destroy.php'">
          LOGOUT
        </button>

      </div>
    </aside>

    <!-- Main -->
    <main class="main">
      <!-- Top Search/Header -->
      <header class="topbar">

        <div class="topbar-right">
          <div class="notification" aria-label="Notifications">
            <svg viewBox="0 0 24 24">
              <path d="M12 22a2.5 2.5 0 0 0 2.45-2h-4.9A2.5 2.5 0 0 0 12 22Zm6-6V11a6 6 0 1 0-12 0v5L4 18v1h16v-1l-2-2Z"/>
            </svg>
          </div>

          <div class="user-box">
            <div class="user-info">
              <div class="name">Melvin Reston</div>
              <div class="role">Administrator</div>
            </div>
            <div class="avatar"></div>
          </div>
        </div>
      </header>
      <!-- Blank content area -->
    <div id="student" class="content">
      <?php include 'dashboard-content.php';?>
    </div>
    <div id="records" class="content">
      <?php include 'students.php';?>
    </div>
     <div id="student1" class="content">
      <?php include 'records.php';?>
    </div>
      
    </main>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteModal = document.getElementById('deleteModal');
        const deleteRecordName = document.getElementById('deleteRecordName');
        const deleteRecordId = document.getElementById('deleteRecordId');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

        if (!deleteModal) return;

        const openButtons = document.querySelectorAll('.open-delete-modal');

        function openDeleteModal(recordId, recordName) {
            deleteRecordId.value = recordId || '';
            deleteRecordName.textContent = recordName || 'this record';
            deleteModal.classList.add('show');
            document.body.classList.add('modal-open');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }

        openButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const recordId = this.getAttribute('data-id');
                const recordName = this.getAttribute('data-name');
                openDeleteModal(recordId, recordName);
            });
        });

        if (cancelDeleteBtn) {
            cancelDeleteBtn.addEventListener('click', closeDeleteModal);
        }

        deleteModal.addEventListener('click', function (e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && deleteModal.classList.contains('show')) {
                closeDeleteModal();
            }
        });
    });
    </script>

</body>
</html>

<script>
function showSection(id, el = null) {

  // hide all sections
  document.querySelectorAll(".content").forEach(sec => {
    sec.style.display = "none";
  });

  // remove active class
  document.querySelectorAll(".nav a").forEach(a => {
    a.classList.remove("active");
  });

  // show selected section
  const target = document.getElementById(id);
  if (target) {
    target.style.display = "block";
  }

  // set active link (if clicked)
  if (el) {
    el.classList.add("active");
  } else {
    // fallback: find link that matches section
    const link = document.querySelector(`.nav a[onclick*="${id}"]`);
    if (link) {
      link.classList.add("active");
    }
  }
}


// ✅ AUTO LOAD FROM URL (?section=student)
document.addEventListener("DOMContentLoaded", function () {

  const section = "<?= $_GET['section'] ?? 'student' ?>";

  showSection(section);

  // optional: auto set active class on load
  const link = document.querySelector(`.nav a[onclick*="${section}"]`);
  if (link) {
    link.classList.add("active");
  }

});
</script>
  <?php
}
else
  {
   header("Location:../index.php");
  }
?>

