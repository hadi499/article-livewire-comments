@extends('layouts.app')
@push('css')
@livewireStyles
@endpush
@push('js')
@livewireScripts

@endpush

@section('content')
<div class="container">
  <div class="row ">
    <div class="col-md-8">


      <div class="my-3">
        <h3>{{ $article->title }}</h3>
        <div>
          <span>{{$article->user->name}}</span>
          <span>{{$article->created_at}}</span>

        </div>
        <p class="my-3 text-secondary">{{$article->body}}</p>
      </div>
      @livewire('articles.comment', ['id' => $article->id])
    </div>
  </div>
  @endsection