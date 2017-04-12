<script>
/*  $(function () {
    $("#example1").DataTable();
    var dataTable = $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "dom": 'lrtp',
      "language": {
          "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
          "sEmptyTable": "Tidak ada data di database"
      }
    });

    $("#InputCari").keyup(function() {
      dataTable.search(this.value).draw();
    });*/
var table;
$(document).ready(function() {
    //datatables
    table = $('#example2').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "dom": 'lrtp',
        "lengthChange": false,
        "ordering": false,
        "autoWidth": true,

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('managers/search/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            $('td:eq(3)', nRow).html('<a href="search/profile/' + aData[1] + '">' +
                aData[3] + '</a>');
            return nRow;
        },

    });

    $("#InputCari").keyup(function() {
        table.search(this.value).draw();
    });

  });
</script>
</body>
</html>