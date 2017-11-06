<script>

	$("a[href='<?=base_url()?>index.php/payments']:first").find('.lm_box').attr("class", "lm_box_selected");

	$("#title_1").text("<?=$breadcrumb?>");

</script>


  <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">


<script>
  $(function() {
    
    $( "#fromDate2" ).datepicker();
    $( "#toDate2" ).datepicker();
  });
  </script>

<div class="content_main">

	<ul class="nav nav-tabs nav-justified" data-tabs="tabs">

		<li class="active"><a href="#view" data-toggle="tab">View</a></li>

		

	</ul>

	<div class="tab-content" style="padding-top: 20px;">

		<div id="view" class="tab-pane active">

			<table class="table table-striped datatable">

				<thead>

					<tr>

						<td>Emri</td>

						<td>Hyrjet</td>

						<td>Prej</td>

						<td>Deri</td>

						
						<td>Paguar</td>

						<td>Data e Pageses</td>
						
						

					</tr>

				</thead>

				<tbody>

				<?php

				foreach ( $paymentHistory as $payments ) {

					echo "<tr>			
										<td>{$payments->clientName}</td>

										<td>{$payments->entryName}</td>

									 	<td>". date("j F, Y", strtotime($payments->fromDate)) ."</td>

										<td>". date("j F, Y", strtotime($payments->toDate)) ."</td>

										

										<td>{$payments->paguar}</td>

										<td>". date("j F, Y", strtotime($payments->date)) ."</td>


										

	                  </td>

									</tr>";

				}

				?>				

			</tbody>

			</table>

		</div>

        </div>

       

        
              

			
					

				</div>

			</form>

		</div>

	</div>

</div>

<script type="text/javascript">

	$(document).ready(function () {

  	$('#tabs').tab();

		$('#cancel').click(function(event) {

		  event.preventDefault();

		  $('#add').find('input, select, textarea').val("");

		  $('#add').find('id').val("-1");

		  $('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/insert");

		});

  	$('.edit-data').click(function() {

    	$.post('<?=base_url()?>index.php/buildings/ajax/' + this.id, function(data){

      	$('a[href=#add]:first').attr('data-toggle', 'tab');

      	$('a[href=#add]').tab('show');

      	$('#add').find('form').first().attr('action', "<?=base_url()?>index.php/buildings/edit");

      	$.each(data, function(key, value) {

        	$('#add').find('input[name='+key+'], select[name='+key+'], textarea[name='+key+']').val(value);

        });      	

    	}, 'json');

    });

 	 	$('#add').find('form').first().validate({

			rules: {

		    name: {required: true, minlength:3}

		  }

		});    

  });

</script>