<div class="form-group">
    <label for="inputStatus">State<span class="estricCls">*</span></label>
    <select name="state_id" id="state_id" class="form-control custom-select" onchange="getCities(this.value);">
      <option value="">Select State</option>

      @foreach ($allStates as $state)
        <option value="{{ $state->id }}">{{ $state->name }}</option>
        @endforeach
    </select>
</div>