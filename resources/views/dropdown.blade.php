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
    <div class="place-holder">
      <div class="form-group">
        <label for="cities">Cities</label>
        <select id="cities" class="form-control" name="city"></select>
      </div>
    </div>
  </form>
</div>

@endsection
@section('scripts')
<script src="{{ asset('jquery.min.js') }}"></script>
<script>
  $(document).on('change', '#countries', function (e) {
    var countryCode = e.target.value,
      url = "{{ route('getCities') }}",
      cities = $('#cities');

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: 'POST',
        data: {
          code: countryCode,
        },
        dataType: 'json',
        success: function (data) {
          cities.empty();
          cities.append('<option selected disabled>Choose...</option>');
          if (data.code == 1) {
            for (let i = 0; i < data.cities.length; i++) {
              // console.log('<option value="' + data.cities[i].id + '"">' + data.cities[i].name + '</option>');
              cities.append('<option value="' + data.cities[i].id + '"">' + data.cities[i].name + '</option>');
            }

          } else {
            alert(data.message);
          }

        }
      });
  });
</script>
@endsection
