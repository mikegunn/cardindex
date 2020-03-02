    $.getJSON("https://spreadsheets.google.com/feeds/list/17gxSsNCJ4nYTV3npmlWgjJL6l_461mqEgY8d0ct4q7s/od6/public/values?alt=json", function (data) {

      var sheetData = data.feed.entry;

      var i;
      for (i = 0; i < sheetData.length; i++) {

        var name = data.feed.entry[i]['gsx$position']['$t'];
        var age = data.feed.entry[i]['gsx$games']['$t'];
        var email = data.feed.entry[i]['gsx$referee']['$t'];

        document.getElementById('demo').innerHTML += ('<tr>'+'<td>'+name+'</td>'+'<td>'+age+'</td>'+'<td>'+email+'</td>'+'</tr>');

      }
    });
