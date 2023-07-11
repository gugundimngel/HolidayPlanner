
/*============================== JavaScript function ======================================*/
var searchQuery = '';
var ChildAgeDetail = '';
var paxDetailRoomOne = '';
var paxDetailRoomTwo = '';
var paxDetailRoomThree = '';
var paxDetailRoomFour = '';
var totalPaxDetails = '';
var ReqTimeOfSearch = '';
var ResTimeOfSearch = '';
var totalAdultsCounts = 0;
var totalChildCounts = 0;
var numberOfAdultsRoom1 = 0;
var numberOfAdultsRoom2 = 0;
var numberOfAdultsRoom3 = 0;
var numberOfAdultsRoom4 = 0;
var numberOfChildrenRoom1 = 0;
var numberOfChildrenRoom2 = 0;
var numberOfChildrenRoom3 = 0;
var numberOfChildrenRoom4 = 0;
var _Fns = {};
function HotelSearch() {
    var Country = '';
    var City1 = '';
    var State = '';
    var city = document.getElementById('txtCity').value;
    //if (jQuery("#txtCity").validationEngine('validate')) {
       // return false;
    //}
    if (city.match(',')) {
        //do nothing
    }
    else {

    }
    if (city == '') {
        alert('Please select city location name');
        return false;
    }
    var checkInDate = document.getElementById('txtCheckInDate').value;
    var checkOutDate = document.getElementById('txtCheckOutDate').value;
    if (checkOutDate == "" || checkOutDate == "") {
        alert("kindly select checkin and checkout date");
        return false;
    }

    if (checkInDate == checkOutDate) {
        alert("checkin and checkout cannot be same");
        return false;
    } 
    var noofroom = $("#hdnroom").val();
    var numberOfRooms = noofroom; //$("#rooms option:selected").val();
    var totalPaxDetails = "";
    var totaladults = 0;
    var totalchild = 0;
    for (var i = 1; i <= noofroom; i++) {
        totalPaxDetails += $("#Adults_room_" + i + "_" + i + "").text();
		totaladults += parseInt($("#Adults_room_" + i + "_" + i + "").text());
		totalchild += parseInt($("#Children_room_" + i + "_" + i + "").text());
        if (parseInt($("#Children_room_" + i + "_" + i + "").text()) == "1") {
            totalPaxDetails += "_1_" + $("#Child_Age_" + i + "_1").val() + "";
			
        }
        else if (parseInt($("#Children_room_" + i + "_" + i + "").text()) == "2") {
            totalPaxDetails += "_2_" + $("#Child_Age_" + i + "_1").val() + "_";
            totalPaxDetails += "" + $("#Child_Age_" + i + "_2").val() + "";
        }
        totalPaxDetails += "?";
    }
    totalPaxDetails = totalPaxDetails.slice(0, -1);
    var days = calcDays(checkInDate, checkOutDate);
    var splitDate1 = checkInDate.split('/');
    var splitDate2 = checkOutDate.split('/');
    var date1 = new Date(splitDate1[2], splitDate1[1], splitDate1[0]);
    var date2 = new Date(splitDate2[2], splitDate2[1], splitDate2[0]);
    var checkInMonth = splitDate1[1];
    var checkOutMonth = splitDate2[1];
    if (checkInMonth < checkOutMonth) { 
        var numberOfdays = days;  //Math.floor((date2.getTime() - date1.getTime()) / (1000 * 60 * 60 * 24)) + 1;
    }
    else {
        var numberOfdays = Math.floor((date2.getTime() - date1.getTime()) / (1000 * 60 * 60 * 24));
    }
    if (numberOfdays > 26) {
        alert("please choose valid nights");
        return false;
    }
    // var queryString = numberOfRooms + "_" + numberOfAdultsRoom1 + "_" + numberOfAdultsRoom2 + "_" + numberOfAdultsRoom3 + "_" + numberOfAdultsRoom4 + "_" + numberOfChildrenRoom1 + "_" + numberOfChildrenRoom2 + "_" + numberOfChildrenRoom3 + "_" + numberOfChildrenRoom4 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2 + "_" + childAgeRoom1Child3 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2 + "_" + childAgeRoom2Child3 + "_" + childAgeRoom3Child1 + "_" + childAgeRoom3Child2 + "_" + childAgeRoom3Child3 + "_" + childAgeRoom4Child1 + "_" + childAgeRoom4Child2 + "_" + childAgeRoom4Child3;
    if (document.getElementById("imgLoad") != null) {
        document.getElementById("imgLoad").style.display = "block";
        document.getElementById("btnDiv").style.display = "none";
    }
    var _hotelString = "&city=" + city + "&cin=" + checkInDate + "&cOut=" + checkOutDate + "&Hotel=NA&Rooms=" + numberOfRooms + "&pax=" + totalPaxDetails;
    var Coupon = '';
    Coupon = window.location.search;
    var response = Math.floor((Math.random() * 100) + 1);
    var dddd = new Date();

    response = dddd.getFullYear() + "" + (dddd.getMonth() + 1) + "" + dddd.getDate() + "" + dddd.getHours() + "" + dddd.getMinutes() + "" + dddd.getSeconds();
var hdnHotelTypeSearch =$("#"+hdnHotelTypeSearch).val();
var hdnHotelTypeSearch=$("#hdnHotelTypeSearch").val();
if(hdnHotelTypeSearch!=null && hdnHotelTypeSearch!='' && hdnHotelTypeSearch.split('|')[1]=="Hotel")
{
	_hotelString +="&emtid="+ hdnHotelTypeSearch.split('|')[0];
}
var _user=getParameterByName("user")
if(_user!=null && _user!="")
{
	_hotelString +="&user=" +_user;
	
} 
var nationality = $('#nationality option:selected').val();
	_hotelString +="&nationality="+nationality;
	 var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
  'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var splitdate = checkInDate.split('/');
	var splitdateout = checkOutDate.split('/');
	$('.searchpop1').show();
	$('.searchpop1 .wait-txe h3 span').html(city);
	$('.searchpop1 .wait_hotel_info .waitroomcount').html(numberOfRooms+' Rooms');
	$('.searchpop1 .wait_hotel_info .waitadultcount').html(totaladults+' Adult');
	$('.searchpop1 .wait_hotel_info .waitchildcount').html(totalchild+' Child');
	$('.searchpop1 .hotel_wait_main .checkinda').html(splitdate[0]+'<span>'+months[splitdate[1]-1]+'<br/>'+splitdate[2]+'</span>');
	$('.searchpop1 .hotel_wait_main .checkoutda').html(splitdateout[0]+'<span>'+months[splitdateout[1]-1]+'<br/>'+splitdateout[2]+'</span>');
    location.href = site_url+"/Hotel/HotelListing?e=" + response + _hotelString; //"&SearchQuery=" + searchQuery + "&NumberOfPax=" + totalPaxDetails;
    //  }

}

function ProductDescriptionSingle(e, hotelID, commonID, Engine) {
    window.location.href = '/Hotel/HotelDescription?' + e + "&commonID=" + commonID;
}

    function getParameterByName(name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(location.search);
        if (name == "cOut")
            return results === null ? "" : decodeURIComponent(results[1]).split(' ')[0];// decodeURIComponent(results[1].replace(/\+/g, " "));
        else
            return results === null ? "" : decodeURIComponent(results[1]);
    }

function getSearchRQ(data) {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "/Hotel/HotelLogs",
        data: JSON.stringify(data),
        success: function (response) {
            //if (response != null && response.d == 'OK') {
            //    window.location.href = 'HotelListing.aspx?queryString=' + queryString;
            //}
        },
        beforeSend: function (XMLHttpRequest) {

        },
        error: function (xmlHttpRequest, status, err) {
        }
    });
}

function GetDestination(city, cityCountryMergeValue) {
    var queryString = $("#hiddenQueryString").val();
    var mergedResult = city + "," + cityCountryMergeValue;
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "../HotelService.asmx/UncompleteCitySearchHotel",
        data: "{'cityCoutryString':'" + mergedResult + "'}",
        success: function (response) {
            if (response != null && response.d == 'OK') {
                window.location.href = 'HotelListing.aspx?queryString=' + queryString;
            }
        },
        beforeSend: function (XMLHttpRequest) {
        },
        error: function (xmlHttpRequest, status, err) {
        }
    });
}
function GetValueForPopUp(hotelId, EngineID, hotelName, price, hotelImage, starRating, tripRatting) {
    if (document.getElementById('repHotelDetail_ctl00_txtcheckInDate1').value != '') {
        document.getElementById('repHotelDetail_ctl00_txtcheckInDate1').value = ''
    }
    if (document.getElementById('repHotelDetail_ctl00_txtcheckOutDate1').value != '') {
        document.getElementById('repHotelDetail_ctl00_txtcheckOutDate1').value = ''
    }
    document.getElementById('hdnhotelId').value = hotelId;
    document.getElementById('hdnHotelName').value = hotelName;
    document.getElementById('hdnEngineID').value = EngineID;
    document.getElementById('hdnAvgRate').value = price;
    document.getElementById('hdnThumbnailUrl').value = hotelImage;
    document.getElementById('hdnHotelRating').value = starRating;
    document.getElementById('hdnTripRatingUrl').value = tripRatting;

    SetPopUpValue();
}

function SetPopUpValue() {

    document.getElementById('roomdl').value = document.getElementById('rooms').value;
    document.getElementById('room1Adultsdl').value = document.getElementById('room1Adults').value;
    document.getElementById('room2Adultsdl').value = document.getElementById('room2Adults').value;
    document.getElementById('room3Adultsdl').value = document.getElementById('room3Adults').value;
    document.getElementById('room4Adultsdl').value = document.getElementById('room4Adults').value;
    document.getElementById('room1Childrendl').value = document.getElementById('room1Children').value;
    document.getElementById('room2Childrendl').value = document.getElementById('room2Children').value;
    document.getElementById('room3Childrendl').value = document.getElementById('room3Children').value;
    document.getElementById('room4Childrendl').value = document.getElementById('room4Children').value;
    document.getElementById('optRoom1ChildAge1dl').value = document.getElementById('optRoom1ChildAge1').value;
    document.getElementById('optRoom1ChildAge2dl').value = document.getElementById('optRoom1ChildAge2').value;
    document.getElementById('optRoom1ChildAge3dl').value = document.getElementById('optRoom1ChildAge3').value;
    document.getElementById('optRoom2ChildAge1dl').value = document.getElementById('optRoom2ChildAge1').value;
    document.getElementById('optRoom2ChildAge2dl').value = document.getElementById('optRoom2ChildAge2').value;
    document.getElementById('optRoom2ChildAge3dl').value = document.getElementById('optRoom2ChildAge3').value;
    document.getElementById('optRoom3ChildAge1dl').value = document.getElementById('optRoom3ChildAge1').value;
    document.getElementById('optRoom3ChildAge2dl').value = document.getElementById('optRoom3ChildAge2').value;
    document.getElementById('optRoom3ChildAge3dl').value = document.getElementById('optRoom3ChildAge3').value;
    document.getElementById('optRoom4ChildAge1dl').value = document.getElementById('optRoom4ChildAge1').value;
    document.getElementById('optRoom4ChildAge2dl').value = document.getElementById('optRoom4ChildAge2').value;
    document.getElementById('optRoom4ChildAge3dl').value = document.getElementById('optRoom4ChildAge3').value;
    var getvalue = document.getElementById('rooms').value;
    var getchildvalue1 = document.getElementById('room1Children').value;
    var getchildvalue2 = document.getElementById('room2Children').value;
    var getchildvalue3 = document.getElementById('room3Children').value;
    var getchildvalue4 = document.getElementById('room4Children').value;

    if (getvalue == 1) {

        document.getElementById('divRoom2dl').style.display = 'none';
        document.getElementById('divRoom3dl').style.display = 'none';
        document.getElementById('divRoom4dl').style.display = 'none';
    }
    if (getvalue == 2) {
        document.getElementById('divRoom2dl').style.display = 'block';
        document.getElementById('divRoom3dl').style.display = 'none';
        document.getElementById('divRoom4dl').style.display = 'none';
    }
    if (getvalue == 3) {
        document.getElementById('divRoom2dl').style.display = 'block';
        document.getElementById('divRoom3dl').style.display = 'block';
        document.getElementById('divRoom4dl').style.display = 'none';
    }
    if (getvalue == 4) {
        document.getElementById('divRoom2dl').style.display = 'block';
        document.getElementById('divRoom3dl').style.display = 'block';
        document.getElementById('divRoom4dl').style.display = 'block';
    }
    if (getchildvalue1 == 0) {
        document.getElementById('divChildAge1dl').style.display = 'none';
        document.getElementById('divChildAge2dl').style.display = 'none';
        document.getElementById('divChildAge3dl').style.display = 'none';
    }
    if (getchildvalue1 == 1) {
        document.getElementById('divChildAge1dl').style.display = 'block';
        document.getElementById('divChildAge2dl').style.display = 'none';
        document.getElementById('divChildAge3dl').style.display = 'none';
    }
    if (getchildvalue1 == 2) {
        document.getElementById('divChildAge1dl').style.display = 'block';
        document.getElementById('divChildAge2dl').style.display = 'block';
        document.getElementById('divChildAge3dl').style.display = 'none';
    }
    if (getchildvalue1 == 3) {
        document.getElementById('divChildAge1dl').style.display = 'block';
        document.getElementById('divChildAge2dl').style.display = 'block';
        document.getElementById('divChildAge3dl').style.display = 'block';
    }
    if (getchildvalue2 == 0) {
        document.getElementById('divChildAge11dl').style.display = 'none';
        document.getElementById('divChildAge12dl').style.display = 'none';
        document.getElementById('divChildAge13dl').style.display = 'none';
    }
    if (getchildvalue2 == 1) {
        document.getElementById('divChildAge11dl').style.display = 'block';
        document.getElementById('divChildAge12dl').style.display = 'none';
        document.getElementById('divChildAge13dl').style.display = 'none';
    }
    if (getchildvalue2 == 2) {
        document.getElementById('divChildAge11dl').style.display = 'block';
        document.getElementById('divChildAge12dl').style.display = 'block';
        document.getElementById('divChildAge13dl').style.display = 'none';
    }
    if (getchildvalue2 == 3) {
        document.getElementById('divChildAge11dl').style.display = 'block';
        document.getElementById('divChildAge12dl').style.display = 'block';
        document.getElementById('divChildAge13dl').style.display = 'block';
    }
    if (getchildvalue3 == 0) {
        document.getElementById('divChildAge21dl').style.display = 'none';
        document.getElementById('divChildAge22dl').style.display = 'none';
        document.getElementById('divChildAge23dl').style.display = 'none';
    }

    if (getchildvalue3 == 1) {
        document.getElementById('divChildAge21dl').style.display = 'block';
        document.getElementById('divChildAge22dl').style.display = 'none';
        document.getElementById('divChildAge23dl').style.display = 'none';
    }
    if (getchildvalue3 == 2) {
        document.getElementById('divChildAge21dl').style.display = 'block';
        document.getElementById('divChildAge22dl').style.display = 'block';
        document.getElementById('divChildAge23dl').style.display = 'none';
    }
    if (getchildvalue3 == 3) {
        document.getElementById('divChildAge21dl').style.display = 'block';
        document.getElementById('divChildAge22dl').style.display = 'block';
        document.getElementById('divChildAge23dl').style.display = 'block';
    }
    if (getchildvalue4 == 0) {
        document.getElementById('divChildAge31dl').style.display = 'none';
        document.getElementById('divChildAge32dl').style.display = 'none';
        document.getElementById('divChildAge33dl').style.display = 'none';
    }
    if (getchildvalue4 == 1) {
        document.getElementById('divChildAge31dl').style.display = 'block';
        document.getElementById('divChildAge32dl').style.display = 'none';
        document.getElementById('divChildAge33dl').style.display = 'none';
    }
    if (getchildvalue4 == 2) {
        document.getElementById('divChildAge31dl').style.display = 'block';
        document.getElementById('divChildAge32dl').style.display = 'block';
        document.getElementById('divChildAge33dl').style.display = 'none';
    }
    if (getchildvalue4 == 3) {
        document.getElementById('divChildAge31dl').style.display = 'block';
        document.getElementById('divChildAge32dl').style.display = 'block';
        document.getElementById('divChildAge33dl').style.display = 'block';
    }
}
function ConvertToUpperCaseTextBoxValue(Key) {
    var character = Key.value;
    Key.value = character.toUpperCase();
}
function GetDatesForProductDetails() {
    var totalPaxDetails = '';
    var checkIn = document.getElementById('repHotelDetail_ctl00_txtcheckInDate1').value;
    var checkOut = document.getElementById('repHotelDetail_ctl00_txtcheckOutDate1').value;
    var hotelId = document.getElementById('hdnhotelId').value;
    var hotelName = document.getElementById('hdnHotelName').value;
    var price = document.getElementById('hdnAvgRate').value;
    var hotelImage = document.getElementById('hdnThumbnailUrl').value;
    var starRating = document.getElementById('hdnHotelRating').value;
    var tripRatting = document.getElementById('hdnTripRatingUrl').value;
    var numberOfRooms = $("#roomdl option:selected").val();
    var numberOfAdultsRoom1 = $("#room1Adultsdl option:selected").val();
    var numberOfAdultsRoom2 = $("#room2Adultsdl option:selected").val();
    var numberOfAdultsRoom3 = $("#room3Adultsdl option:selected").val();
    var numberOfAdultsRoom4 = $("#room4Adultsdl option:selected").val();
    var numberOfChildrenRoom1 = $("#room1Childrendl option:selected").val();
    var numberOfChildrenRoom2 = $("#room2Childrendl option:selected").val();
    var numberOfChildrenRoom3 = $("#room3Childrendl option:selected").val();
    var numberOfChildrenRoom4 = $("#room4Childrendl option:selected").val();
    var childAgeRoom1Child1 = $("#optRoom1ChildAge1dl option:selected").val();
    var childAgeRoom1Child2 = $("#optRoom1ChildAge2dl option:selected").val();
    var childAgeRoom1Child3 = $("#optRoom1ChildAge3dl option:selected").val();
    var childAgeRoom2Child1 = $("#optRoom2ChildAge1dl option:selected").val();
    var childAgeRoom2Child2 = $("#optRoom2ChildAge2dl option:selected").val();
    var childAgeRoom2Child3 = $("#optRoom2ChildAge3dl option:selected").val();
    var childAgeRoom3Child1 = $("#optRoom3ChildAge1dl option:selected").val();
    var childAgeRoom3Child2 = $("#optRoom3ChildAge2dl option:selected").val();
    var childAgeRoom3Child3 = $("#optRoom3ChildAge3dl option:selected").val();
    var childAgeRoom4Child1 = $("#optRoom4ChildAge1dl option:selected").val();
    var childAgeRoom4Child2 = $("#optRoom4ChildAge2dl option:selected").val();
    var childAgeRoom4Child3 = $("#optRoom4ChildAge3dl option:selected").val();
    if (checkIn == '') {
        alert('Please enter check in date');
        return false;
    }
    if (checkOut == '') {
        alert('Please enter check out date');
        return false;
    }
    if (checkOut == '') {
        alert('Please enter check out date');
        return false;
    }
    if (numberOfRooms == 1) {
        if (numberOfChildrenRoom1 == 1) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 2) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 3) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom1Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }
    }
    if (numberOfRooms == 2) {
        if (numberOfChildrenRoom1 == 1) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 2) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 3) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom1Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 1) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 2) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 3) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom2Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }
    }
    if (numberOfRooms == 3) {

        if (numberOfChildrenRoom1 == 1) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 2) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 3) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom1Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }





        if (numberOfChildrenRoom2 == 1) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 2) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 3) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom2Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }







        if (numberOfChildrenRoom3 == 1) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom3 == 2) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom3Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom3 == 3) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom3Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom3Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }

    }
    if (numberOfRooms == 4) {

        if (numberOfChildrenRoom1 == 1) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 2) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom1 == 3) {
            if (childAgeRoom1Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom1Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom1Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }





        if (numberOfChildrenRoom2 == 1) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 2) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom2 == 3) {
            if (childAgeRoom2Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom2Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom2Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }







        if (numberOfChildrenRoom3 == 1) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom3 == 2) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom3Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom3 == 3) {
            if (childAgeRoom3Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom3Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom3Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }






        if (numberOfChildrenRoom4 == 1) {

            if (childAgeRoom4Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
        }
        if (numberOfChildrenRoom4 == 2) {
            if (childAgeRoom4Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom4Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
        }
        if (numberOfChildrenRoom4 == 3) {
            if (childAgeRoom4Child1 == 0) {
                alert("Please select child 1 age");
                return false;

            }
            if (childAgeRoom4Child2 == 0) {
                alert("Please select child 2 age");
                return false;

            }
            if (childAgeRoom4Child3 == 0) {
                alert("Please select child 3 age");
                return false;

            }
        }
    }

    if (numberOfRooms == 1) {
        if (numberOfChildrenRoom1 == 0) {
            paxDetailRoomOne = numberOfAdultsRoom1;
        }
        if (numberOfChildrenRoom1 == 1) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1;
        }
        if (numberOfChildrenRoom1 == 2) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2;
        }
        if (numberOfChildrenRoom1 == 3) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2 + "_" + childAgeRoom1Child3;
        }
        totalPaxDetails = paxDetailRoomOne;
    }
    if (numberOfRooms == 2) {
        if (numberOfChildrenRoom1 == 0) {
            paxDetailRoomOne = numberOfAdultsRoom1;
        }
        if (numberOfChildrenRoom1 == 1) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1;
        }
        if (numberOfChildrenRoom1 == 2) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2;
        }
        if (numberOfChildrenRoom1 == 3) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2 + "_" + childAgeRoom1Child3;
        }
        if (numberOfChildrenRoom2 == 0) {
            paxDetailRoomTwo = numberOfAdultsRoom2;
        }
        if (numberOfChildrenRoom2 == 1) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1;
        }
        if (numberOfChildrenRoom2 == 2) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2;
        }
        if (numberOfChildrenRoom2 == 3) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2 + "_" + childAgeRoom2Child3;
        }
        totalPaxDetails = paxDetailRoomOne + "?" + paxDetailRoomTwo;
    }
    if (numberOfRooms == 3) {
        if (numberOfChildrenRoom1 == 0) {
            paxDetailRoomOne = numberOfAdultsRoom1;
        }
        if (numberOfChildrenRoom1 == 1) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1;
        }
        if (numberOfChildrenRoom1 == 2) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2;
        }
        if (numberOfChildrenRoom1 == 3) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2 + "_" + childAgeRoom1Child3;
        }
        if (numberOfChildrenRoom2 == 0) {
            paxDetailRoomTwo = numberOfAdultsRoom2;
        }
        if (numberOfChildrenRoom2 == 1) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1;
        }
        if (numberOfChildrenRoom2 == 2) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2;
        }
        if (numberOfChildrenRoom2 == 3) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2 + "|" + childAgeRoom2Child3;
        }
        if (numberOfChildrenRoom3 == 0) {
            paxDetailRoomThree = numberOfAdultsRoom3;
        }
        if (numberOfChildrenRoom3 == 1) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1;
        }
        if (numberOfChildrenRoom3 == 2) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1 + "_" + childAgeRoom3Child2;
        }
        if (numberOfChildrenRoom3 == 3) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1 + "_" + childAgeRoom3Child2 + "_" + childAgeRoom3Child3;
        }
        totalPaxDetails = paxDetailRoomOne + "?" + paxDetailRoomTwo + "?" + paxDetailRoomThree;
    }

    if (numberOfRooms == 4) {
        if (numberOfChildrenRoom1 == 0) {
            paxDetailRoomOne = numberOfAdultsRoom1;
        }
        if (numberOfChildrenRoom1 == 1) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1;
        }
        if (numberOfChildrenRoom1 == 2) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2;
        }
        if (numberOfChildrenRoom1 == 3) {
            paxDetailRoomOne = numberOfAdultsRoom1 + "_" + numberOfChildrenRoom1 + "_" + childAgeRoom1Child1 + "_" + childAgeRoom1Child2 + "_" + childAgeRoom1Child3;
        }
        if (numberOfChildrenRoom2 == 0) {
            paxDetailRoomTwo = numberOfAdultsRoom2;
        }
        if (numberOfChildrenRoom2 == 1) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1;
        }
        if (numberOfChildrenRoom2 == 2) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2;
        }
        if (numberOfChildrenRoom2 == 3) {
            paxDetailRoomTwo = numberOfAdultsRoom2 + "_" + numberOfChildrenRoom2 + "_" + childAgeRoom2Child1 + "_" + childAgeRoom2Child2 + "_" + childAgeRoom2Child3;
        }
        if (numberOfChildrenRoom3 == 0) {
            paxDetailRoomThree = numberOfAdultsRoom3;
        }
        if (numberOfChildrenRoom3 == 1) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1;
        }
        if (numberOfChildrenRoom3 == 2) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1 + "_" + childAgeRoom3Child2;
        }
        if (numberOfChildrenRoom3 == 3) {
            paxDetailRoomThree = numberOfAdultsRoom3 + "_" + numberOfChildrenRoom3 + "_" + childAgeRoom3Child1 + "_" + childAgeRoom3Child2 + "_" + childAgeRoom3Child3;
        }
        if (numberOfChildrenRoom4 == 0) {
            paxDetailRoomFour = numberOfAdultsRoom4;
        }
        if (numberOfChildrenRoom4 == 1) {
            paxDetailRoomFour = numberOfAdultsRoom4 + "_" + numberOfChildrenRoom4 + "_" + childAgeRoom4Child1;
        }
        if (numberOfChildrenRoom4 == 2) {
            paxDetailRoomFour = numberOfAdultsRoom4 + "_" + numberOfChildrenRoom4 + "_" + childAgeRoom4Child1 + "_" + childAgeRoom4Child2;
        }
        if (numberOfChildrenRoom4 == 3) {
            paxDetailRoomFour = numberOfAdultsRoom4 + "_" + numberOfChildrenRoom4 + "_" + childAgeRoom4Child1 + "_" + childAgeRoom4Child2 + "_" + childAgeRoom4Child3;
        }
        totalPaxDetails = paxDetailRoomOne + "?" + paxDetailRoomTwo + "?" + paxDetailRoomThree + "?" + paxDetailRoomFour;
    }
    ProductDetailDateLess(hotelId, hotelName, price, hotelImage, starRating, tripRatting, checkIn, checkOut, numberOfRooms, totalPaxDetails);
}
function ValidateModifyDate(checkin, checkout) {
    var validator = true;
    if (checkin == '') {
        alert("Check-in date cannot be blank");
        validator = false;
    }
    if (checkout == '' && validate != false) {
        alert("Check-out date cannot be blank");
        validator = false;
    }
    if (checkin != '' && checkout != '' && validator != false) {
        var checkinSplitter = checkin.split("/");
        var checkoutSplitter = checkout.split("/");
        var checkoutDay = checkoutSplitter[0];
        var checkoutMonth = checkoutSplitter[1];
        var checkoutYear = checkoutSplitter[2];
        var checkinDay = checkinSplitter[0];
        var checkinMonth = checkinSplitter[1];
        var checkinYear = checkinSplitter[2];
        if (checkinYear > checkoutYear) {
            alert("Check-out date cannot be before check-in date");
            validator = false;
        }
        else if (checkinYear == checkoutYear) {
            if (checkinMonth > checkoutMonth) {
                alert("Check-out date cannot be before check-in date");
                validator = false;
            }
            else if (checkinMonth == checkoutMonth) {
                if (checkinDay > checkoutDay) {
                    alert("Check-out cannot be before check-in date");
                    validator = false;
                }
            }
        }
    }
}

function calcDays(dateStart, dateEnd) {
    var date1 = dateStart;
    var date2 = dateEnd;
    date1 = date1.split("/");
    date2 = date2.split("/");
    var sDate = new Date(date1[1] + "/" + date1[0] + "/" + date1[2]);
    var eDate = new Date(date2[1] + "/" + date2[0] + "/" + date2[2]);
    var daysApart = Math.abs(Math.round((sDate - eDate) / 86400000));
    return daysApart;
}

function DelayToHideLoader(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}
function HotelSearchResult(queryString) {
    $.ajax({
        type: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "../HotelService.asmx/HotelSearchResult",
        data: "{}",
        success: function (response) {
            if (response != null && response.d == 'OK') {
                window.location.href = 'HotelListing.aspx?' + queryString;
            }
        },
        beforeSend: function (XMLHttpRequest) {

        },
        error: function (xmlHttpRequest, status, err) {
        }
    });
}


function DefaultDate() {
    var currentDate = new Date();
    var date = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    if (date < 10)
        date = "0" + date;
    if (month < 10)
        month = "0" + month;
    currentDate = date + "/" + month + "/" + year;
    var datepicker = document.getElementById('txtCheckInDate').value = currentDate;
    var ddmmyyyy = datepicker.split("/");
    var checkindate = new Date(parseInt(ddmmyyyy[2], 10), parseInt(ddmmyyyy[1], 10) - 1, parseInt(ddmmyyyy[0], 10));
    checkindate.setDate(checkindate.getDate() + 1);
    document.getElementById('txtCheckOutDate').value = (("0" + checkindate.getDate()).slice(-2) + "/" + ("0" + (checkindate.getMonth() + 1)).slice(-2) + "/" + checkindate.getFullYear());
}
function CheckInDatePlusOneDateLess() {
    var datepicker = document.getElementById('repHotelDetail_ctl00_txtcheckInDate1').value;
    if (datepicker.length != 0) {
        var ddmmyyyy = datepicker.split("/");
        var checkindate = new Date(parseInt(ddmmyyyy[2], 10), parseInt(ddmmyyyy[1], 10) - 1, parseInt(ddmmyyyy[0], 10));
        checkindate.setDate(checkindate.getDate() + 1);
        document.getElementById('repHotelDetail_ctl00_txtcheckOutDate1').value = (("0" + checkindate.getDate()).slice(-2) + "/" + ("0" + (checkindate.getMonth() + 1)).slice(-2) + "/" + checkindate.getFullYear());
    }
}

function CheckInDatePlusOne() {
    var datepicker = document.getElementById('txtCheckInDate').value;
    if (datepicker.length != 0) {
        var ddmmyyyy = datepicker.split("/");
        var checkindate = new Date(parseInt(ddmmyyyy[2], 10), parseInt(ddmmyyyy[1], 10) - 1, parseInt(ddmmyyyy[0], 10));
        checkindate.setDate(checkindate.getDate() + 1);
        document.getElementById('txtCheckOutDate').value = (("0" + checkindate.getDate()).slice(-2) + "/" + ("0" + (checkindate.getMonth() + 1)).slice(-2) + "/" + checkindate.getFullYear());
    }
}
function ValidateDateDateLess() {
    var checkInDate = document.getElementById('repHotelDetail_ctl00_txtcheckInDate1').value;
    var checkOutDate = document.getElementById('repHotelDetail_ctl00_txtcheckOutDate1').value;
    var regExp = /(\d{1,2})\/(\d{1,2})\/(\d{2,4})/;
    if (parseInt(checkInDate.replace(regExp, "$3$2$1")) > parseInt(checkOutDate.replace(regExp, "$3$2$1"))) {
        alert("Check out date can't be less then check in date");
        CheckInDatePlusOneDateLess();
    }
}

function DynamicControl(element) {
    var child1 = document.getElementById('room1Children').value;
    var child2 = '0';

    child2 = document.getElementById('room2Children').value;
    var child3 = '0';

    child3 = document.getElementById('room3Children').value;
    var child4 = '0'

    child4 = document.getElementById('room4Children').value;

    if (child1 == null || child1 == "") {
        document.getElementById('room1Children').value = 0;
        document.getElementById('room1Adults').value = 2;

    }
    if (child2 == null || child2 == "") {
        document.getElementById('room2Children').value = 0;
        document.getElementById('room2Adults').value = 2;
    }
    if (child3 == null || child3 == "") {
        document.getElementById('room3Children').value = 0;
        document.getElementById('room3Adults').value = 2;

    }
    if (child4 == null || child4 == "") {
        document.getElementById('room4Children').value = 0;
        document.getElementById('room4Adults').value = 2;

    }
    if (element == 1) {
        document.getElementById("divRoom2").style.display = 'none';
        document.getElementById("divRoom3").style.display = 'none';
        document.getElementById("divRoom4").style.display = 'none';




        ChildAge(child1);

        ChildAge1(child2);

        ChildAge2(child3);

        ChildAge3(child4);

    }
    else if (element == 2) {

        document.getElementById("divRoom2").style.display = 'block';
        document.getElementById("divRoom3").style.display = 'none';
        document.getElementById("divRoom4").style.display = 'none';



        ChildAge(child1);

        ChildAge1(child2);

        ChildAge2(child3);

        ChildAge3(child4);

    }
    else if (element == 3) {
        document.getElementById("divRoom2").style.display = 'block';
        document.getElementById("divRoom3").style.display = 'block';
        document.getElementById("divRoom4").style.display = 'none';



        ChildAge(child1);

        ChildAge1(child2);

        ChildAge2(child3);

        ChildAge3(child4);
    }
    else if (element == 4) {
        document.getElementById("divRoom2").style.display = 'block';
        document.getElementById("divRoom3").style.display = 'block';
        document.getElementById("divRoom4").style.display = 'block';

        ChildAge(child1);

        ChildAge1(child2);

        ChildAge2(child3);

        ChildAge3(child4);
    }
}

function countGuest() {
    try {
        var countChild = 0;
        var countAdult = 0;
        for (var roomcounter = 1; roomcounter < 5; roomcounter++) {
            if (document.getElementById("divRoom" + roomcounter).style.display == "block") {
                countAdult += parseInt(document.getElementById("room" + roomcounter + "Adults").value);
                countChild += parseInt(document.getElementById("room" + roomcounter + "Children").value);
            }
        }
        var totalroom = parseInt(document.getElementById("rooms").value);
        var totalguest = parseInt(countChild) + parseInt(countAdult);
        if (document.getElementById("guestcount") != null)
            document.getElementById("guestcount").value = totalguest + " Person in " + totalroom + " Room";
    }
    catch (e) { }

}
function GetItemOnAdult1(element) {

    var child = document.getElementById('room1Children');
    var item = null;
    if (element == 1) {
        document.getElementById("divChildAge1").style.display = 'none';
        document.getElementById("divChildAge2").style.display = 'none';
        document.getElementById("divChildAge3").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 4; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    if (element == 2) {
        document.getElementById("divChildAge1").style.display = 'none';
        document.getElementById("divChildAge2").style.display = 'none';
        document.getElementById("divChildAge3").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 3; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 3) {
        document.getElementById("divChildAge1").style.display = 'none';
        document.getElementById("divChildAge2").style.display = 'none';
        document.getElementById("divChildAge3").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 2; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 4) {
        document.getElementById("divChildAge1").style.display = 'none';
        document.getElementById("divChildAge2").style.display = 'none';
        document.getElementById("divChildAge3").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 1; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    countGuest();
}
function GetItemOnAdult2(element) {
    var child = document.getElementById('room2Children');
    if (element == 1) {
        document.getElementById("divChildAge11").style.display = 'none';
        document.getElementById("divChildAge12").style.display = 'none';
        document.getElementById("divChildAge13").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 4; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    if (element == 2) {
        document.getElementById("divChildAge11").style.display = 'none';
        document.getElementById("divChildAge12").style.display = 'none';
        document.getElementById("divChildAge13").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 3; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 3) {
        document.getElementById("divChildAge11").style.display = 'none';
        document.getElementById("divChildAge12").style.display = 'none';
        document.getElementById("divChildAge13").style.display = 'none';

        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 2; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 4) {
        document.getElementById("divChildAge11").style.display = 'none';
        document.getElementById("divChildAge12").style.display = 'none';
        document.getElementById("divChildAge13").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 1; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    countGuest();
}
function GetItemOnAdult3(element) {
    var child = document.getElementById('room3Children');
    if (element == 1) {
        document.getElementById("divChildAge21").style.display = 'none';
        document.getElementById("divChildAge22").style.display = 'none';
        document.getElementById("divChildAge23").style.display = 'none';

        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 4; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    if (element == 2) {
        document.getElementById("divChildAge21").style.display = 'none';
        document.getElementById("divChildAge22").style.display = 'none';
        document.getElementById("divChildAge23").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 3; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 3) {
        document.getElementById("divChildAge21").style.display = 'none';
        document.getElementById("divChildAge22").style.display = 'none';
        document.getElementById("divChildAge23").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 2; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 4) {
        document.getElementById("divChildAge21").style.display = 'none';
        document.getElementById("divChildAge22").style.display = 'none';
        document.getElementById("divChildAge23").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 1; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    countGuest();
}
function GetItemOnAdult4(element) {
    var child = document.getElementById('room4Children');
    if (element == 1) {
        document.getElementById("divChildAge31").style.display = 'none';
        document.getElementById("divChildAge32").style.display = 'none';
        document.getElementById("divChildAge33").style.display = 'none';

        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 4; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    if (element == 2) {
        document.getElementById("divChildAge31").style.display = 'none';
        document.getElementById("divChildAge32").style.display = 'none';
        document.getElementById("divChildAge33").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 3; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 3) {
        document.getElementById("divChildAge31").style.display = 'none';
        document.getElementById("divChildAge32").style.display = 'none';
        document.getElementById("divChildAge33").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 2; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    else if (element == 4) {
        document.getElementById("divChildAge31").style.display = 'none';
        document.getElementById("divChildAge32").style.display = 'none';
        document.getElementById("divChildAge33").style.display = 'none';
        if (child.options.length > 0) {
            child.options.length = 0;
        }
        for (var i = 0; i < 1; i++) {
            item = document.createElement('option')
            child.options.add(item);
            item.innerHTML = i;
            item.value = i;
        }
    }
    countGuest();
}
function GetRoom() {
    var Rooms = document.getElementById("lblRooms").innerHTML;
    var numberOfAdultsRoom1 = document.getElementById("hdnRoom1Adult").value;
    var numberOfAdultsRoom2 = document.getElementById("hdnRoom2Adult").value;
    var numberOfAdultsRoom3 = document.getElementById("hdnRoom3Adult").value;
    var numberOfAdultsRoom4 = document.getElementById("hdnRoom4Adult").value;
    var numberOfChildrenRoom1 = document.getElementById('hdnRoom1Children').value;
    var numberOfChildrenRoom2 = document.getElementById('hdnRoom2Children').value;
    var numberOfChildrenRoom3 = document.getElementById('hdnRoom3Children').value;
    var numberOfChildrenRoom4 = document.getElementById('hdnRoom4Children').value;
    var childAgeRoom1Child1 = document.getElementById("hdnRoom1ChildAge1").value;
    var childAgeRoom1Child2 = document.getElementById("hdnRoom1ChildAge2").value;
    var childAgeRoom1Child3 = document.getElementById("hdnRoom1ChildAge3").value;
    var childAgeRoom2Child1 = document.getElementById("hdnRoom2ChildAge1").value;
    var childAgeRoom2Child2 = document.getElementById("hdnRoom2ChildAge2").value;
    var childAgeRoom2Child3 = document.getElementById("hdnRoom2ChildAge3").value;
    var childAgeRoom3Child1 = document.getElementById("hdnRoom3ChildAge1").value;
    var childAgeRoom3Child2 = document.getElementById("hdnRoom3ChildAge2").value;
    var childAgeRoom3Child3 = document.getElementById("hdnRoom3ChildAge3").value;
    var childAgeRoom4Child1 = document.getElementById("hdnRoom4ChildAge1").value;
    var childAgeRoom4Child2 = document.getElementById("hdnRoom4ChildAge2").value;
    var childAgeRoom4Child3 = document.getElementById("hdnRoom4ChildAge3").value;
    document.getElementById("rooms").value = Rooms;
    document.getElementById("rooms").onchange();
    document.getElementById('room1Adults').value = numberOfAdultsRoom1;
    document.getElementById('room1Adults').onchange();
    document.getElementById('room2Adults').value = numberOfAdultsRoom2;
    document.getElementById('room2Adults').onchange();
    document.getElementById('room3Adults').value = numberOfAdultsRoom3;
    document.getElementById('room3Adults').onchange();
    document.getElementById('room4Adults').value = numberOfAdultsRoom4;
    document.getElementById('room4Adults').onchange();
    document.getElementById('room1Children').value = numberOfChildrenRoom1;
    document.getElementById('room1Children').onchange();
    document.getElementById('room2Children').value = numberOfChildrenRoom2;
    document.getElementById('room2Children').onchange();
    document.getElementById('room3Children').value = numberOfChildrenRoom3;
    document.getElementById('room3Children').onchange();
    document.getElementById('room4Children').value = numberOfChildrenRoom4;
    document.getElementById('room4Children').onchange();
    document.getElementById('optRoom1ChildAge1').value = childAgeRoom1Child1;
    document.getElementById('optRoom1ChildAge2').value = childAgeRoom1Child2;
    document.getElementById('optRoom1ChildAge3').value = childAgeRoom1Child3;
    document.getElementById('optRoom2ChildAge1').value = childAgeRoom2Child1;
    document.getElementById('optRoom2ChildAge2').value = childAgeRoom2Child2;
    document.getElementById('optRoom2ChildAge3').value = childAgeRoom2Child3;
    document.getElementById('optRoom3ChildAge1').value = childAgeRoom3Child1;
    document.getElementById('optRoom3ChildAge2').value = childAgeRoom3Child2;
    document.getElementById('optRoom3ChildAge3').value = childAgeRoom3Child3;
    document.getElementById('optRoom4ChildAge1').value = childAgeRoom4Child1;
    document.getElementById('optRoom4ChildAge2').value = childAgeRoom4Child2;
    document.getElementById('optRoom4ChildAge3').value = childAgeRoom4Child3;

}
function ChildAge(element) {
    var div1 = document.getElementById('divChildAge1');
    var div2 = document.getElementById('divChildAge2');
    var div3 = document.getElementById('divChildAge3');
    if (element == 0) {
        div1.style.display = 'none';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom1ChildAge1').options.length > 0) {
            document.getElementById('optRoom1ChildAge1').selectedIndex = 0;
            if (document.getElementById('optRoom1ChildAge1').value == '') {
                document.getElementById('optRoom1ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge2').options.length > 0) {
            document.getElementById('optRoom1ChildAge2').selectedIndex = 0;
            if (document.getElementById('optRoom1ChildAge2').value == '') {
                document.getElementById('optRoom1ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge3').options.length > 0) {
            document.getElementById('optRoom1ChildAge3').selectedIndex = 0;
            if (document.getElementById('optRoom1ChildAge3').value == '') {
                document.getElementById('optRoom1ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 1) {
        div1.style.display = 'block';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom1ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge1').value == '') {
                document.getElementById('optRoom1ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge2').value == '') {
                document.getElementById('optRoom1ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge3').value == '') {
                document.getElementById('optRoom1ChildAge3').selectedIndex = 0;
            }
        }
    }

    else if (element == 2) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'none';

        if (document.getElementById('optRoom1ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge1').value == '') {
                document.getElementById('optRoom1ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge2').value == '') {
                document.getElementById('optRoom1ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge3').value == '') {
                document.getElementById('optRoom1ChildAge3').selectedIndex = 0;
            }
        }

    }
    else if (element == 3) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'block';
        if (document.getElementById('optRoom1ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge1').value == '') {
                document.getElementById('optRoom1ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge2').value == '') {
                document.getElementById('optRoom1ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom1ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom1ChildAge3').value == '') {
                document.getElementById('optRoom1ChildAge3').selectedIndex = 0;
            }
        }

    }
    countGuest();
}
function ChildAge1(element) {
    var div1 = document.getElementById('divChildAge11');
    var div2 = document.getElementById('divChildAge12');
    var div3 = document.getElementById('divChildAge13');

    if (element == 0) {
        div1.style.display = 'none';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom2ChildAge1').options.length > 0) {
            document.getElementById('optRoom2ChildAge1').selectedIndex = 0;
            if (document.getElementById('optRoom2ChildAge1').value == '') {
                document.getElementById('optRoom2ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge2').options.length > 0) {
            document.getElementById('optRoom2ChildAge2').selectedIndex = 0;
            if (document.getElementById('optRoom2ChildAge2').value == '') {
                document.getElementById('optRoom2ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge3').options.length > 0) {
            document.getElementById('optRoom2ChildAge3').selectedIndex = 0;
            if (document.getElementById('optRoom2ChildAge3').value == '') {
                document.getElementById('optRoom2ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 1) {
        div1.style.display = 'block';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom2ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge1').value == '') {
                document.getElementById('optRoom2ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge2').value == '') {
                document.getElementById('optRoom2ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge3').value == '') {
                document.getElementById('optRoom2ChildAge3').selectedIndex = 0;
            }
        }
    }

    else if (element == 2) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'none';
        if (document.getElementById('optRoom2ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge1').value == '') {
                document.getElementById('optRoom2ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge2').value == '') {
                document.getElementById('optRoom2ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge3').value == '') {
                document.getElementById('optRoom2ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 3) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'block';
        if (document.getElementById('optRoom2ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge1').value == '') {
                document.getElementById('optRoom2ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge2').value == '') {
                document.getElementById('optRoom2ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom2ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom2ChildAge3').value == '') {
                document.getElementById('optRoom2ChildAge3').selectedIndex = 0;
            }
        }
    }
    countGuest();
}
function ChildAge2(element) {
    var div1 = document.getElementById('divChildAge21');
    var div2 = document.getElementById('divChildAge22');
    var div3 = document.getElementById('divChildAge23');

    if (element == 0) {
        div1.style.display = 'none';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom3ChildAge1').options.length > 0) {
            document.getElementById('optRoom3ChildAge1').selectedIndex = 0;
            if (document.getElementById('optRoom3ChildAge1').value == '') {
                document.getElementById('optRoom3ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge2').options.length > 0) {
            document.getElementById('optRoom3ChildAge2').selectedIndex = 0;
            if (document.getElementById('optRoom3ChildAge2').value == '') {
                document.getElementById('optRoom3ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge3').options.length > 0) {
            document.getElementById('optRoom3ChildAge3').selectedIndex = 0;
            if (document.getElementById('optRoom3ChildAge3').value == '') {
                document.getElementById('optRoom3ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 1) {
        div1.style.display = 'block';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom3ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge1').value == '') {
                document.getElementById('optRoom3ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge2').value == '') {
                document.getElementById('optRoom3ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge3').value == '') {
                document.getElementById('optRoom3ChildAge3').selectedIndex = 0;
            }
        }
    }

    else if (element == 2) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'none';
        if (document.getElementById('optRoom3ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge1').value == '') {
                document.getElementById('optRoom3ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge2').value == '') {
                document.getElementById('optRoom3ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge3').value == '') {
                document.getElementById('optRoom3ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 3) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'block';
        if (document.getElementById('optRoom3ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge1').value == '') {
                document.getElementById('optRoom3ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge2').value == '') {
                document.getElementById('optRoom3ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom3ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom3ChildAge3').value == '') {
                document.getElementById('optRoom3ChildAge3').selectedIndex = 0;
            }
        }
    }
    countGuest();
}
function ChildAge3(element) {
    var div1 = document.getElementById('divChildAge31');
    var div2 = document.getElementById('divChildAge32');
    var div3 = document.getElementById('divChildAge33');

    if (element == 0) {
        div1.style.display = 'none';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom4ChildAge1').options.length > 0) {
            document.getElementById('optRoom4ChildAge1').selectedIndex = 0;
            if (document.getElementById('optRoom4ChildAge1').value == '') {
                document.getElementById('optRoom4ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge2').options.length > 0) {
            document.getElementById('optRoom4ChildAge2').selectedIndex = 0;
            if (document.getElementById('optRoom4ChildAge2').value == '') {
                document.getElementById('optRoom4ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge3').options.length > 0) {
            document.getElementById('optRoom4ChildAge3').selectedIndex = 0;
            if (document.getElementById('optRoom4ChildAge3').value == '') {
                document.getElementById('optRoom4ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 1) {
        div1.style.display = 'block';
        div2.style.display = 'none';
        div3.style.display = 'none';
        if (document.getElementById('optRoom4ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge1').value == '') {
                document.getElementById('optRoom4ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge2').value == '') {
                document.getElementById('optRoom4ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge3').value == '') {
                document.getElementById('optRoom4ChildAge3').selectedIndex = 0;
            }
        }

    }

    else if (element == 2) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'none';
        if (document.getElementById('optRoom4ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge1').value == '') {
                document.getElementById('optRoom4ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge2').value == '') {
                document.getElementById('optRoom4ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge3').value == '') {
                document.getElementById('optRoom4ChildAge3').selectedIndex = 0;
            }
        }
    }
    else if (element == 3) {
        div1.style.display = 'block';
        div2.style.display = 'block';
        div3.style.display = 'block';
        if (document.getElementById('optRoom4ChildAge1').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge1').value == '') {
                document.getElementById('optRoom4ChildAge1').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge2').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge2').value == '') {
                document.getElementById('optRoom4ChildAge2').selectedIndex = 0;
            }
        }
        if (document.getElementById('optRoom4ChildAge3').options.length > 0) {
            if (document.getElementById('optRoom4ChildAge3').value == '') {
                document.getElementById('optRoom4ChildAge3').selectedIndex = 0;
            }
        }
    }
    countGuest();
}
function Check(e) {
    $("#divTopCity").hide();
    var keyCode = (e.keyCode ? e.keyCode : e.which);
    if (keyCode > 47 && keyCode < 58) {
        e.preventDefault();
    }
}