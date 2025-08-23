   <script>
       $('body').on('click', '#btn-edit', function() {
           var dataId = $(this).data('id');
           var dataJenis = $(this).data('jenis');
           $.ajax({
               url: "#",
               type: "POST",
               data: {
                   _token: CSRF_TOKEN,
                   id: dataId,
                   jenis: dataJenis
               },
               beforeSend: function(xhr) {
                   Swal.fire({
                       title: 'Mohon tunggu…',
                       allowOutsideClick: false,
                       showConfirmButton: false,
                       didOpen: () => Swal.showLoading()
                   });
               },
               success: function(response) {
                   Swal.close();
                   $("#editModal").html(response);
                   $("#editSetting").modal('show');

               },
               error(response) {
                   Swal.close();
                   if (response.responseJSON && response.responseJSON.errors) {
                       var msg = response.responseJSON.message;
                       var errorMessages = response.responseJSON.errors;
                       var errorText = '';
                       $.each(errorMessages, function(key, value) {
                           errorText += value + '<br>';
                       });
                       Swal.fire({
                           icon: 'error',
                           title: msg,
                           html: errorText,
                           timer: 6000,
                           showConfirmButton: false
                       });
                   }
               }
           });
       });
   </script>
