@extends('layouts.master')
@section('styles')
@endsection
@section('content')
<div class="container mt-5 mb-5">
  <form action="{{ route('getCities') }}" method="POST" id="main-form">
    @csrf
    <div class="form-group">
      <label for="countries">Countries</label>
      <select id="countries" class="form-control" name="country">
        <option selected disabled>Choose...</option>
        @foreach($countries as $country)
        <option value="{{ $country->code }}">{{ $country->name }}</option>
        @endforeach
      </select>
    </div>
    <hr />
    {{--
    <div class="form-group">
      <label for="cities">Cities</label>
      <select id="cities" class="form-control" name="city">

        @foreach($cities as $city)
        <option value="{{ $city->code }}">{{ $city->name }}</option>
        @endforeach

      </select>
    </div>
    --}}
    @include('components.cities')
  </form>
</div>

@endsection
@section('scripts')
<script src="{{ asset('jquery.min.js') }}"></script>
@endsection
