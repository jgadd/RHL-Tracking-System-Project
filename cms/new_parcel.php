<?php if (!isset($conn)) { include 'db_connect.php'; } ?>

<style>
    textarea {
        resize: none;
    }
</style>

<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-parcel" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class=""></div>
        <div class="row">
        <div class="col-md-6" id=""  <?php echo isset($type) && $type == 1 ? 'style="display: none"' : '' ?>>
            <?php if($_SESSION['login_branch_id'] <= 0): ?>
              <div class="form-group" id="fbi-field">
                <label for="" class="control-label">Sender</label>
              <select name="from_branch_id" id="from_branch_id" class="form-control select2" required="">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($from_branch_id) && $from_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <?php else: ?>
              <input type="hidden" name="from_branch_id" value="<?php echo $_SESSION['login_branch_id'] ?>">
            <?php endif; ?>  

            <div class="form-group" id="tbi-field">
              <label for="" class="control-label">Recipient</label>
              <select name="to_branch_id" id="to_branch_id" class="form-control select2">
                <option value=""></option>
                <?php 
                  $branches = $conn->query("SELECT *,concat(street) as address FROM branches");
                    while($row = $branches->fetch_assoc()):
                ?>
                  <option value="<?php echo $row['id'] ?>" <?php echo isset($to_branch_id) && $to_branch_id == $row['id'] ? "selected":'' ?>><?php echo $row['branch_code']. ' | '.(ucwords($row['address'])) ?></option>
                <?php endwhile; ?>
              </select>
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
                <label for="" class="control-label">Package Details</label>
                <input type="text" name="description" id="" class="form-control form-control-sm" value="<?php echo isset($description) ? $description : '' ?>" required>
              </div>
              <div class="form-group">
                <label for="" class="control-label">Current Location</label>
                <input type="text" name="sender_address" id="" class="form-control form-control-sm" value="<?php echo isset($sender_address) ? $sender_address : '' ?>" required>
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
                <!-- Add image upload input -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="parcel_image" class="control-label">Parcel Image</label>
                        <input type="file" name="parcel_image" id="parcel_image" class="form-control-file">
                    </div>
                </div>

                 <!-- Newly added image column -->
                 <div class="col-md-6">
                        <div class="form-group">
                            <label for="parcel_image_preview" class="control-label"></label></br>
                            <img id="parcel_image_preview" src="#" alt="Preview" style="max-width: 40%;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                    <div class="col-md-6">
            <div class="form-group">
              <label for="dtype">Condition</label>
              <input type="checkbox" name="type" id="dtype" <?php echo isset($type) && $type == 1 ? 'checked' : '' ?> data-bootstrap-switch data-toggle="toggle" data-on="Damage" data-off="Good" class="switch-toggle status_chk" data-size="xs" data-offstyle="info" data-width="5rem" value="1">
              <small>Damaged = Damaged on arrival</small>
              <small>Good = Package in good condition</small>
            </div>
     
                    </div>

                                  </div>

                <!-- ... Existing form fields ... -->

                <div class="col-lg-12">
                    <div class="card-footer border-top border-info">
                        <div class="d-flex w-100 justify-content-center align-items-center">
                            <button class="btn btn-flat bg-gradient-primary mx-2" form="manage-parcel">Save</button>
                            <a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=parcel_list">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
 $('#dtype').change(function(){
      if($(this).prop('checked') == true){
        $('#tbi-field').hide()
      }else{
        $('#tbi-field').show()
      }
  })
    $('[name="price[]"]').keyup(function(){
      calc()
    })
  $('#new_parcel').click(function(){
    var tr = $('#ptr_clone tr').clone()
    $('#parcel-items tbody').append(tr)
    $('[name="price[]"]').keyup(function(){
      calc()
    })
    $('.number').on('input keyup keypress',function(){
        var val = $(this).val()
        val = val.replace(/[^0-9]/, '');
        val = val.replace(/,/g, '');
        val = val > 0 ? parseFloat(val).toLocaleString("en-US") : 0;
        $(this).val(val)
    })

  })
	$('#manage-parcel').submit(function(e){
		e.preventDefault()
		start_load()
    if($('#parcel-items tbody tr').length <= 0){
      alert_toast("Please add atleast 1 parcel information.","error")
      end_load()
      return false;
    }
		$.ajax({
			url:'ajax.php?action=save_parcel',
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
              location.href = 'index.php?page=parcel_list';
            },2000)

        }
			}
		})
	})

    // Preview uploaded image
    $("#parcel_image").change(function () {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#parcel_image_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
