@extends('layouts.app')

@section('content')
    <div class="container">
        @if (isset($message))
            <div id="alert" class="alert {{ $colorClass }} d-flex justify-content-center" role="alert">
                {{ $message }}
            </div>
        @endif
        
        <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var alertElement = document.getElementById("alert");
                    if (alertElement) {
                        setTimeout(function() {
                            alertElement.style.display = "none";
                        }, 1000); // 5000 milliseconds = 5 seconds
                    }
                });
        </script>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h1>Vérification de code</h1>
                        <form action="{{ route('check-code') }}" method="GET">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="code" id="code" class="form-control" placeholder="Taper votre code ">
                            </div>
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Vérifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
