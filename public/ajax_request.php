<?php 

	$host 		= "localhost";
	$user		= "root";
	$password	= "";
	$database	= "location";
	$conn = mysqli_connect($host,$user,$password,$database);
	if(!$conn)
	{
		die(mysqli_error());
	}

	if(isset($_POST['idM']) && $_POST['idM'] !='')
	{
		$idMarque = $_POST['idM'];
		$sql ="select * from `model` where idM = ".$idMarque ;
		$rs = mysqli_query($conn,$sql);
		$numRows = mysqli_num_rows($rs);
		
		if($numRows == 0)
		{
			echo 'Aucun model de cette marque ';
		}
		else
		{
            echo    " <label> Model :</label>" ;
            echo  ' <select tabindex="2" required id="model" name="model" style="width: 140px">';
              
			while($model = mysqli_fetch_assoc($rs) )
			{
				echo '<option value="'.$model['idModel'].'">'.$model['libelleMo'].'</option>';
			}
			echo '</select>';
		}
		
	}

?>
