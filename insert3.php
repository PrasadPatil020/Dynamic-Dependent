<?php
session_start();
include 'conn.php';

if (($_SESSION['email'] != 'admin@admin.com') )
{
 header("Location:index.php");
}
 
 // date_default_timezone_set('Asia/Calcutta'); 

if(isset($_POST['done'])){
 
   $course_name  = $_POST['course_name']; 
   $country_name  = $_POST['country_name'];
   $city_name = $_POST['city_name'];
   $delivery_mode = $_POST['delivery_mode'];
   $sdate = $_POST['sdate'];
   $edate = $_POST['edate'];
   $stime = $_POST['stime'];
   $etime = $_POST['etime'];
   $duration = $_POST['duration'];
   $actual_price  = $_POST['actual_price'];
   $discount_price = $_POST['discount_price'];
   $price_validity_date = $_POST['price_validity_date'];
   $tname = $_POST['tname'];
   $embed_link = $_POST['embed_link'];
 
 $q = "INSERT INTO calender"."(course_name1,country_name1,city_name1,delivery_mode,sdate,edate,stime,etime,duration,actual_price,discount_price,price_validity_date,tname,embed_link)"."VALUES"."('$course_name','$country_name','$city_name','$delivery_mode','$sdate','$edate','$stime','$etime','$duration','$actual_price','$discount_price','$price_validity_date','$tname','$embed_link')";
 

 $result=$conn->query($q);

  if ($result==true) 
  {
    # code...
    $message = "Data Inserted Successfully...!";
echo "<script type='text/javascript'>alert('$message');</script>";
header("location:display3.php");
  }
  else
  {
    echo "Error".$q."<br>".$conn->error;
  }
  $conn->close();
  }
?>

<!DOCTYPE html>
<html>
<head>
 <title></title>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="css.css">
<link type="text/css" rel="stylesheet" href="style.css"/>    
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
    <script src="jquery.min.js"></script>
</head>
<?php 
include 'includes/header.php';
include 'includes/navbar.php';

?>
<script type="text/javascript">
$(document).ready(function(){
    $('#country').on('change',function(){
        var countryID = $(this).val();
        if(countryID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'country_id='+countryID,
                success:function(html){
                    $('#state').html(html);
                    $('#city').html('<option value="">Select city first</option>'); 
                }
            }); 
        }else{
            $('#state').html('<option value="">Select country first</option>');
            $('#city').html('<option value="">Select city first</option>'); 
        }
    });
    
    $('#state').on('change',function(){
        var stateID = $(this).val();
        if(stateID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'state_id='+stateID,
                success:function(html){
                    $('#city').html(html);
                }
            }); 
        }else{
            $('#city').html('<option value="">Select city first</option>'); 
        }
    });
});
</script>
<body>

 <div class="col-lg-6 m-auto">
 
 <form method="post" enctype="multipart/form-data">
 
 <br><br><div class="card">
 
 <div class="card-header bg-dark">
 <h4 class="text-white text-center">Add Calender</h4>
</div><br>
<label>Select Course Name</label>
<select name="course_name">
  <option value="0">Select Course Name</option>
  <?php  
$q = "select * from course order by course_name asc";

 
 $query = mysqli_query($conn,$q);

 while($res = mysqli_fetch_array($query)){
  ?>
<option value="<?php echo $res['course_name']?>" ><?php echo $res['course_name']?></option>
<?php } ?>
</select> <br>
<?php
    //Include database configuration file
    include('dbConfig.php');
    
    //Get all country data
    $query = $db->query("SELECT * FROM countries WHERE status = 1 ORDER BY country_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    ?>
    <label>Select Country</label>
<select name="country_name" id="country" >
        <option value="">Select Country</option>
        <?php
        if($rowCount > 0){
            while($row = $query->fetch_assoc()){ 
                echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
            }
        }else{
            echo '<option value="">Country not available</option>';
        }
        ?>
    </select>
    <label>Select City</label>
    <select name="city_name" id="state">
        <option value="">Select country first</option>
    </select>

<label>Delivery Mode</label>
<select name="delivery_mode">
  <option value="0">Select Delivery Mode</option>
  <option value="Online">Online</option>
  <option value="Classroom">Classroom</option>
</select>
 <label>Start Date</label>
 <input required placeholder="Enter Start Date" type="date" name="sdate"  class="form-control"> <br>
<label>End Date</label>
 <input required placeholder="Enter End Date" type="date" name="edate"  class="form-control"> <br>
 <label>Start Time</label>
 <input required placeholder="Enter Start Time" type="time" name="stime"  class="form-control"> <br>
 <label>End Time</label>
 <input required placeholder="Enter End Time" type="time" name="etime"  class="form-control"> <br>
 <label>Duration</label>
 <input required placeholder="Enter Duration" type="number" name="duration"  class="form-control"> <br>
 <label>Actual Pricing</label>
 <input required placeholder="Enter Pricing" type="number" name="actual_price"  class="form-control"> <br>
 <label>Discounted Price</label>
 <input required placeholder="Enter Price" type="number" name="discount_price"  class="form-control"> <br>
 <label>Price Validity Date</label>
 <input required placeholder="Enter Price Validity Date" type="date" name="price_validity_date"  class="form-control"> <br>
<label>Trainer Name</label>
 <input required placeholder="Enter Trainer Name" type="text" name="tname"  class="form-control"> <br>
 <label>Embed Link</label>
 <input required placeholder="Enter Embed Link" type="text" name="embed_link"  class="form-control"> <br>

 <button class="btn btn-success" type="submit" name="done"> Submit </button><br>

 </div>
 </form>
 </div>
</body>
</html>
<?php
include 'includes/footer.php';
?>