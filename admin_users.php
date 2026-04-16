<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
}
require_once 'includes/db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela korisnika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body>
<?php include 'templates/header.php'; ?>

<div class="container-fluid mt-2 col-12 col-xl-10">
    <h2>Tabela korisnika</h2>
    <div class="table-responsive">
        <table id="usersTable" class="display table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Activated</th>
                <th>Registration Date</th>
                <th>Phone</th>
                <th>Blocked</th>
                <th>Blokiraj</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $stmt = $pdo->query("SELECT user_id, fname, lname, email, role, activated, registration_date, phone, blocked FROM users");

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr data-user-id='" . $row['user_id'] . "'>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['fname']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['lname']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['activated']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['registration_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['blocked']) . "</td>";
                    if($row['role'] === 'user') {
                        echo "<td style='word-break: normal;'>
                        <div class='d-flex justify-content-between flex-nowrap gap-1'>
                            <button type='button' class='btn btn-sm btn-danger me-1' title='Blokiraj' onclick='updateBlockStatus(this, 1)'>
                                Blokiraj
                            </button>
                            <button type='button' class='btn btn-sm btn-primary me-1' title='Deblokiraj' onclick='updateBlockStatus(this, 0)'>
                                Deblokiraj
                            </button>
                        </div>
                        </td>";
                    }
                    else{
                        echo "<td></td>";
                    }
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Greška u povezivanju sa bazom: " . $e->getMessage();
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        var table = $('#usersTable').DataTable({
            info: false,
            lengthChange: false,
            pageLength: 9,
            language: {
                search: "Pretraga:",
                paginate: {
                    previous: "Prethodna",
                    next: "Sledeća"
                }
            },
        });
    });

    function updateBlockStatus(button, status) {
        const row = button.closest("tr");
        const userId = row.getAttribute("data-user-id");
        $.ajax({
            url: 'files/users_blocked.php',
            type: 'POST',
            data: {
                user_id: userId,
                blocked: status
            },
            success: function (response) {
                $(row).find("td:nth-child(9)").text(status);
            },
            error: function (xhr) {
                alert("Greška prilikom ažuriranja: " + xhr.responseText);
            }
        });
    }
</script>

</body>
</html>
