@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form') }}</div>

                <div class="card-body">

                    @if(session('message'))
                    <p class="alert alert-{{ session('style') ?? 'info' }}">{{ session('message') }}</p>
                    @endif


                    <form id="form" action="{{ route('xml-file.upload') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <div class="custom-file {{$errors->has('file') ? 'is-invalid' : ''}}">
                                <input id="file"  type="file" class="custom-file-input" name="file" multiple>
                                <label class="custom-file-label" for="files">Choose XML files</label>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('file') }}
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox my-3">
                            <input id="background" type="checkbox" class="custom-control-input" name="background" value="1">
                            <label class="custom-control-label" for="background">Asynchronously process</label>
                        </div>
                        <button class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
