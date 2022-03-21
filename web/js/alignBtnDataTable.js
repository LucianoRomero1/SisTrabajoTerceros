
$(document).ready(function() {
    $('#example').DataTable( {
        "language": {
          "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }, 
        dom: 'lfrtipB',
        buttons: [
            {
            extend:         'excel',
              text:         '<i class="fas fa-file-csv fa-2x text-success"></i>',
              title:        'Control de stock',
              titleAttr:    'Exportar como Excel',
              className:    'btn btn-default btn-sm',
              exportOptions: {
                columns: ':visible'
              },
            },
            {
              extend:       'pdf',
              text:         '<i class="fas fa-file-pdf fa-2x text-danger"></i>',
              title:        'Control de stock',
              titleAttr:    'Exportar como PDF',
              className:    'btn btn-default btn-sm',
              exportOptions: {
                columns: ':visible'
              }
            }, 
        ]
    });
});

