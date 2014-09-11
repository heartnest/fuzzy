$(function(){

//var a = new Array("via agonale","via anicia","via arenula","piazza belli","via bixio n.","via bramante","via canova");
 arr = new Array();
var resArr = new Array("word",1000);
//alert(3)

$.getJSON("json/Bo_php.json", function( json ) {
  $(json).each(function(){
    arr.push(this);
  })
});

$("#conferma").click(function(){
  var ind = $("#indirizzoinput").val();
   alert(ind+" "+arr.length);
   $(arr).each(function(){
     var dis = levenshtein2(ind,this);
     var dis = 3;
     if (dis < resArr[1]) {
       resArr[0] = this;
       resArr[1] = dis;
     };
     $(".lista").append("<div>"+ind+" and "+this+" distance "+dis+"</div>");
  })


//$(".lista").append("<div>Maybe you are searching:"+resArr[0]+" distance from you word"+resArr[1]+"</div>")
})

})


function levenshtein1 (s, t) {
   $(".lista").append("<div>run</div>");
  if (s.length === 0) return t.length;
  if (t.length === 0) return s.length;

  return Math.min(
    levenshteinDistance(s.substr(1), t) + 1,
    levenshteinDistance(t.substr(1), s) + 1,
    levenshteinDistance(s.substr(1), t.substr(1)) + (s[0] !== t[0] ? 1 : 0)
    );
}

// Compute the edit distance between the two given strings
function levenshtein2(a, b) {
  if(a.length === 0) return b.length; 
  if(b.length === 0) return a.length; 

  var matrix = [];

  // increment along the first column of each row
  var i;
  for(i = 0; i <= b.length; i++){
    matrix[i] = [i];
  }

  // increment each column in the first row
  var j;
  for(j = 0; j <= a.length; j++){
    matrix[0][j] = j;
  }

  // Fill in the rest of the matrix
  for(i = 1; i <= b.length; i++){
    for(j = 1; j <= a.length; j++){
      if(b.charAt(i-1) == a.charAt(j-1)){
        matrix[i][j] = matrix[i-1][j-1];
      } else {
        matrix[i][j] = Math.min(matrix[i-1][j-1] + 1, // substitution
                                Math.min(matrix[i][j-1] + 1, // insertion
                                         matrix[i-1][j] + 1)); // deletion
      }
    }
  }

  return matrix[b.length][a.length];
};

function levenshtein3(u, v) {
  var m = u.length;
  var n = v.length;
  var D = [];
  for(var i = 0; i <= m; i++) {
    D.push([]);
    for(var j = 0; j <= n; j++) {
      D[i][j] = 0;
    }
  }
  for(var i = 1; i <= m; i++) {
    for(var j = 1; j <= n; j++) {
      if (j == 0) {
        D[i][j] = i;
      } else if (i == 0) {
        D[i][j] = j;
      } else {
        D[i][j] = [D[i-1][j-1] + (u[i-1] != v[j-1]), D[i][j-1] + 1, D[i-1][j] + 1].sort()[0];
      }
    }
  }
  return D[m][n];
};

function levenshtein4(s1, s2) {
  //       discuss at: http://phpjs.org/functions/levenshtein/
  //      original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
  //      bugfixed by: Onno Marsman
  //       revised by: Andrea Giammarchi (http://webreflection.blogspot.com)
  // reimplemented by: Brett Zamir (http://brett-zamir.me)
  // reimplemented by: Alexander M Beedie
  //        example 1: levenshtein('Kevin van Zonneveld', 'Kevin van Sommeveld');
  //        returns 1: 3

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

  // BEGIN STATIC
  var split = false;
  try {
    split = !('0')[0];
  } catch (e) {
    split = true; // Earlier IE may not support access by string index
  }
  // END STATIC
  if (split) {
    s1 = s1.split('');
    s2 = s2.split('');
  }

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

//http://www.merriampark.com/ld.htm, http://www.mgilleland.com/ld/ldjavascript.htm, Damerau–Levenshtein distance (Wikipedia)
function levenshtein5(s, t) {
    var d = []; //2d matrix

    // Step 1
    var n = s.length;
    var m = t.length;

    if (n == 0) return m;
    if (m == 0) return n;

    //Create an array of arrays in javascript (a descending loop is quicker)
    for (var i = n; i >= 0; i--) d[i] = [];

    // Step 2
  for (var i = n; i >= 0; i--) d[i][0] = i;
    for (var j = m; j >= 0; j--) d[0][j] = j;

    // Step 3
  for (var i = 1; i <= n; i++) {
    var s_i = s.charAt(i - 1);

        // Step 4
        for (var j = 1; j <= m; j++) {

            //Check the jagged ld total so far
            if (i == j && d[i][j] > 4) return n;

            var t_j = t.charAt(j - 1);
            var cost = (s_i == t_j) ? 0 : 1; // Step 5

            //Calculate the minimum
            var mi = d[i - 1][j] + 1;
            var b = d[i][j - 1] + 1;
            var c = d[i - 1][j - 1] + cost;

            if (b < mi) mi = b;
            if (c < mi) mi = c;

            d[i][j] = mi; // Step 6

            //Damerau transposition
            if (i > 1 && j > 1 && s_i == t.charAt(j - 2) && s.charAt(i - 2) == t_j) {
              d[i][j] = Math.min(d[i][j], d[i - 2][j - 2] + cost);
            }
          }
        }

    // Step 7
    return d[n][m];
  }

