$(document).ready(function(){
    $('.fixed-action-btn').floatingActionButton();
  });
  $(document).ready(function(){
    $('.modal').modal();
  });
  
  

  /* //funcao para inserir com ajax
  $(function(){
      $('form[name="contact-regist"]').submit(function(event){
            event.preventDefault();

            //var name = $(this).find('input#icon_prefix').val();
            //Swal.fire(name);
          $.ajax({
              type: "post",
              url: "{{ route('contact.store') }}",
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {

                   if (response.success === true) {

                        Swal.fire({
                        position: 'top-end',
                        background: '#C8E6C9',
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1800
                        })
                        setTimeout("window.location = '{{ route('contact.index') }}';",1800);

                   }else
                   {
                    Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: response.errors,
                    showConfirmButton: false,
                    timer: 1800
                    })
                   }
              },
              error: function (response) {
                  var errors = response.responseJSON.errors;
                  var error = '';
                  for (erros in errors) {
                        error += errors[erros] + '\n';
                  }
                  Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: error,
                    showConfirmButton: false,
                    timer: 1800
                    })
               }
          });

      });
  });*/
/*
  //read contacts with ajax
  $(document).ready(function () {
    var url = "{{route('contact.index')}}";
      $.ajax({
          type: "post",
          url: "{{ route('contact.getall') }}",
          data: {
                _token:'{{ csrf_token() }}'
            },
          cache: false,
          dataType: "json",
          success: function (response) {
                var resultData = response.data;
                if (response.success === true) {
                    var bodyData = '';
                    $.each(resultData, function (index,row) {
                        var edit = url+'/'+row.id+'/edit';
                        var id = row.id;
                        bodyData+="<tr>"
                            bodyData+= "<td>"+row.name+"</td><td>"+row.phone+"</td><td>"+row.email+"</td><td>"+row.religion+"</td><td><a onclick='edit("+id+")'  href='#'>edit</a>"
                            "</td>";
                        bodyData+="</tr>";
                    })
                    $("#tbody").append(bodyData);
                }else
                {
                    Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1800
                            })
                }

          },
          error: function () {
              alert('empty')
           }
      });
   });
   //funcao para editar com ajax


//Edit contact with ajax
function edit(id) {
  var url = "{{route('contact.index')}}"+"/"+id+"/edit";
  $.ajax({
      type: "GET",
      url: url,
      data: "data",
      dataType: "json",
      success: function (response) {
        var data = response.data;
        if (data) {
            $('#modal2').modal('open');
            $('#title').text('Editar Contacto: '+data.name);
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#location').val(data.religion);
        }else
        {
            Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    text: 'Ooops...Nenhum iten encotrado!',
                    showConfirmButton: false,
                    timer: 1800
                    })
        }

        },
        error: function () {
            Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: 'Ooops...Algo deu errado. Tente de novo mais tarde',
                    showConfirmButton: false,
                    timer: 1800
                    })
                    Swal.fire(
                        'Ocoreu algum erro?',
                        'Ooops...Algo deu errado. Tente de novo mais tarde',
                        'question'
                        )
         }
        });
        }
    //update function with ajax






//update contacts with ajax
$(function(){
      $('form[name="contact-edit"]').submit(function(event){
            event.preventDefault();

            var id = $(this).find('input#id').val();
            //Swal.fire(name);
          $.ajax({
              type: "PATCH",
              url: "{{ route('contact.update',"id") }}",
              cache: false,
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {

                   if (response.success === true) {

                        Swal.fire({
                        position: 'top-end',
                        background: '#C8E6C9',
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1800
                        })
                        setTimeout("window.location = '{{ route('contact.index') }}';",1800);

                   }else
                   {
                    Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: response.errors,
                    showConfirmButton: false,
                    timer: 1800
                    })
                   }
              },
              error: function (response) {
                  var errors = response.responseJSON.errors;
                  var error = '';
                  for (erros in errors) {
                        error += errors[erros] + '\n';
                  }
                  Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: error,
                    showConfirmButton: false,
                    timer: 1800
                    })
               }
          });

      });
  });
  */

//Read all data ajax
/*var table = $('#table_id').DataTable({
    processing:true,
    serverSide:true,
    ajax: "{{ route('contact.getall') }}",
    column:[
        {data:'id', name:'id'},
        {data:'Nome', name:'name'},
        {data:'Contacto', name:'phone'},
        {data:'Email', name:'email'},
        {data:'Localizacao', name:'religion'},
        {data:'Accao', name:'action'}
    ]
});*/
/*$(function () {

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var table = $('.data-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: "",
  columns: [
      {data: 'DT_RowIndex', name: 'DT_RowIndex'},
      {data: 'name', name: 'Nome'},
      {data: 'phone', name: 'Contacto'},
      {data: 'email', name: 'Email'},
      {data: 'action', name: 'action', orderable: false, searchable: false},
  ]
});
});*/
/*
<script>
function openModel1() {
    $('#id').val('');
    $('#contactForm').trigger('reset');
    $('#title').text('Novo Contacto');
    $('#modal1').modal('open');
 }
$(function(){
 // read all data with ajax
    var table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('contact.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'Nome'},
            {data: 'phone', name: 'Contacto'},
            {data: 'email', name: 'Email'},
            {data: 'religion', name: 'Localizacao'},
            {data: 'action', name: 'Accao', orderable: false, searchable: false},
        ]
    });
    //insert
    $('form[name="contactForm"]').submit(function(event){
            event.preventDefault();
            //console.log($(this).serialize())
        var id = $(this).find('input#id').val();
            //Swal.fire(name);
        if (id === '') {
            $.ajax({
              type: "post",
              url: "{{ route('contact.store') }}",
              data: $(this).serialize(),
              dataType: "json",
              success: function (response) {
                //iff write do this
                   if (response.success === true) {

                        Swal.fire({
                        position: 'top-end',
                        background: '#C8E6C9',
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1800
                        })
                        $('#contactForm').trigger("reset");
                        $('#modal1').modal('close');
                        table.draw();

                   //else do this
                   }else
                   {
                    Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: response.errors,
                    showConfirmButton: false,
                    timer: 1800
                    })
                   }
              },
              //show  errors without do anything
              error: function (response) {
                  //console.log(response.responseJSON.errors)
                  var errors = response.responseJSON.errors;
                  var error = '';
                  for (erros in errors) {
                        error += errors[erros] + '\n';
                  }

                  Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: error,
                    showConfirmButton: false,
                    timer: 1800
                    })
               }
          });
        }else{
            $.ajax({
                type: "put",
                url: "{{ route('contact.update',"id") }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.success === true) {

                        Swal.fire({
                        position: 'top-end',
                        background: '#C8E6C9',
                        icon: 'success',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1800
                        })
                        $('#contactForm').trigger("reset");
                        $('#modal1').modal('close');
                        table.draw();

                        //else do this
                        }else
                        {
                        Swal.fire({
                        position: 'top-end',
                        background: '#FFCDD2',
                        icon: 'error',
                        text: response.errors,
                        showConfirmButton: false,
                        timer: 1800
                        })
                        }
                },
                error: function(response){
                    var errors = response.responseJSON.errors;
                  var error = '';
                  for (erros in errors) {
                        error += errors[erros] + '\n';
                  }

                  Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: error,
                    showConfirmButton: false,
                    timer: 1800
                    })
                }
            });
        }


      });

});

//Add form model
$(function(){
   // $('#send').html('Submit');
    $('.modal').modal();
  });
//edit contact
function editContact(id) {
    var url = "{{route('contact.index')}}"+"/"+id+"/edit";
  $.ajax({
      type: "GET",
      url: url,
      data: "data",
      dataType: "json",
      success: function (response) {
        var data = response.data;
        if (data) {
            $('#modal1').modal('open');
            $('#title').text('Editar Contacto: '+data.name);
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#location').val(data.religion);
        }else
        {
            Swal.fire({
                    position: 'top-end',
                    icon: 'warning',
                    text: 'Ooops...Nenhum iten encotrado!',
                    showConfirmButton: false,
                    timer: 1800
                    })
        }

        },
        error: function () {
            Swal.fire({
                    position: 'top-end',
                    background: '#FFCDD2',
                    icon: 'error',
                    text: 'Ooops...Algo deu errado. Tente de novo mais tarde',
                    showConfirmButton: false,
                    timer: 1800
                    })
                    Swal.fire(
                        'Ocoreu algum erro?',
                        'Ooops...Algo deu errado. Tente de novo mais tarde',
                        'question'
                        )
         }
        });

     }

</script>
 */

