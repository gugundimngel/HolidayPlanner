$(document).ready(function () {
   // SetSlider("0","0");
   //PriceSortOneWay('ascending');
})

function doFilter(filterType, filterValue, event) {
    var fiteredArray = [];
    if (document.getElementById('multifilter').value == "0") {
        var flight = [];
       var Price = { lower: "", higher: "" };
       var mStop = { stop: "" };
        var DepTime = { deptime: "" };
		 var craft = [];
		  var stop = [];
    } else {
        var fdata = JSON.parse(document.getElementById('multifilter').value);
        var flight = fdata[0];
        var Price = fdata[1];
        var mStop = fdata[2];
        var DepTime = fdata[3];
		var craft = fdata[4];
		
		var stop = fdata[5];
    }
    var allData = JSON.parse($("#hfFilterData").val());
    var flightFilterData = [], depTimeFilterData = [], priceFilterData = [], craftFilterData = [], stopFilterData = [];
    switch (filterType) {
        case "flight":
		console.log(flight);
            if (event.srcElement.checked) {
                if (flight.indexOf(filterValue) == -1) {
                    flight.push(filterValue);
                }
            } else {

                if (flight.indexOf(filterValue) !== -1) {
                    removeA(flight, filterValue);
                }
            }
            if (flight.length == 0) {
                var allDatas = [];
                for (var i = 0; i < allData.length; i++) {
                    allDatas.push(allData[i].IndexNumber);
                }
                runFilter(allDatas);
            }
            break;
        case "price":
            Price.lower = filterValue.split("#")[0];
            Price.higher = filterValue.split("#")[1];
            if (flight.length == 0) {
                for (var i = 0; i < allData.length; i++) {
                    var actPrice = parseInt(allData[i].GrandTotal);
                    if (actPrice >= parseInt(Price.lower) && actPrice <= parseInt(Price.higher)) {
                        priceFilterData.push(allData[i].IndexNumber);
                    }
                }
                runFilter(priceFilterData);
            }
            break; 
        case "mstop":
           /*  Stop.stop = filterValue;
            if (flight.length == 0) {
				if(filterValue == 0){
					for (var i = 0; i < allData.length; i++) {
					
						if (parseInt(allData[i].Stop) == (parseInt(Stop.stop) + 1)) {
							stopFilterData.push(allData[i].IndexNumber);
						} 
					}
				}else if(filterValue == 1){
					for (var i = 0; i < allData.length; i++) {
					
						if (parseInt(allData[i].Stop) == (parseInt(Stop.stop) + 1)) {
							stopFilterData.push(allData[i].IndexNumber);
						} 
					}
				}else{
					for (var i = 0; i < allData.length; i++) {
						if(parseInt(allData[i].Stop) > (parseInt(Stop.stop))){
							stopFilterData.push(allData[i].IndexNumber);
						}
					}
				}
                
                runFilter(stopFilterData);
            } */
            break;
        case "deptime":
			DepTime.lower = filterValue.split("#")[0];
            DepTime.higher = filterValue.split("#")[1];
            DepTime.deptime = filterValue;
           /*  if (flight.length == 0) {
                for (var i = 0; i < allData.length; i++) {
                    if (allData[i].DTime.split(':')[0] == parseInt(DepTime.deptime)) {
                        depTimeFilterData.push(allData[i].IndexNumber);
                    }
                }
                runFilter(depTimeFilterData);
            } */
			
			if (flight.length == 0) {
                for (var i = 0; i < allData.length; i++) {
                    if (allData[i].DTime.split(':')[0] >= parseInt(DepTime.lower) && allData[i].DTime.split(':')[0] <= parseInt(DepTime.higher)) {
                        depTimeFilterData.push(allData[i].IndexNumber);
                    }
                }
                runFilter(depTimeFilterData);
            }
            break; 
			case "craft":
  
				 if (event.srcElement.checked) {
                if (craft.indexOf(filterValue) == -1) {
                    craft.push(filterValue);
                }
            } else {

                if (craft.indexOf(filterValue) !== -1) {
                    removeA(craft, filterValue);
                }
            }
			 
			
			  var craftFilterData = [];
              for (var i = 0; i < allData.length; i++) {
				  console.log(allData[i].IndexNumber+'------------>'+craft.indexOf(allData[i].craft) + ' '+allData[i]);
                    if (craft.indexOf(allData[i].craft) >=0 ) {
                        craftFilterData.push(allData[i].IndexNumber);
                    }
                }
                runFilter(craftFilterData);
			if (flight.length == 0 && craft.length == 0) {
                var allDatas = [];
                for (var i = 0; i < allData.length; i++) {
                    allDatas.push(allData[i].IndexNumber);
                }
                runFilter(allDatas);
            }
            break; 
			case "stop":
         
				  if (event.srcElement.checked) {
                if (stop.indexOf(filterValue) == -1) {
                    stop.push(filterValue);
                }
            } else {

                if (stop.indexOf(filterValue) !== -1) {
                    removeA(stop, filterValue);
                }
            } 
			var onestop = '';
			var tstop = '';
			var hstop = '';
			for(var i = 0; i<stop.length;i++){
				if(stop[i] == 0){
					onestop = 0;
				}
				if(stop[i] == 1){
					tstop =1;
				}
				if(stop[i] == 2){
					hstop = 2;
				}
			}
			
	
			var f = '';
			if(stop.length >0){
			for (var i = 0; i < allData.length; i++) {
				console.log(stop);
				if(allData[i].stop == (parseInt(onestop) + 1)){
						stopFilterData.push(allData[i].IndexNumber);
                    }
					if(allData[i].stop == (parseInt(tstop) + 1)){
						stopFilterData.push(allData[i].IndexNumber);
                    }
					if(allData[i].stop == hstop){
						if(parseInt(allData[i].Stop) > 1){
							stopFilterData.push(allData[i].IndexNumber);
						}
                    }
                }
				runFilter(stopFilterData);
			}else{
				if (flight.length == 0 && stop.length == 0) {
                var allDatas = [];
                for (var i = 0; i < allData.length; i++) {
                    allDatas.push(allData[i].IndexNumber);
                }
                runFilter(allDatas);
            }
			}
			
              
            break; 
        default:

            break;
    }
    fiteredArray.push(flight);
   
    fiteredArray.push(Price);
    fiteredArray.push(mStop);
    fiteredArray.push(DepTime);
	 fiteredArray.push(craft);
	 fiteredArray.push(stop);
    document.getElementById('multifilter').value = JSON.stringify(fiteredArray);
    if (fiteredArray[0].length > 0) {
        for (var i = 0; i < allData.length; i++) {
            var flight = fiteredArray[0];
            for (var j = 0; j < flight.length; j++) {
                if (allData[i].AirV.toLowerCase() == flight[j].toLowerCase()) {
                    flightFilterData.push(allData[i].IndexNumber);

                    if (fiteredArray[1].higher !== "" && fiteredArray[1].lower != "") {
                        var actPrice = parseInt(allData[i].GrandTotal);
                        if (actPrice >= parseInt(fiteredArray[1].lower) && actPrice <= parseInt(fiteredArray[1].higher)) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
                    if (fiteredArray[2].stop != "") {
                        if (parseInt(allData[i].Stop) == (parseInt(fiteredArray[2].stop) + 1)) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
                    if (fiteredArray[3].deptime != "") {
                        if (allData[i].DTime.split(':')[0] == parseInt(fiteredArray[3].deptime)) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
					if (fiteredArray[4].length > 0) {
					//	console.log(craft.indexOf(filterValue));
                        if (fiteredArray[4].indexOf(allData[i].craft)  >= 0) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
					
					  if (fiteredArray[5].length > 0) {
				
                        if (fiteredArray[5].indexOf(allData[i].stop)  === -1) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
                }
            }
        }
        runFilter(flightFilterData);
    }
}
function isInArray(value, array) {
  return array.indexOf(value) > -1;
}
function PriceSortOneWay(val = '') {
	if(val == ''){
    var order_type = $('#pricesorting').val();
	}else{
		 var order_type = 'ascending';
	}
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
            return $(a).find(".price").text() - $(b).find(".price").text();
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#pricesorting').val('descending');
		$('.pricesorta').show();
		$('.pricesortd').hide();
    }
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return $(b).find(".price").text() - $(a).find(".price").text();
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#pricesorting').val('ascending');
			$('.pricesorta').hide();
		$('.pricesortd').show();
        }
}
function AirlineSortOneWay() {
    var order_type = $('#airsorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".flight_name").text().toUpperCase()) <  
                    ($(a).find(".flight_name").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#airsorting').val('descending');
		$('.airsorta').show();
		$('.airsortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".flight_name").text().toUpperCase()) >  
                    ($(a).find(".flight_name").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#airsorting').val('ascending');
			$('.airsorta').hide();
			$('.airsortd').show();
        }
}

function DepartSortOneWay() {
    var order_type = $('#depasorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".custom_box_result .departdate").text().toUpperCase()) <  
                    ($(a).find(".custom_box_result .departdate").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#depasorting').val('descending');
		$('.depasorta').show();
		$('.depasortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".custom_box_result .departdate").text().toUpperCase()) >  
                    ($(a).find(".custom_box_result .departdate").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#depasorting').val('ascending');
			$('.depasorta').hide();
			$('.depasortd').show();
        }
}
function DurationSortOneWay() {
    var order_type = $('#durasorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".duration").text().toUpperCase()) <  
                    ($(a).find(".duration").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#durasorting').val('descending');
		$('.durasorta').show();
		$('.durasortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".duration").text().toUpperCase()) >  
                    ($(a).find(".duration").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#durasorting').val('ascending');
			$('.durasorta').hide();
			$('.durasortd').show();
        }
}function ArriveSortOneWay() {
    var order_type = $('#arrivesorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".arivedate").text().toUpperCase()) <  
                    ($(a).find(".arivedate").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#arrivesorting').val('descending');
		$('.arriveasorta').show();
		$('.arrivesortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".arivedate").text().toUpperCase()) >  
                    ($(a).find(".arivedate").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#arrivesorting').val('ascending');
			$('.arriveasorta').hide();
			$('.arrivesortd').show();
        }
}
function runFilter(filteredArray) {
	console.log(filteredArray);
    $('.flight-list-v2').hide();
    for (var i = 0; i < filteredArray.length; i++) {
        document.getElementById("div" + filteredArray[i]).style.display = "block";
    }
}

function removeA(arr) {
    var what, a = arguments, L = a.length, ax;
    while (L > 1 && arr.length) {
        what = a[--L];
        while ((ax = arr.indexOf(what)) !== -1) {
            arr.splice(ax, 1);
        }
    }
    return arr;
}
function ClearAll() {
    document.getElementById('multifilter').value = "0";
    $('.chboxAirline').attr("checked", "checked");
    $('.Stopfliter').prop("checked", false);
    $('.allshow').show();
    $('#demo-slider-container').empty();
    min = $("#hdnMinCost").val();
    max = $("#hdnMaxCost").val();
    //SetSlider(min, max);

    var w = document.getElementsByTagName('input');
    for (var i = 0; i < w.length; i++) {
        if (w[i].type == 'checkbox') {
            w[i].checked = false;
        }
    }
}