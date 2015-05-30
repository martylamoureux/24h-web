@extends('app')

@section('content')


<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <h1 class="text-center">A propos de notre projet</h1>
        </div>
    </div>
    <div class="panel-body">
        <h4>Technologies</h4>
        <br/>
        <p><strong>Version de PHP : </strong>5.6</p>
        <p><strong>Framework : </strong>Laravel 5</p>
        <p><strong>Système de gestion de base de données : </strong>MySQL</p>
        <p><strong>Mise en production automatique avec Git : </strong>Envoyer <i><a href="https://envoyer.io/">(Lien)</a></i></p>
        <p><strong>Versionning : </strong>GitHub <i><a href="https://github.com/martylamoureux/24h-web">(Lien)</a></i></p>
        <br/>
        <h4>Explication de nos choix</h4>
        <p>Nous avons choisit de prendre le framework Laravel 5 pour sa rapidité et sa simplicité. Ce framework est dérivé de Symfony2, et permet de profiter du noyau de Symfony2 (gestion requête/réponse, etc...) tout en se passant du principe de bundles. De plus Laravel est le framework qui à la meilleur courbe de popularité.
        </p>
    </div>
</div>

@endsection