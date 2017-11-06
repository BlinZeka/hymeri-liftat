<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeWROIiOXy8RNXDAiy4le1COh-FE2aamQ"type="text/javascript"></script>

<div id="map-canvas" style="width: 100%; height: 100%; position: absolute;"></div>


<script>
	var map;
	var markers = [];
	function initialize() {
		console.log($(window).height());
	  var mapOptions = {
	    zoom: 10,
	    center: new google.maps.LatLng(42.40, 21.00)
	  };
	  
	  var canvas = document.getElementById('map-canvas');
	  canvas.style.height = ($(window).height() - 70) + "px";
	  map = new google.maps.Map(canvas, mapOptions);

		$.post("<?=base_url()?>index.php/main/map", function(data) {
			var iconBase = '<?=base_url()?>assets/images/';
			$.each(data, function(index, row){
				console.log("row: "+ row);
			  var infowindow = new google.maps.InfoWindow({
		      content: "<div style='width: 200px; height: 90px;'>"+row['name']+" - "+ row['zone'] +" <br/>  <br/><a href = 'http://213.163.123.246/lift_new/index.php/entries/index/"+row['id']+"' >View Entries</a></div>"
		  	});
			  var marker = new google.maps.Marker({
		      position: new google.maps.LatLng(row['lat'], row['lon']),
		      map: map,
		      title: row['name'],
		      icon: iconBase + 'elevator.png'
		  	});				
			  google.maps.event.addListener(marker, 'click', function() {
			    infowindow.open(map, marker);
			  });
			  markers.push(marker);				
			});		  
		}, 'json');
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
