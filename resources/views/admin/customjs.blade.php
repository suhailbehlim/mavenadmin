<script type="text/javascript">

    function getStates(countryId) {
      var url =  "{{ URL::to('admin/getStates') }}/"+ countryId;
      var _token = "{{ csrf_token() }}";
      $.ajax({
          url:url,
          type:'GET',
          data:{
              countryId:countryId,
              _token:_token,
          },
          success:function(result){
            $("#ajaxStates").html(result);
            $("#city_id").val('');
          }
      });
    }
      
    function getCities(stateId) {
      var url = "{{ URL::to('admin/getCities') }}/"+stateId;
      var _token = "{{ csrf_token() }}";
      $.ajax({
          url:url,
          type:'GET',
          data:{
              stateId:stateId,
              _token:_token,
          },
          success:function(result){
            $("#ajaxCities").html(result);
          }
      });
    }
	
	function getModel(make) {
      var url = "{{ URL::to('admin/getModel') }}/"+make;
      var _token = "{{ csrf_token() }}";
      $.ajax({
          url:url,
          type:'GET',
          data:{
              make:make,
              _token:_token,
          },
          success:function(data){
				var obj = JSON.parse(data);
				if(obj.status==true){
					jQuery('#model').html(obj.data);
				}else{
					jQuery('#model').html('<option value="">-- Choose Model --</option>');
					
				}
          }
      });
    }
	
	window.onload = function () {
		var ddlYears = document.getElementById("year");
		var currentYear = (new Date()).getFullYear();
		for (var i = 1950; i <= currentYear; i++) {
			var option = document.createElement("OPTION");
			option.innerHTML = i;
			option.value = i;
			ddlYears.appendChild(option);
		}
	};
  </script>