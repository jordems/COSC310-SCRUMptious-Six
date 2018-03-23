


getWeekName();
getNowCalendarPar();



var yearShow ="20000";
var monthoShow = "13";

function Init_Info_Form(Year, Month) {
  var str = '';
  str += "<input class='button' type='button' value='last year' Onclick='Las_Year(" + Year + "," + Month + ")'></input>";
  str += "<input class='button' type='button' value='last month' Onclick='Las_Month(" + Year + "," + Month + ")'></input>";
  str += "　<big>" + " Year: " + Year + " Month: " + (Month + 1) + "</big>　";
  str += "<input class='button' type='button' value='Next Month' Onclick='Nex_Month(" + Year + "," + Month + ")'></input>";
  str += "<input class='button' type='button' value='Next Year' Onclick='Nex_Year(" + Year + "," + Month + ")'></input>";
  var objDom1 = document.getElementById('aa');
  objDom1.innerHTML = str;
	yearShow = Year;
	monthoShow = Month;
}


function getWeekName() {
  var WeekName = new Array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat");
  Init_Week_Form(WeekName);
}



function Init_Week_Form(WeekName) {
  var strhtml = "";
  var c = WeekName.length;
  strhtml += '<table border="1" cellspacing="0">';
  strhtml += ("<tr>");										//<tr>
  for (var i = 0; i < c; i++) {
    strhtml += "<td class='Week'><center>" + WeekName[i] + "</center></td>";		//<td> week
  }
  strhtml += ("</tr>");										//</tr>
  strhtml += "</table>";
  // return strhtml;
  var objDom1 = document.getElementById('bb');
  objDom1.innerHTML = strhtml;
}


function getCalendarPar(Year, Month) {
  var FirstDay = new Date(Year, Month, 1, 0, 0, 0);
  FirDay = FirstDay.getDay();
  var Las = new Date(Year, Month + 1, 0)
  LasDay = Las.getDate();
  Init_Calendar_Form(Year, Month, FirDay, LasDay);
}


function getNowCalendarPar() {
  var Now = new Date();
  Year = Now.getFullYear();
  Month = Now.getMonth();
  var Fir = new Date(Year, Month, 1, 0, 0, 0);
  FirDay = Fir.getDay();
  var Las = new Date(Year, Month + 1, 0)
  LasDay = Las.getDate();
  Init_Calendar_Form(Year, Month, FirDay, LasDay);
}

function Init_Calendar_Form(Year, Month, FirDay, LasDay) {
  Init_Info_Form(Year, Month);
  var str = '';
  var Cal = 0;
  str += "<table id='table' border='1' cellspacing='0'><tr>";
  if (FirDay > 0) {
    for (var i = 0; i < FirDay; i++) {
      str += "<td class='NullDay'><center>－</center></td>"
      Cal++;
    }
  }
  for (var j = 0; j < LasDay; j++) {
    str += "<td class='Day' valign='top'>" + (j + 1) + "</td>";
    Cal++;
    if (Cal == 7) {
      str += "</tr><tr>"
      Cal = 0;
    }
  }
  if (Cal != 0) {
    for (var k = Cal; k < 7; k++) {
      str += "<td class='NullDay'><center>－</center></td>";
    }
  }
  str += "</tr></table>";
  var objDom1 = document.getElementById('cc');
  objDom1.innerHTML = str;

}


function Nex_Month(Year, Month) {
  //showText();
  if (Month == 11) {
    Year++;
    Month = 0;
  } else {
    Month++
  }
  getCalendarPar(Year, Month);
  showText();
}


function Las_Month(Year, Month) {

  if (Month == 0) {
    Year--;
    Month = 11;
  } else {
    Month--
  }
  getCalendarPar(Year, Month);
  showText();
}

function Las_Year(Year, Month) {

  Year--;
  getCalendarPar(Year, Month);
  showText();
}


function Nex_Year(Year, Month) {

  Year++;
  getCalendarPar(Year, Month);
  showText();
}

var aDatas = [
  "0",
  "1",
  "2",
  "3",
  "4",
  "5",
  "6",
  "7",
  "8",
  "9",
  "10",
  "12",
  "13"
];

window.onload = function showText1() {

  var table = document.getElementById("table"), rIndex, cIndex;

  var oDiv = document.getElementById('text');


  // table rows
  for (var i = 0; i < table.rows.length; i++) {
    // row cells
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      table.rows[i].cells[j].onmouseover = function () {
        rIndex = this.parentElement.rowIndex;
        cIndex = this.cellIndex + 1;
        console.log("Row : " + rIndex + " , Cell : " + cIndex);
        oDiv.innerHTML = '<h2>Hello: ' + "Row : " + rIndex + " , Cell : " + cIndex + '<p>balance is: ' + this.innerHTML + '<p/>';
			//oDiv.innerHTML = '<h2>Hello: ' + "Row : " + rIndex + " ,<?php echo $greting ?> : " + cIndex + '<p>balance is: ' + this.innerHTML + '<p/>';
		
      };
		
			table.rows[i].cells[j].onclick = function () {
				
					openModal();
				
			};

    }
  }
};


//window.onload=
function showText() {

  var table = document.getElementById("table"), rIndex, cIndex;

  var oDiv = document.getElementById('text');


  // table rows
	 for (var i = 0; i < table.rows.length; i++) {
    // row cells
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      table.rows[i].cells[j].onmouseover = function () {
        rIndex = this.parentElement.rowIndex;
        cIndex = this.cellIndex + 1;
        console.log("Row : " + rIndex + " , Cell : " + cIndex);
        oDiv.innerHTML = '<h2>Hello: ' + "Row : " + rIndex + " , Cell : " + cIndex + '<p>balance is: ' + this.innerHTML + '<p/>';
		
		event.preventDefault();
						alert("The form was submitted");
						var comment = document.getElementById("comment").value;
			if(comment){
				alert("this is comment");
				$.ajax
			({
				type: 'post',
				url: 'post_comments.php',
			data: 
			{
					user_comm:comment,
					user_id:1
	     
			},
				success: function (response) 
			{
				alert("after success");
				console.log("hi");
				oDiv.innerHTML=response + oDiv.innerHTML;
				
       
  
			}
			});
						}
		
		
	
		
      };
		
			table.rows[i].cells[j].onclick = function () {
				
					openModal();
				
			};

    }
  }

};


//windowPopup

var modal = document.getElementById("simpleModal");


var modalBtn = document.getElementById("modalBtn");


var closeBtn = document.getElementsByClassName('closeBtn')[0];

//modalBtn.addEventListener("click",openModal);

closeBtn.addEventListener("click",closeModal);

window.addEventListener("click",outsiteClick);


// pop up
function openModal(){
	modal.style.display = "block";
}

// close
function closeModal(){
	modal.style.display = "none";
}

// outsiteClick
function outsiteClick(e){
	if (e.target == modal) {
		modal.style.display = "none";
	}
}



$('select[name=outcome]').change(function() {
    if ($(this).val() == '')
    {
        var newThing = prompt('Enter a name for the new thing:');
        var newValue = $('option', this).length;
        $('<option>')
            .text(newThing)
            .attr('value', newValue)
            .insertBefore($('option[value=]', this));
        $(this).val(newValue);
		
    }
});



















