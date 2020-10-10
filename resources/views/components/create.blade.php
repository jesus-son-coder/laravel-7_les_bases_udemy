@extends('layouts.app')

@section('content')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{ route('article.store') }}">
    <!-- Attention, sans la directive csrf, le formulaire ne fonctionnera pas ! -->
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="title">Titre</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Mon Titre">
      </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="content">Contenu</label>
            <textarea  class="form-control" id="content" name="content" placeholder="Entrez votre contenu"></textarea>
          </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Sauvegarder l'article</button>
    </div>
</form>
@stop
