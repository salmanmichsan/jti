@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">            
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit No Handphone</div>

                <div class="card-body">
                    <form action="{{route('phone.update',$data->id)}}" enctype="multipart/form-data" method="post">
                        @csrf @method('patch')
                        <input type="hidden" class="form-control" name="id" id="id" value="{{$data->id}}">
                        <div class="form-group">
                          <label for="exampleInputEmail1">No Handphone</label>
                          <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{$data->no_hp}}">
                          {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Provider</label>
                            <select class="form-control" name="provider" id="provider">
                                <option disabled selected></option>
                                <option {{$data->provider=="xl" ? "selected":""}} value="xl">XL</option>
                                <option {{$data->provider=="telkom" ? "selected":""}} value="telkom">Telkom</option>
                                <option {{$data->provider=="tri" ? "selected":""}} value="tri">Tri</option>
                              {{-- <option>4</option> --}}
                              {{-- <option>5</option> --}}
                            </select>
                        </div><br>
                        <button type="submit"  class="btn btn-primary">Update</button>
                        <button type="button" id="batal" class="btn btn-primary">Batal</button>
                      </form>                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#batal').on('click', function (e) {
        window.location.replace("{{route('output')}}");
    });
</script>

@endsection
