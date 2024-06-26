@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row ">
    <div class="col-md-8">
      <h1>Articles</h1>
      @foreach ($articles as $item)
      <div class="mb-3">
        <a href="{{ route('articles.show', $item->slug)}}" class="h5 text-primary">Lorem ipsum dolor sit amet
          {{ $item->title }}</a>
        <div>
          <span>{{$item->user->name}}| </span>
          <span>{{$item->created_at}}|</span>
          <span>({{$item->comments_count}}) Comments</span>
        </div>
        <p>{{ $item->description }}</p>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection