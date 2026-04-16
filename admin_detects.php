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
    <title>Tabela detekcija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <div class="container mt-3">
        <h2>Detekcija uređaja</h2>
        <table id="detectsTable" class="display table table-bordered table-striped" style="width:100%">
            <div class="mb-3">
                <label for="deviceTypeFilter" class="form-label">Filter po uređaju:</label>
                <select id="deviceTypeFilter" class="form-select" style="width: 200px;">
                    <option value="">Svi uređaji</option>
                    <option value="phone">Phone</option>
                    <option value="tablet">Tablet</option>
                    <option value="computer">Computer</option>
                </select>
            </div>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>IP Address</th>
                    <th>Operating System</th>
                    <th>Device Type</th>
                    <th>HTTP User Agent</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM detects");

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $isValidIp = filter_var($row['ip_address'], FILTER_VALIDATE_IP);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id_detect']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        if ($isValidIp && $row['ip_address'] !== "::1") {
                            echo "<td><a href='javascript:void(0)' class='ip-address'>" . htmlspecialchars($row['ip_address']) . "</a></td>";
                        } else {
                            echo "<td>" . htmlspecialchars($row['ip_address']) . "</td>";
                        }
                        echo "<td>" . htmlspecialchars($row['operating_system']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['device_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['http_user_agent']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_time']) . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "Greška u povezivanju sa bazom: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            var table = $('#detectsTable').DataTable({
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
            $('#deviceTypeFilter').on('change', function () {
                var selected = $(this).val();
                if (selected) {
                    table.column(4).search('^' + selected + '$', true, false).draw();
                } else {
                    table.column(4).search('', true, false).draw();
                }
            });


            $('#detectsTable').on('click', '.ip-address', function () {
                var ipAddress = $(this).text();
                $.ajax({
                    url: 'https://ipinfo.io/' + ipAddress + '/json',
                    type: 'GET',
                    success: function (data) {
                        $('#ip-address').text(data.ip);
                        $('#hostname').text(data.hostname);
                        $('#city').text(data.city);
                        $('#region').text(data.region);
                        $('#country').text(data.country);
                        $('#org').text(data.org);
                        $('#location').text(data.loc);
                        $('#timezone').text(data.timezone);

                        $('#ipInfoModal').modal('show');
                    },
                    error: function () {
                        alert('Greška pri učitavanju podataka o IP adresi.');
                    }
                });
            });
        });
    </script>

    <div class="modal fade" id="ipInfoModal" tabindex="-1" aria-labelledby="ipInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ipInfoModalLabel">Informacije o IP adresi preuzete sa ipinfo.io</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>IP:</strong> <span id="ip-address"></span></p>
                    <p><strong>Hostname:</strong> <span id="hostname"></span></p>
                    <p><strong>City:</strong> <span id="city"></span></p>
                    <p><strong>Region:</strong> <span id="region"></span></p>
                    <p><strong>Country:</strong> <span id="country"></span></p>
                    <p><strong>Organization:</strong> <span id="org"></span></p>
                    <p><strong>Location:</strong> <span id="location"></span></p>
                    <p><strong>Timezone:</strong> <span id="timezone"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
