<?php if (!isset($conn)) {
    include 'db_connect.php';

   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Other form processing logic...
    
        // Image upload and database storage
        $image_path = 'photo';
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
            $target_dir = "images/"; // Change this to your desired upload directory
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
            $image_path = $target_file;
    
            // Save $image_path to your database column
            // Example: $image_path can be stored in the "image_column" of your database table
            // You need to modify this based on your database schema
             $query = "UPDATE package SET photo = '$image_path' WHERE id = $id";
             mysqli_query($conn, $query);
        }
    
        // Continue with the rest of your form processing logic...
        // Save other form fields to the database
    }
    


} ?>

<style>
    textarea {
        resize: none;
    }
</style>

<div class="row">
    <!-- First Column -->
    <<div class="col-md-6 order-md-first">
        <div class="card card-outline card-primary">
            <div class="card-body">
                <form action="" id="manage-package">
                    <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                    <div id="msg" class=""></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="carrier" class="control-label">Carrier</label>
                                <select name="carrier" id="carrier" class="form-control form-control-sm" required>
                                    <?php
                                    // Assume $conn is the database connection object
                                    $query = "SELECT * FROM carrier"; // Change 'carriers' to your actual table name
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $carrierId = $row['id']; // Assuming you have a column named 'id'
                                            $carrierName = $row['carrier']; // Assuming you have a column named 'carrier'
                                            $selected = ($sender_carrier == $carrierId) ? 'selected' : '';

                                            echo "<option value=\"$carrierId\" $selected>$carrierName</option>";
                                        }

                                        mysqli_free_result($result);
                                    } else {
                                        // Handle database query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="recipient" class="control-label">Recipient</label>
                                <select name="recipient" id="recipient" class="form-control form-control-sm" required>
                                    <?php
                                    // Assume $conn is the database connection object
                                    $query = "SELECT * FROM branches"; // Change 'carriers' to your actual table name
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $recipientId = $row['id']; // Assuming you have a column named 'id'
                                            $recipientName = $row['street']; // Assuming you have a column named 'carrier'
                                            $selected = ($sender_carrier == $carrierId) ? 'selected' : '';

                                            echo "<option value=\"$recipientId\" $selected>$recipientName</option>";
                                        }

                                        mysqli_free_result($result);
                                    } else {
                                        // Handle database query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sender" class="control-label">Sender</label>
                                <select name="recipient" id="recipient" class="form-control form-control-sm" required>
                                    <?php
                                    // Assume $conn is the database connection object
                                    $query = "SELECT * FROM branches"; // Change 'carriers' to your actual table name
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $senderId = $row['id']; // Assuming you have a column named 'id'
                                            $senderName = $row['street']; // Assuming you have a column named 'carrier'
                                            $selected = ($sender_sender == $senderId) ? 'selected' : '';

                                            echo "<option value=\"$senderId\" $selected>$senderName</option>";
                                        }

                                        mysqli_free_result($result);
                                    } else {
                                        // Handle database query error
                                        echo "Error: " . mysqli_error($conn);
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dtype">Arrived Damaged</label>
                                <input type="checkbox" name="damage" id="dtype" <?php echo isset($type) && $type == 1 ? 'checked' : '' ?> data-bootstrap-switch data-toggle="toggle" data-on="Damaged" data-off="Good" class="switch-toggle status_chk" data-size="xs" data-offstyle="info" data-width="5rem" value="1">
                                <small>Damaged = Package damaged on arrival</small>
                                <small>, Good = Package not damaged on arrival</small>
                            </div>
                            <div class="form-group">
                                <label for="recipient" class="control-label">Status</label>
                                <select name="status" id="status" class="form-control form-control-sm" required>
                                    <?php
                                    // Custom status options
                                    $statusOptions = array(
                                        'Recieved',
                                        'Collected / Stored',
                                        'Out for Delivery',
                                        'Checkpoint',
                                        'Delivered',
                                        'Unsuccessful Delivery Attempt'

                                        // Add more options as needed
                                    );

                                    // Assuming $selectedStatus is the selected status value
                                    foreach ($statusOptions as $status) {
                                        $selected = ($selectedStatus == $status) ? 'selected' : '';
                                        echo "<option value=\"$status\" $selected>$status</option>";
                                    }
                                    ?>
                                </select>
                            
                            </div>
                            <div class="form-group">
                                <label for="image" class="control-label">Add Image</label>
                                <input type="file" name="image" id="image" class="form-control-file" onchange="displayImgCover(this)">
                                <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 50%; margin-top: 10px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Second Column -->
    <div class="col-md-6 order-md-first">
        <div class="form-group">
            <label for="" class="control-label">Current Location</label>
            <input type="text" name="location" id="" class="form-control form-control-sm" value="<?php echo isset($location) ? $location : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Quantity</label>
            <input type="text" name="quantity" id="" class="form-control form-control-sm" value="<?php echo isset($quantity) ? $quantity : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Weight</label>
            <input type="text" name="weight" id="" class="form-control form-control-sm" value="<?php echo isset($weight) ? $weight : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Province of Destination</label>
            <input type="text" name="province" id="" class="form-control form-control-sm" value="<?php echo isset($province) ? $province : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">District</label>
            <input type="text" name="district" id="" class="form-control form-control-sm" value="<?php echo isset($district) ? $district : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="" class="control-label">LLG</label>
            <input type="text" name="llg" id="" class="form-control form-control-sm" value="<?php echo isset($llg) ? $llg : '' ?>" required>
        </div>
    </div>
</div>

    </div>
</div>

        <!-- Save Row -->
        <div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-package">Save</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=package_list">Cancel</a>
  		</div>
  	</div>
	</div>
</div>

<script>
  
	$('#manage-package').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#parcel-items tbody tr').length <= 0){
      alert_toast("Please add atleast 1 parcel information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_package',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
			// if(resp){
      //       resp = JSON.parse(resp)
      //       if(resp.status == 1){
      //         alert_toast('Data successfully saved',"success");
      //         end_load()
      //         var nw = window.open('print_pdets.php?ids='+resp.ids,"_blank","height=700,width=900")
      //       }
			// }
        if(resp == 1){
            alert_toast('Data successfully saved',"success");
            setTimeout(function(){
              location.href = 'index.php?page=package_list';
            },2000)

        }
			}
		})
	})
    function displayImgCover(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result).show();
        }

        reader.readAsDataURL(input.files[0]);
    }
}


</script>

