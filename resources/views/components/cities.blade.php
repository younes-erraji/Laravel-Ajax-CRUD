<div class="form-group">
  <label for="cities">Cities</label>
  <select id="cities" class="form-control" name="city">
    <option selected disabled>Choose...</option>
    @foreach($cities as $city)
      <option value="{{ $city->code }}">{{ $city->name }}</option>
    @endforeach
  </select>
</div>
