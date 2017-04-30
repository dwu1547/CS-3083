function getStarttime()
{	var sYear;
	var sMonth;
	var sDate;
	var eYear;
	var eMonth;
	var eDate;
	
	sYear = document.getElementById("startYear").value
	sMonth = document.getElementById("startMonth").value
	sDate = document.getElementById("startDate").value
	
	eYear = document.getElementById("endYear").value
	eMonth = document.getElementById("endMonth").value
	eDate = document.getElementById("endDate").value
	document.getElementById("outS").innerHTML = sYear+"-"+sMonth+"-"+sDate;
	document.getElementById("outE").innerHTML = eYear+"-"+eMonth+"-"+eDate;
	return false;
}

 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
      }