
var yearShow ="test";
var monthoShow = "test";
var datetrack = 0;
var date_tran ='';
var firstDate = 0;
var LastDate = 0;

//alert(<?php echo $_SESSION['id']; ?>);	
//alert(<?php echo $_SESSION['id']; ?>);

//alert(sessionexternal);



getWeekName();
getNowCalendarPar();




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
	monthoShow = Month+1;
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
      str += "<td class='NullDay'></td>"
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
      str += "<td class='NullDay'></td>";
    }
  }
  str += "</tr></table>";
  var objDom1 = document.getElementById('cc');
  objDom1.innerHTML = str;
	firstDate = yearShow +'-'+ monthoShow +'-'+  1;
	LastDate = yearShow +'-'+ monthoShow +'-'+  LasDay;
}


function Nex_Month(Year, Month) {
  
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
	//alert(firstDate);
	//alert(LastDate);

  var table = document.getElementById("table"), rIndex, cIndex;

  var oDiv = document.getElementById('text');
	monthlyReport(firstDate,LastDate);
  var nulldate = document.getElementsByClassName('NullDay');
	console.log("NullDay");
	console.log(nulldate);
	
  // table rows
  for (var i = 0; i < table.rows.length; i++) {
    // row cells
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      table.rows[i].cells[j].onclick = function () {
		  if(!this.innerHTML == ''){
		  //console.log("This is this.innerHTML");
		  //console.log(this.innerHTML);
		  
        rIndex = this.parentElement.rowIndex;
        cIndex = this.cellIndex + 1;
        console.log("Row : " + rIndex + " , Cell : " + cIndex);
		
        
        //oDiv.innerHTML = '<h2>Hello--------------: ' + "Row : " + rIndex + " , Cell : " + cIndex + '<p>balance is: datetrack:  '+ datetrack + this.innerHTML + '<p/>';
			//oDiv.innerHTML = '<h2>Hello: ' + "Row : " + rIndex + " ,<?php echo $greting ?> : " + cIndex + '<p>balance is: ' + this.innerHTML + '<p/>';
		
		//alert(user_id);
		
		//datetrack = yearShow+'-'+(monthoShow<10?'0')+monthoShow+'-'+(this.innerHTML<10?'0')+this.innerHTML;
		datetrack = dateFormat(yearShow,monthoShow,this.innerHTML);
		
		oDiv.innerHTML = '<button onclick=openModal() type ="button" >add event</button><p> Date: '+ datetrack + ' </p>';
		//console.log("year : " + yearShow + " , month : " + monthoShow);
		date_tran = datetrack;
		
		//Ajax
		event.preventDefault();
			
		showReport(user_id,datetrack,oDiv);
		
		
		
		};
	  };
			/*
			table.rows[i].cells[j].onclick = function () {
				
					openModal();
				
			};
			*/
	  

    }
  }
};


//window.onload=
function showText() {
	//alert(firstDate);
	//alert(LastDate);

  var table = document.getElementById("table"), rIndex, cIndex;

  var oDiv = document.getElementById('text');
	monthlyReport(firstDate,LastDate);

  // table rows
	 for (var i = 0; i < table.rows.length; i++) {
    // row cells
    for (var j = 0; j < table.rows[i].cells.length; j++) {
      table.rows[i].cells[j].onclick = function ()  {
		  if(!this.innerHTML == ''){
		  //console.log("This is this.innerHTML");
		  //console.log(this.innerHTML);
		  
        rIndex = this.parentElement.rowIndex;
        cIndex = this.cellIndex + 1;
        console.log("Row : " + rIndex + " , Cell : " + cIndex);
		
        
        //oDiv.innerHTML = '<h2>Hello--------------: ' + "Row : " + rIndex + " , Cell : " + cIndex + '<p>balance is: datetrack:  '+ datetrack + this.innerHTML + '<p/>';
			//oDiv.innerHTML = '<h2>Hello: ' + "Row : " + rIndex + " ,<?php echo $greting ?> : " + cIndex + '<p>balance is: ' + this.innerHTML + '<p/>';
		
		//alert(user_id);
		
		datetrack = dateFormat(yearShow,monthoShow,this.innerHTML);
		oDiv.innerHTML = '<button onclick=openModal() type ="button" >add event</button><p> Date: '+ datetrack + ' </p>';
		//console.log("year : " + yearShow + " , month : " + monthoShow);
		
		date_tran=datetrack;
		
		//Ajax
		event.preventDefault();
						//alert("The form was submitted");
						
			showReport(user_id,datetrack,oDiv);
		
		
		
		
		};
	  };
		
		/*
			table.rows[i].cells[j].onclick = function () {
				
					openModal();
				
			};
			*/

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
	
	//alert(date_tran);
	document.getElementById("input_date").value = date_tran;
	
	
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


	var addEvent = document.getElementById("addEvent");
				addEvent.onsubmit = post;
	//var text_addEvent =	document.getElementById("text_addEvent");

			function myfunciton(){
		
				alert("test myfunction");
			}

		function post() {
			//alert("post called");
					event.preventDefault();						
						var tranSelection = document.getElementById("transactionAccountSelection").value;
						var tranInput = document.getElementById("tranInput").value;
						var statementName = document.getElementById("statementName").value;
						var input_date = document.getElementById("input_date").value;
						var oDiv = document.getElementById('text');
						
						if(tranSelection&&tranInput){	
								//alert("post called");						
								//alert(tranSelection);
								//alert(tranInput);
								//alert(aid);
								//alert(statementName);
								$.ajax
							({
								type: 'post',
								url: 'addevent.php',
								data: 
							{
								tranSelection:tranSelection,
								user_id:user_id,
								tranInput: tranInput,
								datetrack:input_date ,
								aid:aid,
								statementName:statementName
								
	     
							},
								success: function (response) 
							{																
								console.log("test hi");
								//alert(response);
								if(response =="add data successfully"){
									
									closeModal();
									oDiv.innerHTML= '';
									oDiv.innerHTML='<button onclick=openModal() type ="button" >add event</button><p> Date: '+ input_date + ' </p>';
									showReport(input_date,user_id);									
									document.getElementById("addEvent").reset();
									resetForm();
									
								}																
								//alert(response);								
								//document.getElementById("text_addEvent").innerHTML = response; 
							}
							});
							//xhr.abort();
						}
					
				}

				
				
		function dateFormat(year,month,day){
			this.year = year;
			this.month = month;
			this.day = day;
			if(month < 10){
				month = '0'+month;
			}
			
			if(day < 10){
				day = '0'+day;
			}
			return year+'-'+month +'-'+day;
		}


function showReport(){
	var oDiv = document.getElementById('text');
		//alert("showReport is called");
			var test =1;	
			
			if(test ==1){				
				$.ajax
			({
				type: 'post',
				url: 'showdailyreport.php',
			data: 
			{
					user_id:user_id,
					datetrack:datetrack
					
	     
			},
				success: function (response) 
			{
				
				console.log("hi");
				oDiv.innerHTML= oDiv.innerHTML +response;				      
  
			}
			});
				
			}
	
	
}


function resetForm() {
    document.getElementById("addEvent").reset();
}


function monthlyReport(){
	//alert("monthlyReport");
	var oDiv = document.getElementById('text');
	oDiv.innerHTML= '';
	oDiv.innerHTML='<h2>Monthly Report</h2><p></p><button onclick=openModal() type ="button" >add event</button';

		
			var test =1;	
			
			if(test ==1){				
				$.ajax
			({
				type: 'post',
				url: 'showMonthlyreport.php',
			data: 
			{
					user_id:user_id,
					firstDate:firstDate,
					LastDate:LastDate
					
	     
			},
				success: function (response) 
			{
				
				console.log("hi");
				oDiv.innerHTML= oDiv.innerHTML +response;				      
  
			}
			});
				
			}
	
}


