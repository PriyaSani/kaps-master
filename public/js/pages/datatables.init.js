$(document).ready(function() {
    $("#datatable").DataTable(), $("#datatable-buttons").DataTable({
        lengthChange: !1,
        scrollX: true,
        paging: true,
        scrollCollapse: true,
        buttons: [
        	"colvis",
        	{
                extend: 'excel',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ]
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});