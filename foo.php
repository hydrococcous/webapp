<?php
	
	$dateArr[0] = '2014-07-01 00:00:00';
	
	
	for($i = 0; $i < 31; $i++){
		
		if($i < 10){
			$a = '0'.$i+1;
		} else {
			$a = $i+1;
		}
		
		$dateArr[$i] = '2014-07-'.$a.' 00:00:00';
		
		echo strtotime($dateArr[$i]);
		echo '<br />';
		
	}
	

	 
	
?>