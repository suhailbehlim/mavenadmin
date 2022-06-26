<div class="form-group">
    <label for="inputStatus">City<span class="estricCls">*</span></label>
    <select name="city_id" id="city_id" class="form-control custom-select" >
      <option value="">Select City</option>

      @foreach ($allCities as $city)
        <option value="{{ $city->id }}">{{ $city->name }}</option>
      @endforeach
    </select>
</div>