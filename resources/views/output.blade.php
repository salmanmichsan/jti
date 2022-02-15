@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">            
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Data No Handphone</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table" id="tableganjil">
                                <thead>
                                    <tr>
                                        <th>Ganjil</th>
                                        <th>Provider</th>
                                        <th>Action</th>                                                                      
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table" id="tablegenap">
                                <thead>
                                    <tr>                                        
                                        <th>Genap</th>
                                        <th>Provider</th>  
                                        <th>Action</th>                              
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="edit-modal-label">Edit Data</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="attachment-body-content">
              <form id="edit-form" class="form-horizontal" method="POST" action="">
                <div class="card text-white bg-dark mb-0">
                  <div class="card-header">
                    <h2 class="m-0">Edit</h2>
                  </div>
                  <div class="card-body">
                    
                    <!-- name -->
                    <div class="form-group">
                      <label class="col-form-label" for="modal-input-name">No HP</label>
                      <input type="text" name="modal-input-nohp" class="form-control" id="modal-input-nohp" required autofocus>
                    </div>
                    <!-- /name -->
                    <!-- description -->
                    <div class="form-group">
                      <label class="col-form-label" for="modal-input-description">Provider</label>
                      <input type="text" name="modal-input-provider" class="form-control" id="modal-input-provider" required>
                    </div>
                    <!-- /description -->
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
      
      
</div>
@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> --}}
<script>
    
    function getData(){
        $.ajax({
            url: "{{route('getData')}}",
            type: "get",
            
            success: function (s) {
                // alert(s.message);
                // console.log(s)   
                setTable(s.ganjil,'ganjil');
                setTable(s.genap,'genap');

            },
            error: function () {
                alert("Error", "Unable to bring up the dialog.", "error");
            }
        });
    }

    function setTable(data,jenis){
        var trHTML = '';
        $.each(data, function (i, item) {
           
            trHTML += '<tr class="data-row">'+
                        '<td class="nohp">' + item.no_hp + '</td>'+
                        '<td class="provider">' + item.provider + '</td>'+
                        '<td>'+
                            '<button type="button" onClick="hapus('+item.id+')" class="btn btn-danger" >Hapus</button>'+
                            '<a type="button" type="button" href="/phone/'+item.id+'/edit" class="btn btn-primary" id="edit-item">Edit</a>'+
                        '</td></tr>';
        });
        if(jenis == 'ganjil'){
            $("#tableganjil > tbody").html(trHTML); 
        }
        if(jenis == 'genap'){
            $("#tablegenap > tbody").html(trHTML);
        }
    }

    function hapus(id){
        
        if(!confirm("Do you really want to do this?")) {
            return false;
        }
        var uri = "/phone/"+id;
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax(
        {
            url: uri,
            type: 'DELETE',
            data: {
                "id": id,
                _token: token,
            },
            success: function (){
                console.log("it Works");
                Swal.fire(
                'Remind!',
                'Phone Number deleted successfully!',
                'success'
                )
                getData();
            }
        });
        
    }

    $(document).ready(function() {

        getData();
        setInterval(function() {
            getData()}, 5000);
    });

</script>

@endsection
