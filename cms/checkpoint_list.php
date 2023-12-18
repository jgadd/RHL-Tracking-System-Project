<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_checkpoint"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Checkpoint Code</th>
						<th>Checkpoint</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM checkpoints order by llg asc,district asc, province asc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><b><?php echo $row['checkpoint_code'] ?></b></td>
                        <td><b><?php echo ucwords($row['checkpoint']) ?></b></td>
						<td><b><?php echo ucwords($row['llg'].', '.$row['district'].', '.$row['province'].', '.$row['country']) ?></b></td>
						<td class="text-center">
		                    <div class="btn-group">
		                        <a href="index.php?page=edit_checkpoint&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_checkpoint" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div>
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_checkpoint').click(function(){
			uni_modal("Checkpoint Details","view_checkpoint.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_checkpoint').click(function(){
	_conf("Are you sure to delete this carrier?","delete_carrier",[$(this).attr('data-id')])
	})
	})
	function delete_carrier($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_checkpoint',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>