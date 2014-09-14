$(function(){

    arr = new Array();

    $.getJSON("json/Bo_php.json", function( json ) {
      $(json).each(function(){
        arr.push(this);
      })
    });

    $("#conferma").click(function(){

      var ind = $("#indirizzoinput").val();

      $(".debuglog").append(""+arr.length+" records <br />");
      
      //js calculate
      //calc(ind);

      //php calculate
      call_leven(ind);


      //1111111111111111



      //1111111111111111

    });

    $(".debuglog").hide();
    $("#debug").click(function(){
        if (!$(this).hasClass("debugging")) {
          $(this).addClass("debugging");
          $(this).text("STOP debug");
          $(".debuglog").show();
          
        }else{
          $(".debuglog").hide();
          $(this).text("debug");
          $(this).removeClass("debugging");
        }
    })

});

function calc(ind){
var resArr = new Array("word",1000);
    var start = new Date().getTime();
   $(arr).each(function(){
     var dis = lev(ind.toUpperCase(),this.toUpperCase());
     //var dis = lev(ind,this);
     if (dis < resArr[1]) {
       resArr[0] = this;
       resArr[1] = dis;
     };
  })
var end = new Date().getTime();
var time = end - start;
$(".debuglog").append("<div>"+ind+" <span class='glyphicon glyphicon-arrow-right'></span> "+resArr[0]+" (Dist: "+resArr[1]+" Time:"+time+" ms )</div>");


}

  function call_leven(q)
  {
    $.ajax({
      type: 'get',
      url:  'php/levenshtein.php',
      contentType: 'application/x-www-form-urlencoded',
      data:{
        query:q
      },
      success: function(rip) {
      var arr = jQuery.parseJSON(rip);
      var addr = arr.addr;
      var time = arr.time;
      var dist = arr.dist;
      var geocode = arr.geocode;
      var url = arr.addrurl;
      //alert(arr.addr)
      $(".debuglog").append("<div>geo: "+geocode+" ; "+q+" <span class='glyphicon glyphicon-arrow-right'></span> "+addr+" (Dist: "+dist+" Time:"+time+" ms)</div>");
      $(".debuglog").append("<div>"+url+"</div><br/>");
      //alert(rip)
      refreshMap(geocode);
    },
    error: function(request, status, error){
      alert("err"+error);
    }
  });
  }

function lev(s1, s2) {
  if (s1 == s2) {
    return 0;
  }

  var s1_len = s1.length;
  var s2_len = s2.length;
  if (s1_len === 0) {
    return s2_len;
  }
  if (s2_len === 0) {
    return s1_len;
  }


  s1 = s1.split('');
  s2 = s2.split('');
  
  var v0 = new Array(s1_len + 1);
  var v1 = new Array(s1_len + 1);

  var s1_idx = 0,
  s2_idx = 0,
  cost = 0;
  for (s1_idx = 0; s1_idx < s1_len + 1; s1_idx++) {
    v0[s1_idx] = s1_idx;
  }
  var char_s1 = '',
  char_s2 = '';
  for (s2_idx = 1; s2_idx <= s2_len; s2_idx++) {
    v1[0] = s2_idx;
    char_s2 = s2[s2_idx - 1];

    for (s1_idx = 0; s1_idx < s1_len; s1_idx++) {
      char_s1 = s1[s1_idx];
      cost = (char_s1 == char_s2) ? 0 : 1;
      var m_min = v0[s1_idx + 1] + 1;
      var b = v1[s1_idx] + 1;
      var c = v0[s1_idx] + cost;
      if (b < m_min) {
        m_min = b;
      }
      if (c < m_min) {
        m_min = c;
      }
      v1[s1_idx + 1] = m_min;
    }
    var v_tmp = v0;
    v0 = v1;
    v1 = v_tmp;
  }
  return v0[s1_len];
}

function refreshMap(geocode){
    var splitted = geocode.split(",");
    map.addLayer(new OpenLayers.Layer.OSM());

    var lonLat = new OpenLayers.LonLat(parseFloat(splitted[1]),parseFloat(splitted[0]))
          .transform(
            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
            map.getProjectionObject() // to Spherical Mercator Projection
          );
          
    var zoom=16;

    var markers = new OpenLayers.Layer.Markers( "Markers" );

    map.addLayer(markers);
    
    markers.addMarker(new OpenLayers.Marker(lonLat));
    
    map.setCenter (lonLat, zoom);
}