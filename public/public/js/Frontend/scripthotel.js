$(document).ready(function () {
    var roomhtml = "";
    roomhtml += '<div class="box" id="divroom1">';
    roomhtml += '<div class="roomTxt"><span>Room 1:</span></div>';
    roomhtml += '<div class="left pull-left">';
    roomhtml += '<span class="txt">';
    roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
    roomhtml += '</div>';
    roomhtml += '<div class="right pull-right">';
    roomhtml += '<div id="field1" class="PlusMinusRow">';
    roomhtml += '<a type="button" id="Adults_room_1_1_minus" class="sub hoteladultclass">-</a>';
    roomhtml += '<span id="Adults_room_1_1" class="PlusMinus_number">2</span>';
    roomhtml += '<a type="button" id="Adults_room_1_1_plus" class="add hoteladultclass" >+</a>';
    roomhtml += '</div> ';
    roomhtml += '</div> ';
    roomhtml += '<div class="spacer"></div>';
    roomhtml += '<div class="left pull-left"> ';
    roomhtml += '<span class="txt">';
    roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
    roomhtml += '</div>';
    roomhtml += '<div class="right pull-right">';
    roomhtml += '<div id="field2" class="PlusMinusRow">';
    roomhtml += '<a type="button" id="Children_room_1_1_minus" class="sub hotelchildclass">-</a>';
    roomhtml += '<span id="Children_room_1_1" class="PlusMinus_number">0</span>';
    roomhtml += '<a type="button" id="Children_room_1_1_plus" class="add hotelchildclass">+</a>';
    roomhtml += '</div> ';
    roomhtml += '</div>';
    roomhtml += '<div class="clear"></div>';
    roomhtml += '<div class="childresAgeTxt" id="Children_room_1_1_text" style="display: none">Age(s) of Children</div>';
    roomhtml += '<select id="Child_Age_1_1" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
    roomhtml += '<select id="Child_Age_1_2" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>  ';
    roomhtml += '<div class="clear"></div> ';
    roomhtml += '</div>';

    $("#roomshtml").html(roomhtml);
    var roomcnt = $("#hdnroom").val();
    if (parseInt(roomcnt) > 1) {
        for (var i = 2; i <= parseInt(roomcnt) ; i++) {
            setRoomsPanel(i)
        }
    }
    setRoomsPaxPanel();
    setroomandguestsMsg();
    $("body").delegate(".hotelchildclass", "click", function () {

        if (/plus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) < 2) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) + 1);
            setroomandguestsMsg();
        }
        else if (/minus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) > 0) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) - 1);
            setroomandguestsMsg();
        }
        if (parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) >= 0 && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) <= 2) {
            var currentchildcount = $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html();

            if (parseInt(currentchildcount) == 1) {
                $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0) + "_text").css("display", "block");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "inline");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "none");
            }
            else if (parseInt(currentchildcount) == 2) {
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "inline");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "inline");
            }
            else if (parseInt(currentchildcount) == 0) {
                $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0) + "_text").css("display", "none");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_1").css("display", "none");
                $("#Child_Age_" + this.id.split('_room')[1].split("_")[1] + "_2").css("display", "none");
            }
        }
    });

    $("body").delegate(".hoteladultclass", "click", function () {

        if (/plus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) < 4) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) + 1);
            setroomandguestsMsg();
        }
        else if (/minus/i.test(this.id) && parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) > 1) {
            $("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html(parseInt($("#" + this.id.substring(0, this.id.lastIndexOf("_") + 0)).html()) - 1);
            setroomandguestsMsg();
        }

    });

    $("#addhotelRoom").click(function () {
        var oldroomcnt = $("#hdnroom").val();
        var roomcount = parseInt(oldroomcnt) + 1;
        $("#removehotelRoom").css("display", "inline-block");
        if (parseInt(oldroomcnt) < 4) {
            var roomhtml = "";
            roomhtml += '<div class="box" id="divroom' + roomcount + '" style="display:none;">';
            roomhtml += '<div class="roomTxt"><span>Room ' + roomcount + ':</span></div>';
            roomhtml += '<div class="left pull-left">';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field3" class="PlusMinusRow">';
            roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_minus" class="sub hoteladultclass">-</a>';
            roomhtml += '<span id="Adults_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">2</span>';
            roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_plus" class="add hoteladultclass">+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div> ';
            roomhtml += '<div class="spacer"></div>';
            roomhtml += '<div class="left pull-left"> ';
            roomhtml += '<span class="txt">';
            roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
            roomhtml += '</div>';
            roomhtml += '<div class="right pull-right">';
            roomhtml += '<div id="field4" class="PlusMinusRow">';
            roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_minus" class="sub hotelchildclass">-</a>';
            roomhtml += '<span id="Children_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">0</span>';
            roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_plus" class="add hotelchildclass">+</a>';
            roomhtml += '</div> ';
            roomhtml += '</div>';
            roomhtml += '<div class="clear"></div>';
            roomhtml += '<div class="childresAgeTxt" id="Children_room_' + roomcount + '_' + roomcount + '_text" style="display: none;">Age(s) of Children</div>';
            roomhtml += '<select id="Child_Age_' + roomcount + '_1" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
            roomhtml += '<select id="Child_Age_' + roomcount + '_2" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>  ';
            roomhtml += '<div class="clear"></div> ';
            roomhtml += '</div>';
            $("#roomshtml").append(roomhtml);
            $("#hdnroom").val(roomcount);
            $("#divroom" + roomcount).slideDown(500);

            setroomandguestsMsg();
            if (roomcount == 4) {
                $("#addhotelRoom").css("display", "none");
            }
        }
        else {
            $("#addhotelRoom").css("display", "none");
        }
    });

    $("#removehotelRoom").click(function () {
        var roomcnt = $("#hdnroom").val();
        if (parseInt(roomcnt) > 1) {
            $("#divroom" + roomcnt).slideUp('300', function () { $(this).remove(); })
            $("#hdnroom").val(parseInt($("#hdnroom").val()) - 1);
            setroomandguestsMsg();
            if (parseInt($("#hdnroom").val()) == 1) {
                $("#removehotelRoom").css("display", "none");
                $("#addhotelRoom").css("display", "inline-block");
            }
            else if (parseInt($("#hdnroom").val()) == 3) {
                $("#addhotelRoom").css("display", "inline-block");
            }
        }

    });
    $("#exithotelroom").click(function () {
        $('#divHotelPaxContent').fadeOut();
    });
    function setroomandguestsMsg() {
        var roomcount = $("#hdnroom").val(); var roomguestmsg = "";
        var guestcount = "0";
		var roomCounts = "0";
        for (var i = 1; i <= parseInt(roomcount) ; i++) {
            guestcount = parseInt(guestcount) + parseInt($("#Adults_room_" + i + "_" + i + "").html());
            guestcount = parseInt(guestcount) + parseInt($("#Children_room_" + i + "_" + i + "").html());
        }
        if (parseInt(roomcount) > 1) {
            roomCounts = parseInt(roomcount)
        }
        else {
            roomCounts = parseInt(roomcount);
        }
        if (parseInt(guestcount) > 1) {
            roomguestmsg += guestcount;
        }
        else {
            roomguestmsg += guestcount;
        }
        $("#guestroom").html(roomCounts);
		$("#guestcount").html(roomguestmsg);
		
		
    }

    function setRoomsPanel(roomcount) {
        var roomhtml = "";
        roomhtml += '<div class="box " id="divroom' + roomcount + '">';
        roomhtml += '<div class="roomTxt"><span>Room ' + roomcount + ':</span></div>';
        roomhtml += '<div class="left pull-left">';
        roomhtml += '<span class="txt">';
        roomhtml += '<span id="Label7">Adult <em>(Above 12 years)</em></span></span>';
        roomhtml += '</div>';
        roomhtml += '<div class="right pull-right">';
        roomhtml += '<div id="field1" class="PlusMinusRow">';
        roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_minus" class="sub hoteladultclass">-</a>';
        roomhtml += '<span id="Adults_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">2</span>';
        roomhtml += '<a type="button" id="Adults_room_' + roomcount + '_' + roomcount + '_plus" class="add hoteladultclass">+</a>';
        roomhtml += '</div> ';
        roomhtml += '</div> ';
        roomhtml += '<div class="spacer"></div>';
        roomhtml += '<div class="left pull-left"> ';
        roomhtml += '<span class="txt">';
        roomhtml += '<span id="Label9">Child <em>(Below 12 years)</em></span></span>';
        roomhtml += '</div>';
        roomhtml += '<div class="right pull-right">';
        roomhtml += '<div id="field1" class="PlusMinusRow">';
        roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_minus" class="sub hotelchildclass">-</a>';
        roomhtml += '<span id="Children_room_' + roomcount + '_' + roomcount + '" class="PlusMinus_number">0</span>';
        roomhtml += '<a type="button" id="Children_room_' + roomcount + '_' + roomcount + '_plus" class="add hotelchildclass">+</a>';
        roomhtml += '</div> ';
        roomhtml += '</div>';
        roomhtml += '<div class="clear"></div>';
        roomhtml += '<div class="childresAgeTxt" id="Children_room_' + roomcount + '_' + roomcount + '_text" style="display: none;">Age(s) of Children</div>';
        roomhtml += '<select id="Child_Age_' + roomcount + '_1" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>';
        roomhtml += '<select id="Child_Age_' + roomcount + '_2" style="display: none"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>10</option><option>11</option></select>  ';
        roomhtml += '<div class="clear"></div> ';
        roomhtml += '</div>';
        $("#roomshtml").append(roomhtml);
        $("#removehotelRoom").css("display", "inline-block");
        if (roomcount == 4) {
            $("#addhotelRoom").css("display", "none");
        }
    }

    function setRoomsPaxPanel() {
        if ($("#hdnPaxInfo").val() != undefined) {
            var PaxInfo = $("#hdnPaxInfo").val(); var roomcnt = $("#hdnroom").val();
            var arraypax = [];
            arraypax = PaxInfo.split('|');
            for (var i = 1; i <= parseInt(roomcnt) ; i++) {
                for (var z = 1; z < arraypax.length; z++) {
                    $("#Adults_room_" + i + "_" + z + "").text(arraypax[parseInt(z) - 1].split('$')[0].split('-')[0].length);
                    if (arraypax[parseInt(z) - 1].split('$')[0].indexOf('C') > 0) {
                        var childlen = arraypax[parseInt(z) - 1].split('$')[0].split('-')[1].length;
                        if (childlen > 0) {
                            for (var zz = 1; zz <= childlen; zz++) {
                                if (zz == 1) {
                                    $("#Children_room_" + i + "_" + z + "").text(childlen)
                                    $("#Children_room_" + i + "_" + z + "_text").css("display", "block");
                                }
                                $("#Child_Age_" + z + "_" + zz + "").css("display", "block");
                                $("#Child_Age_" + z + "_" + zz + "").val(arraypax[parseInt(z) - 1].split('$')[1].split(',')[parseInt(zz) - 1]);
                            }
                        }
                    }
                }

            }
        }
    }

});

$('#divPaxPanel').click(function () {
    var panel = $('#divHotelPaxContent');
    if (panel.is(":visible")) {
        panel.fadeOut();
    } else {
        panel.fadeIn();
    }
});