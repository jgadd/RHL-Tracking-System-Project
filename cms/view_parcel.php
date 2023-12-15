<?php

include 'db_connect.php';
require_once('assets/barcode/vendor/autoload.php');

//.. (existing code)
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
function generateBarcode($text)
{
	$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
	return $generator->getBarcode($text, $generator::TYPE_CODE_128);
}

//.. (existing code)
if($to_branch_id > 0 || $from_branch_id > 0){
	$to_branch_id = $to_branch_id  > 0 ? $to_branch_id  : '-1';
	$from_branch_id = $from_branch_id  > 0 ? $from_branch_id  : '-1';
$branch = array();
 $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches where id in ($to_branch_id,$from_branch_id)");
    while($row = $branches->fetch_assoc()):
    	$branch[$row['id']] = $row['address'];
	endwhile;
}
?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					
					<dl>
						<dt>Tracking Number:</dt>
						<dd> <h4><b><?php echo $reference_number ?></b></h4></dd>
						
						<!-- Generate and display the barcode -->
						<dt>COURIER:</dt>
						<dd><?php echo $sender_name ?></dd>
					</dl>
				</div>
			</div>
		</div>
<div class="row">
		
	<div class="callout callout-info" id="print_content">

	<!-- Barcode Section -->
<style>.center-text{
			text-align:center;
		}
		.left-text{
			text-align:left;
		}
			</style>
<div class="center-text">
<dl>
	
	<dd><img src="data:image/png;base64,<?php echo base64_encode(generateBarcode($reference_number)); ?>" alt="Barcode">
		<h6><?php echo $sender_name ?></h6>
	</dd>
</dl>
</div>
<hr>
<div class="left-text">
	<dl>
		<dt>To:</br></dt>
		<dd><?php echo $recipient_name ?></dd>
	</dl>
</div>
<!-- Package Details Section -->
<b class="border-bottom border-primary">Package Details</b>
<dl>
	<dt>Description:</dt>
	<dd><?php echo $description ?></dd>
</dl>

<!-- Package Dimensions Section -->
<style>

</style>
<div class="row">
	<div class="col-sm-6">
		<dl>
			<dt>Weight:</dt>
			<dd><?php echo $weight ?></dd>
			
		</dl>
	</div>
	<div class="col-sm-6">
		<dl>
			<dt>Quantity:</dt>
			<dd><?php echo $width ?></dd>	
		</dl>
	</div>
</div>

</div>

				
				<div class="callout callout-info">	
				<dl>
						<dt>Price:</dt>
						<dd><?php echo number_format($price,2) ?></dd>
						</dl>	
							
				
								<dl>
					<dt>Type:</dt>
					<dd><?php echo $type == 1 ? "<span class='badge badge-primary'>Deliver to Recipient</span>":"<span class='badge badge-info'>Recieve Package</span>" ?></dd>
					</dl>	
				
				<dl>
						<dd><?php echo number_format($price,2) ?></dd>
						<dt>Branch Accepted the Parcel:</dt>
						<dd><?php echo ucwords($branch[$from_branch_id]) ?></dd>
						<?php if($type == 2): ?>
							<dt>Nearest Branch to Recipient for Pickup:</dt>
							<dd><?php echo ucwords($branch[$to_branch_id]) ?></dd>
						<?php endif; ?>
						</div>
					<div class="callout callout-info">
					<b class="border-bottom border-primary">Sender Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($sender_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($sender_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($sender_contact) ?></dd>
					</dl>
						
						
					<b class="border-bottom border-primary">Recipient Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($recipient_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($recipient_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($recipient_contact) ?></dd>
						</dl>
						</div>
				<div class="callout callout-info">
				<dt>Status:</dt>
						<dd>
							<?php 
							switch ($status) {
								case '1':
									echo "<span class='badge badge-pill badge-info'> Collected</span>";
									break;
								case '2':
									echo "<span class='badge badge-pill badge-info'> Shipped</span>";
									break;
								case '3':
									echo "<span class='badge badge-pill badge-primary'> In-Transit</span>";
									break;
								case '4':
									echo "<span class='badge badge-pill badge-primary'> Arrived at Destination</span>";
									break;
								case '5':
									echo "<span class='badge badge-pill badge-primary'> Out for Delivery</span>";
									break;
								case '6':
									echo "<span class='badge badge-pill badge-primary'> Ready to pickup</span>";
									break;
								case '7':
									echo "<span class='badge badge-pill badge-success'> Delivered</span>";
									break;
								case '8':
									echo "<span class='badge badge-pill badge-success'> Picked-up</span>";
									break;
								case '9':
									echo "<span class='badge badge-pill badge-danger'> Unsuccessfull Delivery Attempt</span>";
								break;
								
								default:
									echo "<span class='badge badge-pill badge-info'> Item Accepted by Courier</span>";
									
									break;
							}

							?>
							<span class="btn badge badge-primary bg-gradient-primary" id='update_status'><i class="fa fa-edit"></i> Update Status</span>
						
					</dl>
					
					</div>
				</div>
						</div>
		
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
		<button type="button" class="btn btn-primary" id="print_button">Print</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>

<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
	</style>
	<h3 class="text-center"><b>Student Result</b></h3>
</noscript>
<script>
	$('#update_status').click(function(){
		uni_modal("Update Status of: <?php echo $reference_number ?>","manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>","")
	})
</script>
<script>
// Function to print Barcode and Package Details content
function printContent() {
    var printWindow = window.open('', '_blank');
    var contentToPrint = document.getElementById('print_content').innerHTML;
    
	printWindow.document.open();
    printWindow.document.write('<html><head><style>title {text-align:justify #printed-content}</style><title>RHL PackageTracking</title><style>body { text-align: left;} #printed-content { border: 1px solid #000; padding: 20px; display: inline-block; }</style></head><body><div id="printed-content">' + contentToPrint + '</div></body></html>');
    printWindow.document.close();
    printWindow.print();
}

// Attach click event to the print button
document.getElementById('print_button').addEventListener('click', function () {
    printContent();
});
</script>
