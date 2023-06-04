@extends('layouts.app')

@section('content')
<style>.card-title{font-size: 20px; font-family: 'Tajawal', sans-serif; padding: 15px;}
</style>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-white" >
                        <div class="card-title d-flex justify-content-center" >nombre total de codes générés</div>
                            <div class="card-body">
                                <span class="d-flex justify-content-center" style="font-size: 80px;">{{ $codeCount }}</span>
                            </div>
                        </div>
                    </div>    
            </div>
            <div class="col-12">
                    <div class="card bg-white mt-4" >
                        <div class="card-title d-flex justify-content-center">Vérification de code</div>
                            <div class="card-body">
                                <div class="row">
                                        <div class="col-12">
                                            <a class="btn btn-success d-flex justify-content-center" href="{{ url('/verficationcode')}}">verifier votre code</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>    
        </div>
        <div class="col-6">
            <div class="card bg-white">
                <div class="card-title d-flex justify-content-center">Graphique des codes générés par jour</div>
                <div class="card-body">
                    <canvas id="code-chart"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Récupérer les données depuis votre backend 
                    var codeData = {!! json_encode($codeData) !!}; // Supposons que vous ayez préparé les données dans la variable $codeData dans Codecontroller

                    // Préparer les étiquettes d'axe (dates) et les valeurs (nombre de codes générés)
                    var dates = [];
                    var counts = [];

                    codeData.forEach(function(item) {
                        dates.push(item.date);
                        counts.push(item.count);
                    });

                    // Créer un graphique avec Chart.js
                    var ctx = document.getElementById('code-chart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: dates,
                            datasets: [{
                                label: 'Codes générés',
                                data: counts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-white">
                    <div class="card-title">
                        <div class="d-flex justify-content-center">
                        les clients ayant généré un code
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Fullname</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td scope="row">{{ $client->client_id }}</td>
                                    <td>{{ $client->Clientname }}</td>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
