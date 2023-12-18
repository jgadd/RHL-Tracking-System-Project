<?php if(!isset($conn)){ include 'db_connect.php'; } ?>
<style>
  textarea{
    resize: none;
  }
</style>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<form action="" id="manage-checkpoint">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
          <div class="col-md-12">
            <div id="msg" class=""></div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Checkpoint</label>
                <textarea name="checkpoint" id="" cols="30" rows="2" class="form-control"><?php echo isset($checkpoint) ? $checkpoint : '' ?></textarea>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">LLG</label>
                <textarea name="llg" id="" cols="30" rows="2" class="form-control"><?php echo isset($llg) ? $llg : '' ?></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">District</label>
                <textarea name="district" id="" cols="30" rows="2" class="form-control"><?php echo isset($district) ? $district : '' ?></textarea>
              </div>
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Province</label>
                <textarea name="province" id="" cols="30" rows="2" class="form-control"><?php echo isset($province) ? $province : '' ?></textarea>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-6 form-group ">
                <label for="" class="control-label">Country</label>
                <textarea name="country" id="" cols="30" rows="2" class="form-control"><?php echo isset($country) ? $country : '' ?></textarea>
              </div>
            </div>

          </div>
        </div>
      </form>
  	</div>
  	<div class="card-footer border-top border-info">
  		<div class="d-flex w-100 justify-content-center align-items-center">
  			<button class="btn btn-flat  bg-gradient-primary mx-2" form="manage-checkpoint">Save</button>
  			<a class="btn btn-flat bg-gradient-secondary mx-2" href="./index.php?page=checkpoint_list">Cancel</a>
  		</div>
  	</div>
	</div>
</div>
<script>
	$('#manage-checkpoint').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_checkpoint',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp == 1){
					alert_toast('Data successfully saved',"success");
					setTimeout(function(){
              location.href = 'index.php?page=checkpoint_list'
					},2000)
				}
			}
		})
	})
  function displayImgCover(input,_this) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#cover').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }
</script>