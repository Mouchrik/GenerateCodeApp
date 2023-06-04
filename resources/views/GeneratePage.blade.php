@extends('layouts.app')

@section('content')

<script>
    // Disable right-click and inspect element
    document.addEventListener("contextmenu", function (e) {
        e.preventDefault();
    });
    document.addEventListener("keydown", function (e) {
        if (e.keyCode === 123 || (e.ctrlKey && e.shiftKey && e.keyCode === 73)) {
            e.preventDefault();
        }
    });
</script>  <!-- The Check value is true, perform actions here -->
@if(isset($Check) && $Check === false)
<style>
#generate-button{display: none;}
#code-display{   background-color: white;
                color:black;
                font: size 18px;
                margin: 15px;
                padding: 15px;
                border:1px solid black;
                border: raduis 15px;}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var codeDisplay = document.getElementById("code-display");
        
        if (codeDisplay) {
            codeDisplay.innerHTML = "Votre code : {{ $code_generate }}";
        }
    });
</script>
@endif
<!--Add Style-->
<style>
    .GenerationcodeCard{border-radius: 15%; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);}
</style>
<div class="container GenerationcodeCard">
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">
                <h1>Générateur de code</h1>
                
                <button id="generate-button" class="btn btn-primary">Générer le code</button>

                <div class="d-flex justify-content-center" id="code-display" ></div>
                </div>
            </div>
        </div>
    </div>

</div>
    <script>
        document.getElementById("generate-button").addEventListener("click", function() {
            // Envoyer une requête AJAX à la route Laravel pour générer le code
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/generate-code", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Afficher le code généré à l'utilisateur
                    var response = JSON.parse(xhr.responseText);
                    var codeDisplay = document.getElementById("code-display");
                    codeDisplay.innerHTML = "Votre code : " + response.code;
                    codeDisplay.style.display = "block";

                    // Cacher le bouton de génération de code
                    var generateButton = document.getElementById("generate-button");
                    generateButton.style.display = "none";
                }
            };

            xhr.send();
        });
    </script>
@endsection

