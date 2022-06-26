<?php 

    use App\Models\Country;
    use App\Models\State;
    use App\Models\City;
	/**
	* Method Name  	: getAllCountries 
	* Perform Task 	: Get all countries from db.
	* Author 		: Manish Silawat
	**/	
    function getAllCountries() {

        $allCountries = Country::all();
        return $allCountries;
    }
	/**
	* Method Name  	: getAllStates 
	* Perform Task 	: Get all states from db.
	* Author 		: Manish Silawat
	**/	
    function getAllStates() {

        $allStates = State::all();
        return $allStates;
    }
	/**
	* Method Name  	: getAllCities 
	* Perform Task 	: Get all cities from db.
	* Author 		: Manish Silawat
	**/	
    function getAllCities() {

        $allCities = City::all();
        return $allCities;
    }
	/**
	* Method Name  	: getUniqueName 
	* Perform Task 	: Get unique name for image file.
	* Author 		: Manish Silawat
	**/	
    function getUniqueName($extension)
    {
        $name = substr(base_convert(time(), 10, 36) . md5(microtime()), 0, 16) . '.' . $extension;
        return $name;
    }
	function pendingPost(){
        $name = DB::table('posts_request')->where('status','pending')->count();
        return $name;
    }
?>