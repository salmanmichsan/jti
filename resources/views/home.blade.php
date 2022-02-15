@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">            
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Data No Handphone</div>

                <div class="card-body" >
                    <form id="form-data">
                        <div class="form-group">
                          <label for="exampleInputEmail1">No Handphone</label>
                          <input type="text" class="form-control" name="phone" id="phone">
                          
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Provider</label>
                            <select class="form-control" name="provider" id="provider">
                                <option disabled selected></option>
                                <option value="xl">XL</option>
                                <option value="telkom">Telkom</option>
                                <option value="tri">Tri</option>                              
                            </select>
                        </div><br>
                        <button type="button" id="simpan"  class="btn btn-primary">Simpan</button>
                        <button type="button" id="auto" class="btn btn-primary">auto</button>
                        <a type="button" href="{{route('output')}}" target="_blank" class="btn btn-primary">Output</a>
                      </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#output').on('click', function (e) {
        window.location.replace("{{route('output')}}");
    });
    $('#simpan').on('click', function (e) {
        e.preventDefault();
        
        var phone = $('#phone').val();
        var provider = $('#provider').val();    
        $.ajax({
            url: "{{route('phone.store')}}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                no_hp: phone,
                provider: provider
            },
            success: function (s) {
                // alert(s.message);
                
                Swal.fire(
                'Remind!',
                'Create Phone Number successfully!',
                'success'
                )
                document.getElementById("form-data").reset();
            },
            error: function () {
                alert("Error", "Unable to bring up the dialog.", "error");
            }
        });
    });

    $('#auto').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{route('auto')}}",
            type: "get",
            success: function (s) {
                alert(s.message);       
                Swal.fire(
                'Remind!',
                'Auto Generate Phone Number successfully!',
                'success'
                )             
            },
            error: function () {
                alert("Error", "Unable to bring up the dialog.", "error");
            }
        });
    });
</script>

@endsection
