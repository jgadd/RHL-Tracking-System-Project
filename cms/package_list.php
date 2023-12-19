<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_parcel"><i class="fa fa-plus"></i> Add New</a>
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
						<th>Tracking Number</th>
						<th>Sender</th>
						<th>Reciever</th>
						<th>Status</th>
                        <th>Current Location</th>
                        <th>Condition</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$where = "";
					if(isset($_GET['s'])){
						$where = " where status = {$_GET['s']} ";
					}
					if($_SESSION['login_type'] != 1 ){
						if(empty($where))
							$where = " where ";
						else
							$where .= " and ";
						$where .= " (from_branch_id = {$_SESSION['login_branch_id']} or to_branch_id = {$_SESSION['login_branch_id']}) ";
					}
					$qry = $conn->query("SELECT * from package $where order by  unix_timestamp(date_created) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><b><?php echo ($row['tracking_number']) ?></b></td>
						<td><b><?php echo ucwords($row['sender']) ?></b></td>
						<td><b><?php echo ucwords($row['recipient']) ?></b></td>
						<td><b><?php echo ucwords($row['status']) ?></b></td>
                        <td><b><?php echo ucwords($row['location']) ?></b></td>
                        <td>
                        <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'damage' checkbox is checked
    $damage = isset($_POST['damage']) && in_array(1, $_POST['damage']) ? 'Damaged' : 'Good';

    // Display the result in a table
   
    echo '<tr><td>' . $damage . '</td></tr>';
   
}
?>

						<td class="text-center">
		                    <div class="btn-group">
		                    	<button type="button" class="btn btn-info btn-flat view_package" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-eye"></i>
		                        </button>
		                        <a href="index.php?page=edit_package&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_package" data-id="<?php echo $row['id'] ?>">
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
		$('.view_package').click(function(){
			uni_modal("Packages's Details","view_package.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_package').click(function(){
	_conf("Are you sure to delete this package?","delete_package",[$(this).attr('data-id')])
	})
	})
	function delete_package($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_package',
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