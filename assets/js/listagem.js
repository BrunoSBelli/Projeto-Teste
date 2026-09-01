 $('#example').DataTable({
    responsive: true,
    pageLength: 10,
    order: [[0, 'desc']],
    columnDefs: [
      { orderable: false, targets: -1 }
    ],
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json"
    }
  });