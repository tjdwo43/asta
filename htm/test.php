

<?php
header("Content-type: text/html; charset=UTF-8");


  $cmd="faxstat ";
			     exec($cmd,$arr,$returnvar); 

					for($i=0;$i<100;$i++){
							$str .= $arr[$i];
					}

				  $check1 = strpos($str,'Waiting for modem to come ready' );  
				  $check2 = strpos($str,'Initializing server' ); 

				 echo $check1."/".$check2;
?>


