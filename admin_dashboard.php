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
    <title>Tabela događaja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body>
<?php include 'templates/header.php'; ?>

<div class="container-fluid mt-2 col-12 col-xl-10">
    <h2>Tabela događaja</h2>
    <div class="table-responsive">
        <table id="eventsTable" class="display table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Event Date</th>
                <th>Creator ID</th>
                <th>Location</th>
                <th>Status</th>
                <th>Akcije</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $stmt = $pdo->query("SELECT event_id, title, description, event_date, user_id, status, location FROM events");

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr data-event-id='" . $row['event_id'] . "'>";
                    echo "<td>" . htmlspecialchars($row['event_id']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td style='word-break: break-word;' title='" . htmlspecialchars($row['description']) . "'>" . htmlspecialchars(mb_strimwidth($row['description'], 0, 34, "...")) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['event_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                    echo "<td style='word-break: break-word;'>" . htmlspecialchars($row['location']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                    echo "<td>
                    <div class='d-flex justify-content-between flex-nowrap gap-1'>
                    <form action='event.php' method='post'>
                    <input type='hidden' name='event_id' value='" . $row['event_id'] . "'>
                    <button type='submit' class='btn btn-sm btn-success me-1' title='Izmeni'>
                        Izmeni
                    </button>
                    </form>
                    <button type='button' class='btn btn-sm btn-dark me-1' title='Blokiraj' onclick='eventStatus(this, \"blocked\")'>
                        Blokiraj
                    </button>
                    <button type='button' class='btn btn-sm btn-dark me-1' title='Aktiviraj' onclick='eventStatus(this, \"active\")'>
                        Aktiviraj
                    </button>
                    <button type='button' class='btn btn-sm btn-warning me-1' title='Arhiviraj' onclick='eventStatus(this, \"archived\")'>
                        Arhiviraj
                    </button>
                    <button type='submit' data-event-id='" . $row['event_id'] . "' class='btn btn-sm btn-danger me-1 btnDelEvent' title='Obriši'>
                        Obriši
                    </button>
                   </div>
                   </td>";
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
        var table = $('#eventsTable').DataTable({
            stateSave: true,
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
            order: [[6, 'asc']],
        });
    });

    $('#eventsTable tbody tr').each(function () {
        var row = $(this);
        var status = row.find("td:nth-child(7)").text().trim().toLowerCase();

        if (status === 'blocked') {
            row.find("button[title='Blokiraj']").hide();
        }
        if (status === 'active') {
            row.find("button[title='Aktiviraj']").hide();
        }
        if (status === 'archived') {
            row.find("button[title='Arhiviraj']").hide();
        }
    });

    $(document).on('click', '.btnDelEvent', function () {
        var event_id = $(this).data('event-id');
        $('#eventId').val(event_id);
        $('#delModal').modal('show');
    });


    function eventStatus(button,status1) {
        const row = button.closest("tr");
        const eventId = row.getAttribute("data-event-id");
        $.ajax({
            url: 'files/block_event.php',
            type: 'POST',
            data: {
                event_id: eventId,
                status: status1,
            },
            success: function (response) {
                $(row).find("td:nth-child(7)").text(status1);

                $(row).find("button[title='Blokiraj']").show();
                $(row).find("button[title='Aktiviraj']").show();
                $(row).find("button[title='Arhiviraj']").show();

                if (status1 === 'blocked') {
                    $(row).find("button[title='Blokiraj']").hide();
                }
                if (status1 === 'active') {
                    $(row).find("button[title='Aktiviraj']").hide();
                }
                if (status1 === 'archived') {
                    $(row).find("button[title='Arhiviraj']").hide();
                }
            },
            error: function (xhr) {
                alert("Greška: " + xhr.responseText);
            }
        });
    }
</script>

<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action='files/delete_event.php' method='post' onsubmit="return confirm('Da li ste sigurni da želite da obrišete događaj?')">
                <input type="hidden" id="eventId" name="event_id">
                <div class="modal-body">
                    <label for="notification_text" class="form-label">Razlog brisanja događaja:</label>
                    <textarea id="notification_text" name="notification_text" class="form-control" rows="3" placeholder="Napišite razlog za brisanje ovog događaja" minlength="3" maxlength="1000" style="background-color: #e9f1ff"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Obriši</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
