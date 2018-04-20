
                       <form class="parking_formGeo">
                       <table class="table table-responsive table-striped " style="width:100%;">
                           <input type="hidden" value="<?php echo $this->session->userdata('user_id');?>" name="user_id">
                               <tr>
                                    <td style="width:35%;text-align:left;">Parking Name : </td> 
                                    <td style="width:65%;"> <input type="text" value="" id="parking_name" name="parking_name"  placeholder="Parking Name"></td>
                               </tr>
                               <tr>
                                    <td style="width:35%;text-align:left;">Parking Address : </td> 
                                    <td style="width:65%;"> <input type="text" value="" id="parking_address" name="parking_adress"  placeholder="Parking Address"></td>
                               </tr>
                               <tr><td id="info"></td></tr>
                               <tr>
                                    <td colspan="2" style="text-align:right;"><input type="button" style="width: 10%;" class="btn btn-info gt-btnMap" value="GO"/></td>
                               </tr>
                               
                                
                           </table>
                         </form>
                    
                        
                  
                       <div id="map_canvas"></div>
                   
<style>
#map_canvas {
  height: 100%;
  width: 100%;
      position: absolute !important;
    overflow: hidden;
    width: 650px;
    height: 450px;
}
 
  </style>

 <script>
    $(document.body).on('click','.gt-btnMap',function(){
      var address=$("#parking_address").val();
      var name=$("#parking_name").val();
      if(name=="") { $("#parking_name").focus(); return false; }
      else if(address==""){ $("#parking_address").focus(); return false; }
      else 
	   initialize(address);
    });
	

	</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDh78oxVTMDLvmE9C3-R1LeA6QZaLgQqHg&libraries=drawing&sensor=false"></script>

    <script type="text/javascript">
  var geocoder;
  var map;
  var polygonArray = [];
  //var address ="";
  function initialize(address) {
     // alert(address);
    var address=document.getElementById("parking_address").value;
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(40.7590403,-74.0392714);
    var myOptions = {
      zoom: 8,
      center: latlng,
        mapTypeControl: true,
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
        navigationControl: true,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    if (geocoder) {
      geocoder.geocode( { 'address': address}, function(results, status) {
        
        if (status == google.maps.GeocoderStatus.OK) {
          if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
              
          map.setCenter(results[0].geometry.location);

            var infowindow = new google.maps.InfoWindow(
                { content: '<b>'+address+'</b>',
                  size: new google.maps.Size(150,50)
                });

            var marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map, 
                title:address
            }); 
            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
                 
            });

var drawingManager = new google.maps.drawing.DrawingManager({
          drawingMode: google.maps.drawing.OverlayType.POLYGON,
          drawingControl: true,
          drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle']
          },
           //markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
          circleOptions: {
            fillColor: '#FF0000',
            fillOpacity: 1,
            strokeWeight: 5,
            clickable: false,
            editable: true,
            zIndex: 1
          }
         
        });
        drawingManager.setMap(map);
        // Start Getting Cordinates
        google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
        //document.getElementById('info').innerHTML += "polygon points:" + "<br>";
        for (var i = 0; i < polygon.getPath().getLength(); i++) {
            var inpval='<input type="text" name="cordinates" value="'+polygon.getPath().getAt(i).toUrlValue(6)+'"/>'
          //document.getElementById('info').innerHTML += polygon.getPath().getAt(i).toUrlValue(6) + "";
          document.getElementById('info').innerHTML +=inpval;
        }
        polygonArray.push(polygon);
        });
        //End Getting Cordinates
          } else {
            alert("No results found");
          }
        } else {
          alert("Geocode was not successful for the following reason: " + status);
        }
      });
    }
  }
</script>
