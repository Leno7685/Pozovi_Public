
$(document).ready(function () {
    var table = $('#inviteesTable').DataTable({
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
        responsive: true,
    });


    $('#attendanceFilter').on('change', function () {
        var selected = $(this).val();
        if (selected) {
            table.column(2).search('^' + selected + '$', true, false).draw();
        } else {
            table.column(2).search('', true, false).draw();
        }
    });

});