$(function(){

    arr = new Array();

    $.getJSON("json/Bo_php.json", function( json ) {
      $(json).each(function(){
        arr.push(this);
      })
    });

    $("#conferma").click(function(){

      var ind = $("#indirizzoinput").val();

      $(".lista").append(""+arr.length+" records <br />");
      
      //js calculate
      //calc(ind);

      //php calculate
      call_leven(ind);

    });

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
$(".lista").append("<div>"+ind+" <span class='glyphicon glyphicon-arrow-right'></span> "+resArr[0]+" (Dist: "+resArr[1]+" Time:"+time+" ms )</div>");


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
      $(".lista").append("<div>"+rip+"</div>");
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