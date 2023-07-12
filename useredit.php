<?php 
require_once('header.php');


$user_id = $_GET['id'];

$select_cc_card = "SELECT * FROM `cc_card` WHERE `id`='".$user_id."'";
$result1 = mysqli_query($connection,$select_cc_card);
	if(mysqli_num_rows($result1) > 0){
		while($rows = mysqli_fetch_assoc($result1)){
			$fetch_name = $rows['lastname'];
			$fetch_address = $rows['address'];
			// $fetch_city = $rows['city'];
			$fetch_state = $rows['state'];
			$fetch_country = $rows['country'];
			
			$fetch_phone = $rows['phone'];
			$fetch_email = $rows['email'];
			$fetch_zipcode = $rows['zipcode'];			
			
		}
	}
	
	$client = "SELECT * FROM `Client` WHERE `clientid`= '".$user_id."'";
	$res = mysqli_query($connection,$client);
	if(mysqli_num_rows($res)>0){
		while($raws= mysqli_fetch_assoc($res)){
			$fetch_companyname = $raws['clientName'];
		}
	}
// echo "<pre>";
// print_r($rows);
// echo "</pre>";

	// $select_Client = "SELECT * FROM 'Client' WHERE `id`='".$user_id."'";
	// $result_Client = mysqli_query($connection, $select_Client) or die("query failed.");
	// if(mysqli_num_rows($result_Client) > 0){
	// 	while($rows_client = mysqli_fetch_assoc($result_Client)){
	// 		$fetch_phone = $rows_client['phone'];
	// 	}
	// }
	$filename = '';
	$name = '';
if(isset($_POST['update'])){
	
	$error = 'false';
	$name = $_POST['name'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$company_name = $_POST['companyname'];
	// $city = $_POST['city'];
	$plan_type = $_POST['plan'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$zipcode = $_POST['zipcode'];
	//  $image = $_POST['profile_image'];

	// print_r($_FILES ["profile_image"]);
	 $filename = $_FILES["profile_image"]["name"];
	 $tempname  = $_FILES["profile_image"]["tmp_name"];
	 $folder = "profile_image/".$user_id.$name."_".$filename;
	 $imageFileType =  (pathinfo($filename,PATHINFO_EXTENSION));
    //  echo $folder ;
 	
	
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 300000) {
		$sizeErr="Sorry, your Image size is too large";
		$error = 'true';
	}
	// Allow certain file formats
	if($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
		$fileErr = "Sorry, only JPG, JPEG, PNG  files are allowed";
	$error = 'true';
	}

	if($error == 'false'){
		move_uploaded_file($tempname,$folder);

		$query1 = "UPDATE `users_login` SET `email` = '".$email."', `name` = '".$name."', `profile_image` = '".$filename."' WHERE `id`='".$user_id."'";
		mysqli_query($connection, $query1) or die("query failed");
			
		$query2 = "UPDATE `cc_card`  SET `lastname` = '".$name."', `firstname`='".$name."',`address` = '".$address."',`state`='".$state."',`country`='".$country."',`zipcode`='".$zipcode."',`phone`='".$phone."', `email` = '".$email."' WHERE `id`='".$user_id."'";
		mysqli_query($connection, $query2) or die("query failed");

		$query3 = "UPDATE `Client` SET `clientName` = '".$company_name."' WHERE `clientid` = '".$user_id."'";
		mysqli_query($connection, $query3) or die("query failed");

		echo "<script>alert('data updated successfully.')</script>";
	}
}

$select_users_login = "SELECT * FROM `users_login` WHERE `id`='$user_id'";

$result_users_login = mysqli_query($connection, $select_users_login) or die("query failed");
if(mysqli_num_rows($result_users_login) > 0){
	$rowss = mysqli_fetch_assoc($result_users_login);
	$fetch_plan = $rowss['plan_id'];
}
?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1">Edit User Information <span style="margin-left:50px;color:blue;"></span></h2>
<div class="table-data__tool-right">
<a href="users.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
	<div class="col-md-9">
        <div class="queue_info">
<form id="userForm" action="<?php $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                
<input id="role" name="role" value="2" class="form-control" type="hidden" value="1"/>


<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Name</label>
</div>
<div class="col-12 col-md-9">
<input id="fname" name="name" placeholder="Name" class="form-control" type="text" value="<?php echo $fetch_name; ?>"/>
<span style="color:red;"><?php echo $nameErr; ?></span>
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Address*</label>
</div>
<div class="col-12 col-md-9">
<input id="address" name="address" placeholder="address" class="form-control" type="text" value="<?php echo $fetch_address; ?>"/>
<span style="color:red;"><?php echo $addressErr; ?></span>
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Country</label>
</div>
<div class="col-12 col-md-9">
<?php 
	// $select_country = "SELECT * FROM `cc_country`";
	// $result_country = mysqli_query($connection, $select_country) or die("query failed");
	// if(mysqli_num_rows($result_country) > 0){
?>
<select name="country" id="country" class="form-control">

<option value="USA">United State</option>
	<?php 
	
if($_SESSION['userroleforpage'] == 2 && $user_id !== $_SESSION['login_user_id']){ ?>
	<script>
    	window.location='access_denied.php';    
	</script>
<?php }

	?>
		<option <?php// echo $select ?> value="<?php // echo $row['countrycode'] ?>"><?php // echo $row['countryname'] ?></option>
	<?php // } ?> 
</select>
<?php// } ?>

</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">State</label>
</div>
<div class="col-12 col-md-9">
<select name="state" id="state" class="form-control">
	<option value="">---Select State---</option>
	<?php 
	$state_query = "SELECT distinct(`State`) FROM `state_stdcode` WHERE `countryCode` = 'USA'";
	$result_state = mysqli_query($connection, $state_query) or die("query failed");
	if(mysqli_num_rows($result_state) > 0){
		while($state_row = mysqli_fetch_assoc($result_state)){
			$states = $state_row['State'];
			if($state_row['State'] == $fetch_state){
				$select = "selected";
			}else{
				$select = "";
			}	
	?>
	<option value="<?php echo $state_row['State'] ?>" <?php echo $select;?> ><?php echo $state_row['State']?></option>
	<?php
		}
	}
	?>
</select>
</div>
</div>
<!-- <div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">City</label>
</div>
<div class="col-12 col-md-9">
	<?php 
	// $select_city = "SELECT `City` FROM `state_stdcode`";
	// $result_city = mysqli_query($connection, $select_city) or die("query failed");
	// if(mysqli_num_rows($result_city) > 0){
	?>
<select name="city" id="city" class="form-control">
	<option value="">---Select City---</option>
	<?php
	//  while($city_rows = mysqli_fetch_assoc($result_city)){
	// 	$city = $city_rows['City']; 
	// 	if($fetch_city==$city){
	// 		$select = "selected";
	// 	}else{
	// 		$select = "";
	// 	}
	?>
	<option <?php // echo $select; ?> value="<?php// echo $city_rows['City'];?>"><?php // echo $city_rows['City'];?></option>
	<?php 
	//	}	
	?>
</select>
<?php// } ?>
</div>
</div> -->
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">CompanyName</label>
</div>
<div class="col-12 col-md-9">
<input id="companyname" name="companyname" placeholder="company name" class="form-control" type="text" value="<?php echo $fetch_companyname; ?>"/>

</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Plan Type</label>
</div>
<div class="col-12 col-md-9">
<?php
     $plan_sql = "SELECT * FROM `master_plans`";
     $result_sql = mysqli_query($connection, $plan_sql) or die("query failed");
     if(mysqli_num_rows($result_sql)> 0){
     ?>
<select disabled name="plan" id="plan" class="form-control">
		<option value="">---Select Plan---</option>
		<?php while($plan_row = mysqli_fetch_assoc($result_sql)){
			$plan_id = $plan_row['id'];
			if($fetch_plan == $plan_row['id']){
				$select = "selected";
			}else{
				$select = "";
			}
			?>
		<option <?php echo $select ?> value="<?php echo $plan_row['id'];?>"><?php echo $plan_row['name'];?></option>
	<?php } ?>
</select>
<?php } ?>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class="form-control-label">Phone</label>
</div>
<div class="col-12 col-md-9">
<input id="phone" name="phone" placeholder="phone" class="form-control" type="number" value="<?php echo $fetch_phone; ?>"/>
<span style="color:red;"><?php echo $phoneErr; ?></span>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email</label>
</div>
<div class="col-12 col-md-9">
<input id="email" name="email" placeholder="Email" class="form-control" type="text" value="<?php echo $fetch_email ?>"/>
<span style="color:red;"><?php echo $emailErr; ?></span>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">ZIP-CODE</label>
</div>
<div class="col-12 col-md-9">
<input id="ZIP" name="zipcode" placeholder="ZIP CODE" class="form-control" type="number" value="<?php echo $fetch_zipcode ?>"/>
<span style="color:red;"><?php// echo $emailErr; ?></span>
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label  class=" form-control-label">IMAGE</label>
</div>
<div class="col-12 col-md-9">
<input id="profile_image" name="profile_image" placeholder="update your image" class="form-control" type="file" />
<?php 
echo "<span style='color:red;'>".$sizeErr."</span>";
echo "<span style='color:red;'>".$fileErr."</span>";
?>
<div class="col-12 col-md-9" id="profile_image_div">
	<?php
	//echo '<pre>'; print_r($rowss); echo '</pre>';
	if($rowss['profile_image']!=''){
		$folder = "profile_image/".$user_id.$rowss['name']."_".$rowss['profile_image'];
		
		echo "<img src ='$folder' height='100px' width='100px'>";
		?>
		<button type="button" class="btn btn-danger btn-sm" id="delete-btn" user_id="<?php echo $rowss['id']; ?>" >Remove Image </button>
		<?php }	
		?>
		</div>	
</div>
</div>
<div class="alert alert-danger" id="error-message" style="display:none;"></div>
<div class="alert alert-success" id="success-message" style="display:none;"></div>

			<div class="form-group pull-right">
			 <button type="submit" name="update" class="btn btn-primary btn-sm">Update</button>
			</div>
			<p style="color:blue;"></p>
</form>	
</div>
</div>	
</div>
</div>
</div>
</div>
</div>
<script>

       $(document).on("click" , " #delete-btn", function(){
            if(confirm("Do you really want to delete this image?")){
                var user_id = $(this).attr("user_id"); 
				
                
            $.ajax({
                url : "pdelete.php",
                type : "POST",
                data : {id : user_id},
                success : function(data){
                    if(data == 1){
                        $('#profile_image_div').fadeOut();
						$("#success-message").html("Image Deleted").slideDown();
						$("#error-message").slideUp();
                    }else{
                        $("#error-message").html("cant delete image").slideDown();
                        $("#success-message").slideUp();
                    }
				}
           });
		}
     });	
</script>
</div>
<br>
<?php require_once('footer.php'); ?> 

 
