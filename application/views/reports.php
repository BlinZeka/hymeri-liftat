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
<style type="text/css">
#maujtPagesat{
		border:1px #BFBFBF solid; height:80px;width:68px;background-color:#E7E8E3;margin-left: 2px;padding:3px; 
}
</style>

<br/>

<div class="content_main">
	<div  id = "contentReport"></div>
	<ul class="nav nav-tabs nav-justified tabsPayment" data-tabs="tabs">

		<li class="active"><a href="#view" data-toggle="tab">Payments</a></li>
		<li><a href="#pendingPayements" data-toggle="tab">Pending</a></li>

	</ul>
	<div class="tab-content" style="padding-top: 20px;">
		<div id="view" class="tab-pane active">
			 <form action="" method="POST" style="width: 950px;">

              <div class="form-group filteringForm" style="height: 70px; width: 1000px;">
          
		<div class="form-group" style=" width: 230px; float: left;">

			<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >Company Name:</label>

			<div class="col-sm-10">

				<select name="company_id" id = "companies" onChange ="return getBuildings(this.value)" class="selection" style="width: 210px;">
					<OPTION value = "-1">Te gjitha</OPTION>
					<?php

						foreach ($companies as $company) {

							echo '<option value="'.$company['id'].'">'.$company['name'].'</option>';

						} 

					?>

				</select>					
				
			</div>

		</div>

		

		
		<div class="form-group" style=" width: 230px; float: left;">

			<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >Buildings:</label>

			<div class="col-sm-10">

				<select name="building_id" id = "buildings"  onChange ="return getEntries(this.value)" class="selection" style="width:210px;">
					
					

				</select>					
				
			</div>

		</div>
		

		<div class="form-group" style=" width: 230px; float: left;">

			<label class="col-sm-2 control-label" style=" width: 110px; margin: 3px 10px;" >Entries:</label>

			<div class="col-sm-10">

				<select name="entry_id" id = "entries"  class="selection" style="width: 210px;">
					
					

				</select>					
				
			</div>

		</div>


		<div class="form-group" style=" width: 230px;">

		          <label class="col-sm-2 control-label" style=" width: 60px; margin: 3px 10px;">Prej</label>

		          <div class="col-sm-10">

		            <input type="text" id="dateFrom" name="date" class="form-control"  style="width: 90px;">

		          </div>

		</div>

	

		<div class="form-group" style=" width: 230px; float: left; margin: -26px -86px;">

		          <label class="col-sm-2 control-label"style=" width: 60px; margin: 3px 10px;">Deri</label>

		          <div class="col-sm-10">

		            <input type="text" id="dateTo" name="date" class="form-control"  style="width: 90px;">

		          </div>
		
      		 </div>

      	

				<select id="valute" class="form-control" style="height:35px;width:80px;position:absolute; float: left; margin: 100px 286px;">
						<option value="1">EUR</option>
						<option value="2">LEK</option>
				</select>
		
      		
		

		 <div class="butonat" style="width: 430px; float: right;">
			<!-- <div class="col-sm-10" style="width: 130px; margin: 1px -39px; margin: 0px -231px;">
				<input type= "button"  onClick = "return clientsNotPaymentsByMonth();" value = "Pending Payments" class="btn btn-danger">			
			</div> -->

			<div class="form-group" style="float:left; margin: -137px 125px; margin: 0px -220px;" >
				<input type= "button"  onClick = "return totali();" value = "Payments" class="btn btn-primary" style=" width: 90px;margin: 0px 27px;">
			</div>

			
			
			<div class="form-group" style=" margin: 0 305px 90px;float:right;font-size:15px;background-color: grey;border-radius: 3px;height: 29px;width: 209px;text-align: center;padding-top: 5px; color: #fff;" >
				<label>Total: </label> <label id = "totali"> 0.00 €</label>
			</div>
		</div>
	</div>

	</form>

	  <div class="butonat" style="width: 430px; float: right; margin-top:30px;">
		<!-- <div class="col-sm-10" style="width: 130px; margin: 1px -39px; margin: 0px -231px;">
			<input type= "button"  onClick = "return clientsNotPaymentsByMonth();" value = "Pending Payments" class="btn btn-danger">			
		</div> -->

		<div style="margin-left:100px;">

			<div class="form-group" style=" margin: -137px 125px; margin: 0px -220px;" >
				<select style="height:34px;" id ="yearReport">
					<?php for ($i=4; $i < 9 ; $i++) { 
						echo '<option value=201'.$i.'>201'.$i.'</option>';
					}?>
					
				</select>
			</div>

			<div class="form-group" style="float:left; margin: -137px 125px; margin: 0px -220px;" >
				<input type= "button"  onClick = "return raportByYear();" value = "Show by Years" class="btn btn-primary" style=" width: 120px;margin: -33px 81px;"> <button class="btn btn-danger" id="printReport" style = "margin-left:220px;margin-top:-33px">Print </button>
			</div>

			<div class="form-group" style="float:left; margin: -337px 125px; margin: 0px -220px;" >
				<label id = "waiting"></label>

			</div>

			
			

		</div>
		
	</div>

	

	<div class="tab-content" style="display:none;width:1060px;" id ="clients_report_by_year">
		
	</div>

	<div class="tab-content" style="width:960px;padding-top: 180px;" id ="clients_report_holder">

		<div id="view" class="tab-pane active">

			<table class="table table-striped" id="clients_report">

				<thead>

					<tr>

						<td>Company</td>

						<td>Building</td>

						<td>Entry</td>

						<td>Flat Nr</td>

						<td>Name</td>

						<td>Data e pageses</td>

						<td>Pagesa</td>

					</tr>

				</thead>
				

				
			</table>

		</div>
		</div>

		</div>

		<div id="pendingPayements" class="tab-pane">
			<div class="tab-content" style="width:960px;padding-top: 10px;">
			<table class="table table-striped pending">

				<thead>

					<tr>

						<td>Emri</td>

						<td>Company</td>

						<td>Building</td>

						<td>Entry</td>

						<td>Telephone</td>

						<td>From</td>

						<td>To</td>

						<td>Flat Name</td>

						<td>Flat No</td>
						

					</tr>

				</thead>

				<tbody>

					<?php
					
					foreach ( $allPendingPayments as $pending ) {

						echo "<tr style='color:red'>			
						<td ><a style='color:red' href='".base_url()."index.php/cards/index/".$pending->client_id."' style='color:#2C567E; text-decoration: underline;'>{$pending->first_name} {$pending->last_name}</a></td>

						<td>{$pending->company}</td>

						<td>{$pending->building}</td>

						<td>{$pending->entryName}</td>

						<td>{$pending->phone}</td>

						<td>". date("j F, Y", strtotime($pending->fromDate)) ."</td>

						<td>". date("j F, Y", strtotime($pending->toDate)) ."</td>

						<td>{$pending->flatName}</td>

						<td>{$pending->flatNo}</td>




						</td>

						</tr>";

					}

					?>				

				</tbody>

			</div>
		</div>

	</div>



	


		

</div>



<script type="text/javascript">
	
	var clientArrayReport = null;
	
	function raportByYear(){
		
		$('#clients_report_holder').hide('slow/200/fast', function() {
			
		});

		$('#clients_report_by_year').show('slow/200/fast', function() {
			
		});

		
		
		 $.ajax({
		                       type: "POST",
		                       async:false,
		                       url: "<?=base_url()?>index.php/reports/getClientPaymentReport",
		                       data: {building_id: $('#buildings').val(), entry_id:$('#entries').val() },
		                       success: function(result){
	  			 	clientArrayReport = JSON.parse(result);
	  			 	console.log(clientArrayReport);
	  			
		                       }
		 });

		 var muajt = [];
		 var paymentDate = [];

		 for (var i = 1; i <=12; i++) {
			paymentDate.push(i,"");
			muajt.push(i,"");
		 };
		
		  $('#clients_report_by_year').empty();
		
		 $.each(clientArrayReport, function(counter, val) {
		 	// console.log(val['id']);
		 	 var muajt = [];
			 var paymentDate = [];
		 	 $.ajax({
		                       type: "POST",
		                  
		                       url: "<?=base_url()?>index.php/reports/getReportPaymentByYear/"+val['id']+"/"+$('#yearReport').val()+"",
		                       data: {building_id: $('#buildings').val(), entry_id:$('#entries').val() },
		                        beforeSend: function ( xhr ) {    
			                       $('#waiting').text('Loading...');
			                },
		                       success: function(result){
	  	  		 	arr = JSON.parse(result);
	  	  		 	// console.log(arr);
					var valuta='';
	  	  		 	$.each(arr, function(index, val) {
	  	  		 		if(val['valute'] == 1){
	  	  		 			valuta = 'EUR';
	  	  		 		}else{
	  	  		 			valuta = 'LEK';
	  	  		 		}
	  	  		 		muajt[val['month']] = val['paid'] + ' ' + valuta;
	  	  		 		paymentDate[val['month']] = val['date'];
	  	  		 	});

	  	  		 	 console.log(muajt);
		 			 console.log(paymentDate);
		 			 var month = new Array();
					month[1] = "January";
					month[2] = "February";
					month[3] = "March";
					month[4] = "April";
					month[5] = "May";
					month[6] = "June";
					month[7] = "July";
					month[8] = "August";
					month[9] = "September";
					month[10] = "October";
					month[11] = "November";
					month[12] = "December";

					var flag = true;
		 			 $('#clients_report_by_year').append('<table><tr>');
		 			 for ( i=1; i <= 12 ; i++ ) { 
		 			 	if(flag){
		 			 		$('#clients_report_by_year').append('<td><div id = "maujtPagesat" style = "background-color:white;width:90px"><strong>'+clientArrayReport[counter].first_name+' '+clientArrayReport[counter].last_name+'</br></strong>Flat No: <strong><strong>'+clientArrayReport[counter].flatNumber+' </strong><div></td>');
		 			 	}
		 			 	flag = false;
		 			 	if (muajt[i] != null ) {
		 			 		$('#clients_report_by_year').append('<td><div id = "maujtPagesat">'+month[i]+'<br/><br/><strong>'+muajt[i]+'</strong><br/><label style = "font-size:11px" >'+paymentDate[i]+'</label><br/></div></td>')	
		 			 	} else{
		 			 		$('#clients_report_by_year').append('<td><div id = "maujtPagesat" style = "background-color:white;">'+month[i]+'<br/><br/><br/></div></td>')		
		 			 	};					
					}
					$('#clients_report_by_year').append('</tr></table>');
					$('#waiting').text('');
		                       }
			 });
		 });
		

		

	}
	function totali(company_id,building_id,entry_id){
		
		$('#clients_report_by_year').hide('slow/200/fast', function() {
			
		});


		$('#clients_report_holder').show('slow/200/fast', function() {
			
		});



		$.ajax({
		    type: 'POST',
		    url: "<?=base_url()?>index.php/reports/getAllClientsEntry/"+ $('#companies').val() +"/"+ $('#buildings').val() +"/"+ $('#entries').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"/"+ $('#valute').val() +"",
		    data: '&m=swapTicketList',
		    dataType: "json",
		    success: function(resultData) {
		        $('#clients_report').dataTable({
		            "aaData":  resultData,
		            aoColumns: [ { mData: 'companyName' },{ mData: 'buildingName' },{ mData: 'hyrja' },{ mData: 'flatNumber' },{ mData: 'clientName' },{ mData: 'pagesaDate' },{ mData: 'pagesa' } ],
		            "bDestroy": true,
		          	"aaSorting": [[ 5 , 'desc']],
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



		 $.ajax({
		                       type: "POST",
		                       url: "<?=base_url()?>index.php/reports/getTotalbyEntryId/"+ $('#companies').val() +"/"+ $('#buildings').val() +"/"+ $('#entries').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"/"+ $('#valute').val() +"",
		                       success: function(result){
	  			var arr = JSON.parse(result);
		                       	 $.each(arr, function(i, value) {  
		                       	 if (value.totali != null) {$('#totali').html(value.totali + "");} else{$('#totali').html("0.00");};
				           
				  });
		                       }
		 });

		 //  $.ajax({
		 //                       type: "POST",
		 //                       url: "<?=base_url()?>index.php/reports/getAllClientsEntry/"+ $('#companies').val() +"/"+ $('#buildings').val() +"/"+ $('#entries').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +"",
		 //                       success: function(result){
		  // 			var arr = JSON.parse(result);
		  // 			 // $("#clients_report").find("tr:gt(0)").remove();
		 //                       	 $.each(arr, function(i, value) {  
			// 	            $('#clients_report').append('<tr><td>'+value.companyName+'</td><td>'+value.buildingName+'</td><td>'+value.hyrja+'</td><td>'+value.fName+'</td><td>'+value.clientName+' </td><td>'+value.pagesaDate+'</td><td>'+value.pagesa+'</td></tr>');
			// 	  });
		 //                       }
		 // });
		
		

	}

	

	function clientsNotPaymentsByMonth(){

		  $.ajax({
		                       type: "POST",
		                       url: "<?=base_url()?>index.php/reports/clientsNotPaymentsByMonth/"+ $('#companies').val() +"/"+ $('#buildings').val() +"/"+ $('#entries').val() +"/"+ $('#dateFrom').val() +"/"+ $('#dateTo').val() +" ",
		                       success: function(result){
	  			var arr = JSON.parse(result);
	  			 $("#clients_report").find("tr:gt(0)").remove();
		                       	 $.each(arr, function(i, value) {  
				            $('#clients_report ').append('<tr><td>'+value.number+'</td><td>'+value.first_name+' '+value.last_name+'</td><td>'+value.phone_1+'</td><td>'+value.email+'</td><td>/</td><td>/</td><td>/</td><td>0.00</td></tr>');
				  });
		                       }
		 });
	}

	function getBuildings(companyid){

			document.getElementById("buildings").innerHTML = "";

			 $.ajax({
		                       type: "GET",
		                       url: "<?=base_url()?>index.php/reports/getBuildingsByCompanyId/"+companyid+"",
		                       // data: "emp_Id =" + id,
		                       success: function(result){
	  			var arr = JSON.parse(result);
	  			 $('<option></option>', {text:"Te gjitha"}).attr('value', '-1').appendTo('#buildings');
		                       	 $.each(arr, function(i, value) {  
				           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#buildings');
				           // console.log(value);
				  });
		                       }
		                     });

	}

	function getEntries(buildingID){

			document.getElementById("entries").innerHTML = "";

			 $.ajax({
		                       type: "GET",
		                       url: "<?=base_url()?>index.php/reports/getEntriesByBuildingId/"+buildingID+"",
		                       // data: "emp_Id =" + id,
		                       success: function(result){
	  			var arr = JSON.parse(result);
	  			 $('<option></option>', {text:"Te gjitha"}).attr('value', '-1').appendTo('#entries');
		                       	 $.each(arr, function(i, value) {  
				           $('<option></option>', {text:value.name}).attr('value', value.id).appendTo('#entries');
				           // console.log(value);
				  });
		                       }
		                     });

	}

	$(document).ready(function() {

		$('#printReport').click(function(event) {
			$('.left_menu').hide();
			$('.header_back').hide();
			$('.butonat').hide();
			$('.filteringForm').hide();
			$('.tabsPayment').hide();
			$('#clients_report_by_year').css('margin-left', '-195px');
			window.print();
			$('#clients_report_by_year').css('margin-left', '0px');
			$('.tabsPayment').show();
			$('.filteringForm').show();
			$('.butonat').show();
			$('.left_menu').show();
			$('.header_back').show();
			$('.tab-content').show();
		});

		$("input[id=oneMonth]:radio").change(function () {
			
			$('#oneMonthOption').show();
			$('#periodicallyOption').hide();

		});

		$("input[id=periodically]:radio").change(function () {
			
			$('#periodicallyOption').show();
			$('#oneMonthOption').hide();
		});
	});

</script>
