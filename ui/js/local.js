 // **********************************************************
 //
 // Used on every list.htm file to filter "shorts" table object
 // Set column number from controller using '[1,2,3]' format
 //
 // **********************************************************

    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        // Columns to inspect
        var columns = {{ @columns }};
        filter = document.getElementById("search").value.toUpperCase();
        table = document.getElementById("shorts");
        tr = table.getElementsByTagName("tr");
        td = [];
        for (i = 1; i < tr.length; i++) {
         for (var j of columns) {
            td[j] = tr[i].getElementsByTagName("td")[j];
            if (td[j].innerText != '') {
                if (td[j].innerText.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
         }
        }
    }

 // *************************************
 // JavaScript program to illustrate
 // Table sort for both columns and
 // both directions
 // *************************************

        function sortTable(n) {
            let table;
            table = document.getElementById("shorts");
            var rows, i, x, y, count = 0;
            var switching = true;

           // Order is set as ascending
            var direction = "ascending";

            // Run loop until no switching is needed
            while (switching) {
                switching = false;
                var rows = table.rows;

                //Loop to go through all rows
                for (i = 1; i < (rows.length - 1); i++) {
                    var Switch = false;

                    // Fetch 2 elements that need to be compared
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
 
                    // Check the direction of order
                    if (direction == "ascending") {
 
                        // Check if 2 rows need to be switched
                        if (x.innerHTML.toLowerCase() >
                        y.innerHTML.toLowerCase()) {
                             
                            // If yes, mark Switch as needed
                            // and break loop
                            Switch = true;
                            break;
                        }
                    } else if (direction == "descending") {
 
                        // Check direction
                        if (x.innerHTML.toLowerCase() <
                        y.innerHTML.toLowerCase()) {
 
                            // If yes, mark Switch as needed
                            // and break loop
                            Switch = true;
                            break;
                        }
                    }
                }
                if (Switch) { 
                    // Function to switch rows and mark
                    // switch as completed
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
 
                    // Increase count for each switch
                    count++;
                } else {
 
                    // Run while loop again for descending order
                    if (count == 0 && direction == "ascending") {
                        direction = "descending";
                        switching = true;
                    }
                }
            }
        }


 function getCheckboxValue(va) {
	strw = window.document.getElementById('chkbox').value;
	if (va.checked) { 
	  console.log('checked');
  	  if (!strw.includes(va.value)) {
	    window.document.getElementById('chkbox').value += va.value +",";
	    strw += va.value+",";
          }
	} else { 
            console.log('unchecked');
	    strw = strw.replace(va.value+',',''); 
	    window.document.getElementById('chkbox').value = strw;		
	}
		
    console.log('v:'+window.document.getElementById('chkbox').value);
    console.log('f:'+strw);

 }
 function goCheckboxDate() {
	val = window.document.getElementById('chkbox').value;
    if(val.length>0) {
	urltodate = "/mat/buyer/"+val;
	console.log(urltodate)
	window.open("https://info.diaz.works"+urltodate,"_blank");
    } else {
	alert('Select something... Please!');
    }
 }
 function goCheckboxSupplier() {
        val = window.document.getElementById('chkbox').value;
    if(val.length>0) {
        urltodate = "/mat/supplier/"+val;
        console.log(urltodate)
        window.open("https://info.diaz.works"+urltodate,"_blank");
    } else {
        alert('Select something... Please!');
    }
 }
 function goCheckboxNotes() {
	val = window.document.getElementById('chkbox').value;
    if(val.length>0) {
	urltodate = "/mat/notes/"+val;
	console.log(urltodate)
	window.open("https://info.diaz.works"+urltodate,"_blank");
    } else {
	alert('Select something... Please!');
    }
 }
 function goCheckboxShipdate() {
        val = window.document.getElementById('chkbox').value;
    if(val.length>0) {
        urltodate = "/mat/ship/"+val;
        console.log(urltodate)
        window.open("https://info.diaz.works"+urltodate,"_blank");
    } else {
        alert('Select something... Please!');
    }
 }
 function goCheckboxReason() {
        val = window.document.getElementById('chkbox').value;
    if(val.length>0) {
        urltodate = "/mat/reason/"+val;
        console.log(urltodate)
        window.open("https://info.diaz.works"+urltodate,"_blank");
    } else {
        alert('Select something... Please!');
    }
 }
 function questions() {
	const question = [
	"Are you sure?",
	"It's going to disappear forever..",
	"You will not get it back!",
	"Do you really want to remove it?",
	"Record will be deleted for goooood!",
	"You can cancel by clicking -cancel-",
	"Record will be deleted!",
	"Do you have a backup?",
	"Did you ask for permission?",
	"Data wil be lost",
	]
	var rdm = Math.floor(Math.random()*10);
	return question[rdm];
 }

 function checkremove(ids) {
   var answer = window.confirm(questions()); 
   if (answer) {
     window.location.replace("/mat/remove/"+ids);
   } 
 }
