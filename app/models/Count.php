<?php

class Count extends Illuminate\Database\Eloquent\Model {

	protected $fillable = array('date', 'store_id');

	public static function getByRange($start, $end){

		if (!isset($start)){
	        $start = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
	    
	    }
	    if (!isset($end)){
	        $end = date('Y-m-d', mktime(0, 0, 0, date("m"), date("t"), date("Y")));
	    }

	    return Count::where('date','>=', $start)
	                ->where('date', '<=', $end)
	                ->take(90)
	                ->orderBy('date')
	                ->get();

	}

	public static function getByRangeGrouped($start, $end, $groupBy){

		if (!isset($start)){
	        $start = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
	    
	    }
	    if (!isset($end)){
	        $end = date('Y-m-d', mktime(0, 0, 0, date("m"), date("t"), date("Y")));
	    }

	    $query = Count::selectRaw('sum(count) as count');

	    switch ($groupBy) {
	    	case 'store':
	    		$query->addSelect("store_id")->groupBy('store_id');
	    		break;

	    	case 'date':
	    		$query->addSelect("date")->groupBy('date');
	    		break;
	    	
	    	default:
	    		return Count::getByRange($start, $end);
	    		break;
	    }

	    $query->where('date','>=', $start)->where('date', '<=', $end);
	    
	    return $query->orderBy('date')->get();

	}

	public static function getByStoreId($storeid, $start, $end){
		if (!isset($start)){
	        $start = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
	    
	    }
	    if (!isset($end)){
	        $end = date('Y-m-d', mktime(0, 0, 0, date("m"), date("t"), date("Y")));
	    }

	    return Count::where('date','>=', $start)
	                ->where('date', '<=', $end)
	                ->where('store_id', '=', $storeid)
	                ->take(32)
	                ->orderBy('date')
	                ->get();
	}

}
?>