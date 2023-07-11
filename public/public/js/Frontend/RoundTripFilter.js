$(document).ready(function () {
  /*   min = $("#hdnMinCost0").val();
    max = $("#hdnMaxCost0").val();
    SetSlider(min, max); */
	//PriceSortDRTO('ascending');
	//PriceSortDRTR('ascending');
})
function doFilter(filterType, filterValue, event) {
    var fiteredArray = [];
    if (document.getElementById('multifilter').value == "0") {
        var flight = [];
        var Price = { lower: "", higher: "" };
        var Stop = { stop: "" };
        var DepTime = { deptime: "" };
    } else {
        var fdata = JSON.parse(document.getElementById('multifilter').value);
        var flight = fdata[0];
        var Price = fdata[1];
        var Stop = fdata[2];
        var DepTime = fdata[3];
		var craft = fdata[4];
    }
    var allData = JSON.parse($("#hfFilterData").val());
    var flightFilterData = [], stopFilterData = [], depTimeFilterData = [], priceFilterData = [];
    switch (filterType) {
        case "flight":
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
			case "returnprice":
            Price.lower = filterValue.split("#")[0];
            Price.higher = filterValue.split("#")[1];
            if (flight.length == 0) {
                for (var i = 0; i < allData.length; i++) {
                    var actPrice = parseInt(allData[i].GrandTotal);
                    if (actPrice >= parseInt(Price.lower) && actPrice <= parseInt(Price.higher)) {
                        priceFilterData.push(allData[i].IndexNumber);
                    }
                }
                runreturnFilter(priceFilterData);
            }
            break;
        case "stop":
              Stop.stop = filterValue;
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
						if(parseInt(allData[i].Stop) >= (parseInt(Stop.stop) + 1)){
							stopFilterData.push(allData[i].IndexNumber);
						}
					}
				}
                
                runFilter(stopFilterData);
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
        default:

            break;
    }
    fiteredArray.push(flight);
    fiteredArray.push(Price);
    fiteredArray.push(Stop);
	 fiteredArray.push(craft);
    fiteredArray.push(DepTime);
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
					if (fiteredArray[4].length > 0) {
					//	console.log(craft.indexOf(filterValue));
                        if (fiteredArray[4].indexOf(allData[i].craft)  >= 0) {
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
                }
            }
        }
        runFilter(flightFilterData);
    }
}
function runFilter(filteredArray) {

    $('.flight-list-v2').hide();
    for (var i = 0; i < filteredArray.length; i++) {
        document.getElementById("div" + filteredArray[i]).style.display = "block";
    }
}

function runreturnFilter(filteredArray) {

    $('.returnflight-list-v2').hide();
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



function runFilterDRT(filteredArray) {
    console.log(filteredArray);
    $('.DRTFilter').hide();
    for (var i = 0; i < filteredArray.length; i++) {
        $("#div" + filteredArray[i]).show();
    }
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


function doFilterDRT(filterType, filterValue, event) {
    var fiteredArray = [];
    if (document.getElementById('multifilter').value == "0") {
        var flight = [];
        var Price = { lower: "", higher: "" };
        var Stop = { stop: "" };
        var DepTime = { deptime: "" };
		var craft = [];
    } else {
        var fdata = JSON.parse(document.getElementById('multifilter').value);
        var flight = fdata[0];
        var Price = fdata[1];
        var Stop = fdata[2];
        var DepTime = fdata[3];
		var craft = fdata[4];
    }
    var allData = JSON.parse($("#hfFilterData").val());
    var flightFilterData = [], stopFilterData = [], depTimeFilterData = [], priceFilterData = [], craftFilterData = [];
    switch (filterType) {
        case "flight":
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
                runFilterDRT(allDatas);
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
                runFilterDRT(priceFilterData);
            }
            break;
        case "stop":
           Stop.stop = filterValue;
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
						if(parseInt(allData[i].Stop) > (parseInt(Stop.stop) + 1)){
							stopFilterData.push(allData[i].IndexNumber);
						}
					}
				}
                
                runFilterDRT(stopFilterData);
            }
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
                runFilterDRT(depTimeFilterData);
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
			
			console.log(craft);
              for (var i = 0; i < allData.length; i++) {
                    if (craft.indexOf(allData[i].craft) == -1) {
                        craftFilterData.push(allData[i].IndexNumber);
                    }
                }
                runFilterDRT(craftFilterData);
            break;
        default:

            break;
    }
    fiteredArray.push(flight);
    fiteredArray.push(Price);
    fiteredArray.push(Stop);
    fiteredArray.push(DepTime);
	fiteredArray.push(craft);
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
                        if (fiteredArray[4].indexOf(allData[i].craft)  === -1) {
                            flightFilterData.push(allData[i].IndexNumber);
                        } else {
                            removeA(flightFilterData, allData[i].IndexNumber)
                        }
                    }
                }
            }
        }
        runFilterDRT(flightFilterData);
    }
}

function PriceSortDRTO(val ='') {
	if(val == ''){
    var order_type = $('#pricesorting').val();
	}else{
		 var order_type = 'ascending';
	}
   // var order_type = $('#pricesorting').val();
    var $divs = $(".bingo_button_4"); // Each Div Class
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
            return $(a).find(".priced").text() - $(b).find(".priced").text();
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#pricesorting').val('descending');
		$('.pricesorta').show();
		$('.pricesortd').hide();
    }
    else
        if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return $(b).find(".priced").text() - $(a).find(".priced").text();
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#pricesorting').val('ascending');
			$('.pricesorta').hide();
			$('.pricesortd').show();
        }
}
function PriceSortDRTR(val = '') {
	if(val == ''){
    var order_type = $('#pricesorting1').val();
	}else{
		 var order_type = 'ascending';
	}
    //var order_type = $('#pricesorting1').val();
    var $divs1 = $(".bingo_button_41"); // Each Div Class
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs1 = $divs1.sort(function (a, b) {
            return $(a).find(".pricer").text() - $(b).find(".pricer").text();
        });
        $("#bingo_width1").html(alphabeticallyOrderedDivs1);
		$('#pricesorting1').val('descending');
		$('.pricesorta1').show();
		$('.pricesortd1').hide();
    }
    else
        if (order_type == 'descending') {
            var alphabeticallyOrderedDivs1 = $divs1.sort(function (a, b) {
                return $(b).find(".pricer").text() - $(a).find(".pricer").text();
            });
            $("#bingo_width1").html(alphabeticallyOrderedDivs1);
			$('#pricesorting1').val('ascending');
			$('.pricesorta1').hide();
			$('.pricesortd1').show();
        }
}

function DepartSortRoundOneWay() {
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
function DepartSortRoundIBWay() {
    var order_type = $('#ibairsorting').val();
    var $divs = $(".bingo_button_41");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".ibdepartdate").text().toUpperCase()) <  
                    ($(a).find(".ibdepartdate").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width1").html(alphabeticallyOrderedDivs);
		$('#ibairsorting').val('descending');
		$('.ibdepasorta').show();
		$('.ibdepasortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".ibdepartdate").text().toUpperCase()) >  
                    ($(a).find(".ibdepartdate").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width1").html(alphabeticallyOrderedDivs);
			$('#ibairsorting').val('ascending');
			$('.ibdepasorta').hide();
			$('.ibdepasortd').show();
        }
}

function AirlineSortRoundOneWay() {
    var order_type = $('#airsorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			
			 return ($(b).find(".obflight_name").text().toUpperCase()) <  
                    ($(a).find(".obflight_name").text().toUpperCase()) ? 1 : -1;  
        });
		
		
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#airsorting').val('descending');
		$('.airsorta').show();
		$('.airsortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".obflight_name").text().toUpperCase()) >  
                    ($(a).find(".obflight_name").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#airsorting').val('ascending');
			$('.airsorta').hide();
			$('.airsortd').show();
        }
}

function AirlineSortRoundIBWay() {
    var order_type = $('#ibairsorting').val();
    var $divs = $(".bingo_button_41");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			
			 return ($(b).find(".ibflight_name").text().toUpperCase()) <  
                    ($(a).find(".ibflight_name").text().toUpperCase()) ? 1 : -1;  
        });
		
		
        $("#bingo_width1").html(alphabeticallyOrderedDivs);
		$('#ibairsorting').val('descending');
		$('.ibairsorta').show();
		$('.ibairsortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".ibflight_name").text().toUpperCase()) >  
                    ($(a).find(".ibflight_name").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width1").html(alphabeticallyOrderedDivs);
			$('#ibairsorting').val('ascending');
			$('.ibairsorta').hide();
			$('.ibairsortd').show();
        }
}

function DurationSortRoundOneWay() {
    var order_type = $('#durasorting').val();
    var $divs = $(".bingo_button_4");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".departdur").text().toUpperCase()) <  
                    ($(a).find(".departdur").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width").html(alphabeticallyOrderedDivs);
		$('#durasorting').val('descending');
		$('.durasorta').show();
		$('.durasortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".departdur").text().toUpperCase()) >  
                    ($(a).find(".departdur").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width").html(alphabeticallyOrderedDivs);
			$('#durasorting').val('ascending');
			$('.durasorta').hide();
			$('.durasortd').show();
        }
}

function DurationSortRoundIBWay() {
    var order_type = $('#ibdurasorting').val();
    var $divs = $(".bingo_button_41");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".ibduration").text().toUpperCase()) <  
                    ($(a).find(".ibduration").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width1").html(alphabeticallyOrderedDivs);
		$('#ibdurasorting').val('descending');
		$('.ibdurasorta').show();
		$('.ibdurasortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".ibduration").text().toUpperCase()) >  
                    ($(a).find(".ibduration").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width1").html(alphabeticallyOrderedDivs);
			$('#ibdurasorting').val('ascending');
			$('.ibdurasorta').hide();
			$('.ibdurasortd').show();
        }
}
function ArriveSortRoundOneWay() {
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

function ArriveSortRoundIBWay() {
    var order_type = $('#ibarrivesorting').val();
    var $divs = $(".bingo_button_41");
    if (order_type == 'ascending') {
        var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
			 return ($(b).find(".arivedate").text().toUpperCase()) <  
                    ($(a).find(".arivedate").text().toUpperCase()) ? 1 : -1;  
        });
        $("#bingo_width1").html(alphabeticallyOrderedDivs);
		$('#ibarrivesorting').val('descending');
		$('.ibarriveasorta').show();
		$('.ibarrivesortd').hide();
    } 
    else if (order_type == 'descending') {
            var alphabeticallyOrderedDivs = $divs.sort(function (a, b) {
                return ($(b).find(".arivedate").text().toUpperCase()) >  
                    ($(a).find(".arivedate").text().toUpperCase()) ? 1 : -1;  
            });
            $("#bingo_width1").html(alphabeticallyOrderedDivs);
			$('#ibarrivesorting').val('ascending');
			$('.ibarriveasorta').hide();
			$('.ibarrivesortd').show();
        }
}

function ClearAllDRT() {
    $('.chboxAirline').prop("checked", false);
    $('.allshow').show();
	 $('.Stopfliter').prop("checked", false);
    min = $("#hdnMinCost0").val();
    max = $("#hdnMaxCost0").val();
  //  SetSlider(min, max);
    var w = document.getElementsByTagName('input');
    for (var i = 0; i < w.length; i++) {
        if (w[i].type == 'checkbox') {
            w[i].checked = false;
        }
    }
}
function BookingContinue() {
    var id = $('#hdftracid').val();
    var Inbound = $('#hdfInIndex').val();
    var OutBound = $('#hdfOutIndex').val();
    var totalamount = $('#totalamount').html();
    window.location.href = bookurl+"?tid=" + id + "&Index=" + Inbound + "&ADT=" + document.getElementById('hfAdult').value + "&CH=" + document.getElementById('hfChild').value + "&INF=" + document.getElementById('hfInfant').value + "&IsLcc=" + document.getElementById('IsLcc').value + "&IsLccR=" + document.getElementById('IsLccR').value + "&IndexR=" + OutBound + "&IsReturn=true&IsInt=False&price="+totalamount+"&IsInt=domestic";
}
function OutboundResullt(AirlineCode, AirlineName, FlightNo, DepTime, Dep, AirTime, To, TotalPrice, Indexnumber, IsLcc) {
    $('#IsLccR').val(IsLcc);
    $('#hdfOutIndex').val(Indexnumber);
    $("#OutboundFlight").empty();
    $("#hdfOuttotalAmt").val(TotalPrice);
    var InPrice = $("#hdfIntotalAmt").val();
    $('#totalamount').text((parseFloat(TotalPrice) + parseFloat(InPrice)));
     var sb = "<ul>" + 
        "         <li class=\"flight_txt\">" +
        "             <img class=\"hide_mob\" src=\""+airlineurl+"/" + AirlineCode + ".gif\" alt=\"" + AirlineName + "\">" +
        "             <div class=\"flight_name\">"+AirlineName+"<span class=\"flight_no\">"+AirlineCode+"-"+FlightNo+"</span></div>" +           
        "         </li>" +
		
        "         <li class=\"flight_duration hide_mob\">" +
        "             <div class=\"depart_time cus_time\"><span>" + DepTime + "</span>"+Dep+"</div>" +

        "         		<div class=\"arrow\">" +
        "            		 <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i>" +
        "         		</div>" +
        "         		 <div class=\"arrive_time cus_time\"><span>" + AirTime + "</span>"+To+"</div>" +
        "         </li>" +
        "         <li class=\"flight_price\">" +
        "             <i class=\"fa fa-rupee-sign\" aria-hidden=\"true\"></i>" + TotalPrice + " " +
        "         </li>" +

        " </ul>";
    $("#OutboundFlight").append(sb); 
} 
function InboundResullt(AirlineCode, AirlineName, FlightNo, DepTime, Dep, AirTime, To, TotalPrice, Indexnumber, IsLcc) {
    $('#IsLcc').val(IsLcc);
    $('#hdfInIndex').val(Indexnumber);
    $('#InboundFlight').empty();
    var OutPrice = $("#hdfOuttotalAmt").val();
    $("#hdfIntotalAmt").val(TotalPrice);
    $('#totalamount').text((parseFloat(TotalPrice) + parseFloat(OutPrice)));
    var Divs = "<ul>" +
        "         <li class=\"flight_txt\">" +
        "             <img class=\"hide_mob\" src=\""+airlineurl+"/" + AirlineCode + ".gif\" alt=\"" + AirlineName + "\">" +
        "             <div class=\"flight_name\">"+AirlineName+"<span class=\"flight_no\">"+AirlineCode+"-"+FlightNo+"</span></div>" +           
        "         </li>" + 
		
        "         <li class=\"flight_duration hide_mob\">" +
        "             <div class=\"depart_time cus_time\"><span>" + DepTime + "</span>"+Dep+"</div>" +

        "         		<div class=\"arrow\">" +
        "            		 <i class=\"fa fa-arrow-right\" aria-hidden=\"true\"></i>" +
        "         		</div>" +
        "         		 <div class=\"arrive_time cus_time\"><span>" + AirTime + "</span>"+To+"</div>" +
        "         </li>" +
        "         <li class=\"flight_price\">" +
        "             <i class=\"fa fa-rupee-sign\" aria-hidden=\"true\"></i>" + TotalPrice + " " +
        "         </li>" +

        " </ul>";
    $('#InboundFlight').append(Divs);
}