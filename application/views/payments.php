<script>
$("a[href='<?=base_url()?>index.php/reports']:first").find('.lm_box').attr("class", "lm_box_selected");

$("#title_1").text("<?=$breadcrumb?>");
</script>

<script type="text/javascript">

$(function() {


	$( "#dateFrom" ).datepicker({
		dateFormat: 'yy-mm-dd'
	});
	$( "#dateTo" ).datepicker({
		dateFormat: 'yy-mm-dd'
	});

});

</script>


<br/>



<div class="content_main">

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

		<li class="active"><a href="#view" data-toggle="tab">Payments</a></li>
		<li><a href="#cards" data-toggle="tab">Cards </a></li>

	</ul>
	<form action="" method="POST" style="width: 950px;">

		<div class="form-group" style="height: 70px; width: 1000px;">

			<div class="form-group" style=" width: 230px; float: left;">

				<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >Employee:</label>

				<div class="col-sm-10">

					<select name="admin_id" id = "admin"   class="selection" style="width: 210px;">

						<?php

						foreach ($users as $admin) {

							echo '<option value="'.$admin['id'].'">'.$admin['first_name'].' ' . $admin['last_name'] .'</option>';

						} 

						?>

					</select>					

				</div>

			</div>



			<div class="form-group" style=" width: 200px;">

				<label class="col-sm-2 control-label" style=" width: 50px; margin: 3px 10px;"><?php echo lang('from'); ?></label>

				<div class="col-sm-10">

					<input type="text" id="dateFrom" name="date" class="form-control"  style="width: 74px;">

				</div>

			</div>



			<div class="form-group" style=" width: 100px; float: left; margin: -26px -86px;">

				<label class="col-sm-2 control-label"style=" width: 50px; margin: 3px 10px;"><?php echo lang('to');?></label>

				<div class="col-sm-10">

					<input type="text" id="dateTo" name="date" class="form-control"  style="width: 74px;">
					

				</div>
				
			</div>

			<div class="form-group" style=" width: 100px; float: left; margin: 46px -171px;">
				<select id="valute" class="form-control" style="height:30px;">
						<option value ="1">EUR</option>
						<option value ="2">LEK</option>
				</select>
			</div>	

			


			<div class="butonat" style="width: 430px; float: right;">
			<!-- <div class="col-sm-10" style="width: 130px; margin: 1px -39px; margin: 0px -231px;">
				<input type= "button"  onClick = "return clientsNotPaymentsByMonth();" value = "Pending Payments" class="btn btn-danger">			
			</div> -->

			<div class="form-group" style="float:left; margin: -137px 125px; margin: 0px -220px;" >
				<input type= "button"  onClick = "return checkActivities();" value = "Check" class="btn btn-primary" style="width: 90px;margin: 1px 0px 0px -100px;">
			</div>

			

		</div>
	</div>
</form>


<div id="showNote"  style = "display:none" title="Canceled Payment notes">
	<p id="showNoteContent"></p>
</div>

<div class="tab-content" style="width:960px;padding-top: 180px;">

	<div id="view" class="tab-pane active">
		<input type = "hidden" value = "" id="user">
		<input type = "hidden" value = "" id="totalPayment">
		<table class="table table-striped datatable"  id = "payment_report">

			<thead>

				<tr>


					<td><?php echo lang('building'); ?></td>
					<td><?php echo lang('entry'); ?></td>
					<td><?php echo lang('flat_nr'); ?></td>
					<td><?php echo lang('client'); ?></td>
					<td><?php echo lang('paid'); ?></td>
					<td><?php echo lang('from'); ?></td>
					<td width="100px"><?php echo lang('to'); ?></td>
					<td><?php echo lang('payment_date'); ?></td>
					<td>Status</td>

				</tr>

			</thead>



		</table>
		<br/></br>
		<div class="form-group" style="border-bottom:1px solid black;width:150px;" >
			<label>Total:</label>
			<label id="totali_payment">0.00 €</label>
		</div>


	</div>

	<div id="cards" class="tab-pane ">

		<table class="table table-striped datatable" id = "card_report" style = "width:960px;">

			<thead>

				<tr>
					<td><?php echo lang('client'); ?></td>

					<td><?php echo lang('card_nr'); ?></td>

					<td><?php echo lang('site_code'); ?></td>

					<td><?php echo lang('site_no'); ?></td>

					<td><?php echo lang('floors'); ?></td>

					<td><?php echo lang('create_date'); ?></td>

				</tr>

			</thead>



		</table>
	</div>
</div>

</div>








</div>



<script type="text/javascript">

$(document).ready(function() {
	$('#user').val("");
	var thisvalue = $(this).find("option:selected").text();
	$('#user').val($('#user').val() + thisvalue);

	$("select#admin").change(function(){

		$('#user').val("");
		var thisvalue = $(this).find("option:selected").text();
		$('#user').val($('#user').val() + thisvalue);
		            // console.log(thisvalue);
		            
		        });
});

function showNote(note){

	$(function() {
		$( "#showNoteContent" ).html(note);
		$( "#showNote" ).dialog();

	});

}

function checkActivities(){


		//Totali
		$.ajax({
			type: 'POST',
			url: "<?=base_url()?>index.php/payments/getPayementsByUser/"+ $('#admin').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"/"+ $('#valute').val() +"",
			data: '',
			dataType: "json",
			success: function(resultData) {
				var valuta = "<?php echo lang('value'); ?>";
				var total = 0;
				$.each(resultData,function(key, value){
					total = total + parseInt(value.paid);
				});
				$('#totalPayment').val(total + '.00 ' );
				$('#totali_payment').html(total + '.00 ' );
			}
		});

		
		//Payments
		$.ajax({
			type: 'POST',
			url: "<?=base_url()?>index.php/payments/getPayementsByUser/"+ $('#admin').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"/"+ $('#valute').val() +"",
			data: '',
			dataType: "json",
			success: function(resultData) {
				$('#payment_report').dataTable({
					"aaData":  resultData,
					aoColumns: [ { mData: 'building' }, { mData: 'entry' }, { mData: 'flat' }, { mData: 'name' },{ mData: 'paid' },{ mData: 'from' },{ mData: 'to' },{ mData: 'date' },

					{ mData: "status" ,
					"fnRender": function (oObj) {
						if(oObj.aData.status == 1){
							return "";
						}

						else{
							var note = oObj.aData.note;
			                	// console.log(oObj.aData.note);
			                	// return " <span style = 'margin-right:10px;color:#E60000;hover:pointer'>Canceled</span><a style='cursor:pointer' onClick = 'return showNote(\""+note+"\")'>(Click for details)</a>";
			                	return oObj.aData.note;       
			                }
			            }

			        },



			        ],
			        "bDestroy": true,

			        "sDom": 'T<"clear">lfrtip',
			        "oTableTools": {
					// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
					"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
					"aButtons": [

					"xls",
					{
						"sExtends": "pdf",
						"sPdfOrientation": "landscape",
						"sPdfMessage": "Payments Raport for: " + $('#user').val() + "          Total Payments: "+ $('#totalPayment').val()+" " , 
					},
					"print"
					]
				},
				"bDeferRender": true,

			});


}
});





		//Cards
		$.ajax({
			type: 'POST',
			url: "<?=base_url()?>index.php/payments/getCardsByUser/"+ $('#admin').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"",
			data: '',
			dataType: "json",
			success: function(resultData) {
				$('#card_report').dataTable({
					"aaData":  resultData,
					aoColumns: [ { mData: 'name' }, { mData: 'card_no' },{ mData: 'site_code' },{ mData: 'site_no' },{ mData: 'floors' },{ mData: 'date' }],
					"bDestroy": true,

					"sDom": 'T<"clear">lfrtip',
					"oTableTools": {
			// "sSwfPath": "http://datatables.net/release-datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
			"sSwfPath": "<?=base_url()?>assets/js/copy_csv_xls_pdf.swf",
			"aButtons": ["pdf","csv",
			{
				"sExtends": "collection",
				"sButtonText": "More",
				"aButtons": [
				{"sExtends": "copy", "bSelectedOnly": true},
				{"sExtends": "csv", "bSelectedOnly": true},
				{"sExtends": "xls", "bSelectedOnly": true},
				{"sExtends": "pdf", "bSelectedOnly": true},
				"print"
				]
			}
			]
		},
		"bDeferRender": true,


	});
			}
		});





}



</script>
