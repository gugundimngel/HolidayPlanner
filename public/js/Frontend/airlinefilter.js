$(function() {

	$(".nkprice").click(
			function() {
				// alert();
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('price')
									- $(b).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				// $("#form_submit_pop_over").modal("hide");
				$(".short_top_mainon").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkduration").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('duration')
									- $(b).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_mainon").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkDepTime").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('deptime')
									- $(b).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_mainon").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkArrTime").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('arrtime')
									- $(b).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_mainon").removeClass("active");
				$(this).addClass("active");
			});
});

$(function() {

	$(".nkpricereturn").click(
			function() {
				// alert();
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('price')
									- $(b).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				// $("#form_submit_pop_over").modal("hide");
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkdurationreturn").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('duration')
									- $(b).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkDepTimereturn").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('deptime')
									- $(b).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
			});

	$(".nkArrTimereturn").click(
			function() {
				// $("#form_submit_pop_over").modal("show");
				$('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('arrtime')
									- $(b).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$("#form_submit_pop_over").modal("hide");
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
			});
});
		
$(document).delegate(".flightso", 'click',function() {
if ($(window).width() < 991) {
}else{
			// $("#form_submit_pop_over").modal("show");
			if ($(this).val() == "0") {

				$(this).val("1");

			} else {
				// alert($(this).attr("check_see"));
				$(this).val("0");
			}

	

			var stops1 = "";
			$(".flightso").each(function() {
				if ($(this).val() == "1") {
					stops1 = $(this).attr("value_for_short");
					console.log(stops1);
					$(".flight11").each(function() {
						if (stops1 == $(this).attr("flight")) {
							$(this).show();
						}

					});

				} else {
					var stops2 = $(this).attr("value_for_short");
					$(".flight11").each(function() {
						if (stops2 == $(this).attr("flight")) {
							$(this).hide();
						}

					});

				}

			});
			if (stops1 == "") {
				$(".flight11").each(function() {
					$(this).show();
				});
			}
			var count_bhanu = 0;
			var count_bhanuret = 0;
			$(".refendable11onword").each(function() {
				if ($("div:visible", this).length > 10) {
					count_bhanu = count_bhanu + 1;
				}
			});

			
			var v = $('#dep_bingo_width').find("div:visible").length;
	var v1 = $('#ret_bingo_width1').find("div:visible").length;
	
	if(v > 0){
	
		var val = $('#dep_bingo_width').find('div:visible').first().attr('id');
		$('#'+val+' input[name="inbound"]').click();
	}
	if(v1 > 0){
	
		var val = $('#ret_bingo_width1').find('div:visible').first().attr('id');
		$('#'+val+' input[name="outbound"]').click();
	}
	}
		});
		
		$(document).delegate(".flightsocraft", 'click',function() {
if ($(window).width() < 991) {
}else{
			// $("#form_submit_pop_over").modal("show");
			if ($(this).val() == "0") {

				$(this).val("1");

			} else {
				// alert($(this).attr("check_see"));
				$(this).val("0");
			}

	

			var stops1 = "";
			$(".flightsocraft").each(function() {
				if ($(this).val() == "1") {
					stops1 = $(this).attr("value_for_short");
					console.log(stops1);
					$(".flight112").each(function() {
						if (stops1 == $(this).attr("flightcraft")) {
							$(this).show();
						}

					});

				} else {
					var stops2 = $(this).attr("value_for_short");
					$(".flight112").each(function() {
						if (stops2 == $(this).attr("flightcraft")) {
							$(this).hide();
						}

					});

				}

			});
			if (stops1 == "") {
				$(".flight112").each(function() {
					$(this).show();
				});
			}
			
	}
		});

$(document).delegate("#cleflt", 'click', function() {

			$(".flight11").each(function() {
				$(this).show();
			});
			$(".price111").each(function() {
				$(this).show();
			});$(".refendable11").each(function() {
				$(this).show();
			});
			$(".stopscount").each(function() {
				$(this).show();
			});$(".price1").each(function() {
				$(this).show();
			});
			$(".flightso").each(function() {
				$(this).removeClass("active");
				$(this).attr("check_see", "0");
				$('.flightso').removeAttr('checked');
			});
			$(".flightstop").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see", "0");
				$('input:checkbox').removeAttr('checked');
			});
			$(".flightfare").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see", "0");
				$('input:checkbox').removeAttr('checked');
			});
			$(".Depfliter").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see_t", "0");

			});$(".Arrfliter").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see_t", "0");

			});$(".ArrRetfliter").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see_t", "0");

			});
			$(".Retfliter").each(function() {
				$(this).parent().removeClass("active");
				$(this).attr("check_see_t", "0");

			});
			var v = $('#dep_bingo_width').find("div:visible").length;
	var v1 = $('#ret_bingo_width1').find("div:visible").length;
	
	if(v > 0){
	
		var val = $('#dep_bingo_width').find('div:visible').first().attr('id');
		$('#'+val+' input[name="inbound"]').click();
	}
	if(v1 > 0){
	
		var val = $('#ret_bingo_width1').find('div:visible').first().attr('id');
		$('#'+val+' input[name="outbound"]').click();
	}	
	
	$('.onlyfilter').removeClass('filter-applied');	
	$('.onlyairline').removeClass('filter-applied');
$('.onlytimer').removeClass('filter-applied');	
$('.onlynonstop .non_stop').removeClass('applied');	
$('.sidebar_filter').removeClass('filtershow airlinefilter');
			$('.sidebar_filter').removeClass('filtershow timefilter');
		});

$(function() {
	$(document).delegate(".applyfilter", 'click', function() {
		
		// Flight search
		$(".flightso").each(function() {
			$(this).val("0");
		});
		$(".flightso:checked").each(function() {
			$(this).val("1");
		});
		if(jQuery('.airline_widget input[type=checkbox]:checked').length) {
			$('.onlyairline').addClass('filter-applied');	
		}else{
			$('.onlyairline').removeClass('filter-applied');	
		}
	

			var stops1 = "";
			$(".flightso").each(function() {
				if ($(this).val() == "1") {
					stops1 = $(this).attr("value_for_short");
					console.log(stops1);
					$(".flight11").each(function() {
						if (stops1 == $(this).attr("flight")) {
							$(this).show();
						}

					});

				} else {
					var stops2 = $(this).attr("value_for_short");
					$(".flight11").each(function() {
						if (stops2 == $(this).attr("flight")) {
							$(this).hide();
						}

					});

				}

			});
			if (stops1 == "") {
				$(".flight11").each(function() {
					$(this).show();
				});
			}
			// Flight
			
			// Time
				$(".Depfliter").each(function() {
					$(this).attr("check_see_t", "0");
				});
				$(".Depfliter:checked").each(function() {
					$(this).attr("check_see_t", "1");
				});
			if(jQuery('.depart_widget input[type=checkbox]:checked').length) {
						
				$('.onlytimer').addClass('filter-applied');	
			}else{
				$('.onlytimer').removeClass('filter-applied');	
			}
				var timestops1 = "";
				$(".Depfliter").each(function() {
					if ($(this).attr("check_see_t") == "1") {
						timestops1 = $(this).val();
						
						var lower = timestops1.split("-")[0];
						var higher = timestops1.split("-")[1];
						$(".price111onword").each(function() {
							
							if(parseInt($(this).attr("timedep"))>=parseInt(timestops1.split("-")[0]) && parseInt($(this).attr("timedep")) <= parseInt(timestops1.split("-")[1]))
							{
								
								$(this).show();
							}
						});
					}else{
						 timestops2 = $(this).val();
						 
						 $(".price111onword").each(function() {
						if(parseFloat($(this).attr("timedep"))>=parseInt(timestops2.split("-")[0]) && parseInt($(this).attr("timedep"))<=parseInt(timestops2.split("-")[1]))
							{
								$(this).hide();
							}
							});
					}
				});
				
				if (timestops1 == "") {
					$(".price111onword").each(function() {
						$(this).show();
					});
				}
			//Time
			//Ret Time
				$(".Retfliter").each(function() {
					$(this).attr("check_see_t", "0");
				});
				$(".Retfliter:checked").each(function() {
					$(this).attr("check_see_t", "1");
				});
			
				var retstops1 = "";
			
				$(".Retfliter").each(function() {
					if ($(this).attr("check_see_t") == "1") {
						retstops1 = $(this).val();
						var lower = retstops1.split("-")[0];
						var higher = retstops1.split("-")[1];
						$(".price111return").each(function() {
							
							if(parseInt($(this).attr("timedep"))>=parseInt(retstops1.split("-")[0]) && parseInt($(this).attr("timedep")) <= parseInt(retstops1.split("-")[1]))
							{
								
								$(this).show();
							}
						});
					}else{
						retstops2 = $(this).val();
						 $(".price111return").each(function() {
						if(parseFloat($(this).attr("timedep"))>=parseInt(retstops2.split("-")[0]) && parseInt($(this).attr("timedep"))<=parseInt(retstops2.split("-")[1]))
							{
								$(this).hide();
							}
							});
					}
				});
				
				if (retstops1 == "") {
					$(".price111return").each(function() {
						$(this).show();
					});
				}
			//Ret Time
			//Rufund
			$(".refundfilter").each(function() {
					$(this).attr("check_see", "0");
				});
				$(".refundfilter:checked").each(function() {
					$(this).attr("check_see", "1");
				});
			
				var refstops1 = "";
				$(".flightfare").each(function() {
					if ($(this).attr("check_see") == "1") {
						refstops1 = $(this).val();

						$(".refendable11").each(function() {

							if (refstops1 == $(this).attr("refendable")) {

								$(this).show();
							}

						});

					} else {
						var refstops2 = $(this).val();
						$(".refendable11").each(function() {
							if (refstops2 == $(this).attr("refendable")) {
								$(this).hide();
							}

						});

					}

				});
				if (refstops1 == "") {
					$(".refendable11").each(function() {
						$(this).show();
					});
				}
			//Refund
			// Stop
			if($('.nonstopval').is(':checked')){
				$('.onlynonstop .non_stop').addClass('applied');
				
			}else{
				$('.onlynonstop .non_stop').removeClass('applied');
			}
			$(".flightstop").each(function() {
					$(this).attr("check_see", "0");
				});
				$(".flightstop:checked").each(function() {
					$(this).attr("check_see", "1");
				});
			var sstops1 = "";
				$(".flightstop").each(function() {
					if ($(this).attr("check_see") == "1") {
						sstops1 = $(this).val();

						$(".stopscount").each(function() {

							if (sstops1 == $(this).attr("stop")) {

								$(this).show();
							}

						});

					} else {
						var sstops2 = $(this).val();
						$(".stopscount").each(function() {
							if (sstops2 == $(this).attr("stop")) {
								$(this).hide();
							}

						});

					}

				});
				if (sstops1 == "") {
					$(".stopscount").each(function() {
						$(this).show();
					});
				}
			// Stop
			
			
			// Price
			var p = $('.pricenew').val();
		
			$(".price1").each(function(){
                    if(parseInt($(this).attr("price"))<=parseInt(p.split("-")[0]) || parseInt($(this).attr("price"))>=parseInt(p.split("-")[1]))
                    {
                        $(this).hide();
                    }
                    if(parseInt($(this).attr("price"))>=parseInt(p.split("-")[0]) && parseInt($(this).attr("price"))<=parseInt(p.split("-")[1]))
                    {
                        $(this).show();
                    }
                }); 
			//Price
			//Time
			var ps = $('.timenew').val();
			$(".price111onword").each(function(){
				if(parseInt($(this).attr("timedep"))<parseInt(ps.split("-")[0]) || parseInt($(this).attr("timedep"))>parseInt(ps.split("-")[1]))
				{
				$(this).hide();
				}
				if(parseInt($(this).attr("timedep"))>parseInt(ps.split("-")[0]) && parseInt($(this).attr("timedep"))<parseInt(ps.split("-")[1]))
				{
				$(this).show();
				}
				}); 
			//Time
			if(jQuery('.airline_widget input[type=checkbox]:checked').length || jQuery('.depart_widget input[type=checkbox]:checked').length || jQuery('.faretype_widget input[type=checkbox]:checked').length|| jQuery('.stops_widget input[type=checkbox]:checked').length || (parseInt($('.slider-range').attr('data-slider-min-value')) != parseInt(p.split("-")[0]) || parseInt($('.slider-range').attr('data-slider-max-value')) != parseInt(p.split("-")[1]))) {
				$('.onlyfilter').addClass('filter-applied');	
			
			}else{
				$('.onlyfilter').removeClass('filter-applied');	
			}
			$('.sidebar_filter').removeClass('filtershow airlinefilter');
			$('.sidebar_filter').removeClass('filtershow timefilter');
	});
	$(document).delegate(".onlynonstop .non_stop", 'click', function() {
		if($('.onlynonstop .non_stop').hasClass('applied')){
			$('.onlyfilter').addClass('filter-applied');
			$('.nonstopval').prop('checked', true);
			$('.nonstopval').parent().addClass('active');
			$('.nonstopval').attr('check_see', 1);
			var stops1 = "";
			
			$(".stopscount").each(function() {
				stops1 = 0;
				if (stops1 == $(this).attr("stop")) {
					$(this).show();
				}
			});
			
			$(".stopscount").each(function() {
				stops1 = 0;
				if (stops1 != $(this).attr("stop")) {
					$(this).hide();
				}
			});
		}else{
			$('.onlyfilter').removeClass('filter-applied');
			$('.nonstopval').prop('checked', false);
			$('.nonstopval').parent().removeClass('active');
			$('.nonstopval').attr('check_see', 0);
			$(".stopscount").each(function() {
						$(this).show();
					});
		}
	});
	$(document).delegate(".flightstop", 'click', function(e) {
		if ($(this).attr("check_see") == "0") {
					$(this).attr("check_see", "1");
				} else {
					$(this).attr("check_see", "0");
				}
				if ($(window).width() < 991) {
					
				}else{					
				// $("#form_submit_pop_over").modal("show");
				
				var stops1 = "";
				$(".flightstop").each(function() {
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".stopscount").each(function() {

							if (stops1 == $(this).attr("stop")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".stopscount").each(function() {
							if (stops2 == $(this).attr("stop")) {
								$(this).hide();
							}

						});

					}

				});
				if (stops1 == "") {
					$(".stopscount").each(function() {
						$(this).show();
					});
				}
				var count_bhanu = 0;
				var count_bhanuret = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});

				$(".search-results-title-onword").html(
						'</i>Onword - <b>' + count_bhanu + '</b> found');

				$(".refendable11return").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanuret = count_bhanuret + 1;
					}
				});
				$(".search-results-title-return").html(
						'</i>Return - <b>' + count_bhanuret + '</b> found');
				$("#form_submit_pop_over").modal("hide");
				
				var v = $('#dep_bingo_width').find("div:visible").length;
	var v1 = $('#ret_bingo_width1').find("div:visible").length;
	
	if(v > 0){
	
		var val = $('#dep_bingo_width').find('div:visible').first().attr('id');
		$('#'+val+' input[name="inbound"]').click();
	}
	if(v1 > 0){
	
		var val = $('#ret_bingo_width1').find('div:visible').first().attr('id');
		$('#'+val+' input[name="outbound"]').click();
	}
				}
			});
			
			
});

// This is for refundable and non refundable
// sort................................Start......................................................
$(function() {
	$(document).delegate(".flightfare", 'click', function() {

				// $("#form_submit_pop_over").modal("show");
				if ($(this).attr("check_see") == "0") {
					$(this).attr("check_see", "1");
				} else {
					$(this).attr("check_see", "0");
				}
				var stops1 = "";
				$(".flightfare").each(function() {
					if ($(this).attr("check_see") == "1") {
						stops1 = $(this).val();

						$(".refendable11").each(function() {

							if (stops1 == $(this).attr("refendable")) {

								$(this).show();
							}

						});

					} else {
						var stops2 = $(this).val();
						$(".refendable11").each(function() {
							if (stops2 == $(this).attr("refendable")) {
								$(this).hide();
							}

						});

					}

				});
				if (stops1 == "") {
					$(".refendable11").each(function() {
						$(this).show();
					});
				}
				var count_bhanu = 0;
				var count_bhanuret = 0;
				$(".refendable11onword").each(function() {
					if ($("div:visible", this).length > 10) {
						count_bhanu = count_bhanu + 1;
					}
				});

				
				
			
			});

});


$(function() {
	$(document).delegate(".Depfliter", 'click', function() {
		if ($(this).attr("check_see_t") == "0") {
					$(this).attr("check_see_t", "1");
				} else {
					$(this).attr("check_see_t", "0");
				}
		if ($(window).width() < 991) {
		}else{
				
				var stops1 = "";
				$(".Depfliter").each(function() {
					if ($(this).attr("check_see_t") == "1") {
						stops1 = $(this).val();
						 console.log('ddd'+stops1);
						var lower = stops1.split("-")[0];
						var higher = stops1.split("-")[1];
						$(".price111onword").each(function() {
							
							if(parseInt($(this).attr("timedep"))>=parseInt(stops1.split("-")[0]) && parseInt($(this).attr("timedep")) <= parseInt(stops1.split("-")[1]))
							{
								
								$(this).show();
							}
						});
					}else{
						 stops2 = $(this).val();
						 console.log('sss'+stops2);
						 $(".price111onword").each(function() {
						if(parseFloat($(this).attr("timedep"))>=parseInt(stops2.split("-")[0]) && parseInt($(this).attr("timedep"))<=parseInt(stops2.split("-")[1]))
							{
								$(this).hide();
							}
							});
					}
				});
				
				if (stops1 == "") {
					$(".price111onword").each(function() {
						$(this).show();
					});
				}
				}
		
				
	
			});
			
	
	/*Arrival Filter*/
	$(document).delegate(".Arrfliter", 'click', function() {
				// $("#form_submit_pop_over").modal("show");
				var stops1 = "";
				stops1 = $(this).val();
		
				var lower = stops1.split("-")[0];
						var higher = stops1.split("-")[1];
						
				$(".price111onword").each(function() {
					if(parseFloat($(this).attr("timearr"))<=parseInt(stops1.split("-")[0]) || parseInt($(this).attr("timearr"))>=parseInt(stops1.split("-")[1]))
							{
								$(this).hide();
							}
							if(parseInt($(this).attr("timearr"))>=parseInt(stops1.split("-")[0]) && parseInt($(this).attr("timearr")) <= parseInt(stops1.split("-")[1]))
							{
								
								$(this).show();
							}

				});
		});
	/*Arrival Filter*/
			
			$(document).delegate(".Retfliter", 'click', function() {
				if ($(this).attr("check_see_t") == "0") {
					$(this).attr("check_see_t", "1");
				} else {
					$(this).attr("check_see_t", "0");
				}
				var stops1 = "";
				stops1 = $(this).val();
		
				$(".Retfliter").each(function() {
					if ($(this).attr("check_see_t") == "1") {
						stops1 = $(this).val();
						var lower = stops1.split("-")[0];
						var higher = stops1.split("-")[1];
						$(".price111return").each(function() {
							
							if(parseInt($(this).attr("timedep"))>=parseInt(stops1.split("-")[0]) && parseInt($(this).attr("timedep")) <= parseInt(stops1.split("-")[1]))
							{
								
								$(this).show();
							}
						});
					}else{
						stops2 = $(this).val();
						 $(".price111return").each(function() {
						if(parseFloat($(this).attr("timedep"))>=parseInt(stops2.split("-")[0]) && parseInt($(this).attr("timedep"))<=parseInt(stops2.split("-")[1]))
							{
								$(this).hide();
							}
							});
					}
				});
				
				if (stops1 == "") {
					$(".price111return").each(function() {
						$(this).show();
					});
				}
	
			});
			
			
			$(document).delegate(".ArrRetfliter", 'click', function() {
				// $("#form_submit_pop_over").modal("show");
				var stops1 = "";
				stops1 = $(this).val();
		
				var lower = stops1.split("-")[0];
						var higher = stops1.split("-")[1];
						
				$(".price111return").each(function() {
					if(parseFloat($(this).attr("timearr"))<=parseInt(stops1.split("-")[0]) || parseInt($(this).attr("timearr"))>=parseInt(stops1.split("-")[1]))
							{
								$(this).hide();
							}
							if(parseInt($(this).attr("timearr"))>=parseInt(stops1.split("-")[0]) && parseInt($(this).attr("timearr")) <= parseInt(stops1.split("-")[1]))
							{
								
								$(this).show();
							}

				});
		});

});
// This is for refundable and non refundable
// sort................................End......................................................
// this is for sort by top
// menu................................start......................................................
$(function() {

	PriceSortOneWay('ascending');
	PriceMoreSortOneWay('ascending');
$(document).delegate(".bpduration", 'click', function() {

				$('.refendable11onward').sort(
						function(a, b) {
							return $(a).find('.price1').data('duration')
									- $(b).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
				
				
			});
$(document).delegate(".bpDepTIme", 'click', function() {

				$('.refendable11onward').sort(
						function(a, b) {
							return $(a).find('.price1').data('deptime')
									- $(b).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$(".short_top_main").removeClass("active");
				$(this).addClass("active");
				
				
			});

	
});
function PriceSortOneWay(val = '') {
				if(val == ''){
					var order_type = $('#pricesorting').val();
				}else{
					var order_type = 'ascending';
				}
				 if (order_type == 'ascending') {
					$('.refendable11onword').sort(
					function(a, b) {
						return $(a).find('.price1').data('price')
								- $(b).find('.price1').data('price');
					}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					});
					$('#pricesorting').val('descending');
					$('.pricesorta').show();
					$('.pricesortd').hide();
				 }
				   else if (order_type == 'descending') {
					   $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('price')
									- $(a).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					
					});
					$('#pricesorting').val('ascending');
					$('.pricesorta').hide();
					$('.pricesortd').show();
				  }
				$('input[name="outbound"]').parent().parent().parent().parent().removeClass('active');
				  $('input[name="outbound"]:checked').parent().parent().parent().parent().addClass('active');  
}

function PriceMoreSortOneWay(val = '') {
				if(val == ''){
					var order_type = $('#pricesorting').val();
				}else{
					var order_type = 'ascending';
				}
				 if (order_type == 'ascending') {
					$('.refendable11onwordm').sort(
					function(a, b) {
						return $(a).find('.mprice1').data('fareprice')
								- $(b).find('.mprice1').data('fareprice');
					}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					});
				$(".fareselect:first").attr('checked', true);
				 }
				  /*  else if (order_type == 'descending') {
					   $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('price')
									- $(a).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					
					});
					$('#pricesorting').val('ascending');
					$('.pricesorta').hide();
					$('.pricesortd').show();
				  } */
				  
}
function DepartSortOneWay() {
	 var order_type = $('#depasorting').val();
	 if (order_type == 'ascending') {
		 $('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('deptime')
									- $(b).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#depasorting').val('descending');
				$('.depasorta').show();
				$('.depasortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('deptime')
									- $(a).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#depasorting').val('ascending');
				$('.depasorta').hide();
				$('.depasortd').show();
	 }
	 
	
}

function ArriveSortOneWay() {
	 var order_type = $('#arrivesorting').val();
	 if (order_type == 'ascending') {
		 $('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('arrtime')
									- $(b).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#arrivesorting').val('descending');
				$('.arriveasorta').show();
				$('.arrivesortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('arrtime')
									- $(a).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#arrivesorting').val('ascending');
				$('.arriveasorta').hide();
				$('.arrivesortd').show();
	 }
	 
	
}
function DurationSortOneWay() {
	 var order_type = $('#durasorting').val();
	 if (order_type == 'ascending') {
		$('.refendable11onword').sort(
						function(a, b) {
							return $(a).find('.price1').data('duration')
									- $(b).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#durasorting').val('descending');
				$('.durasorta').show();
				$('.durasortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11onword').sort(
						function(a, b) {
							return $(b).find('.price1').data('duration')
									- $(a).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#durasorting').val('ascending');
				$('.durasorta').hide();
				$('.durasortd').show();
	 }
	 
	
}

function AirlineSortOneWay(){
	var order_type = $('#airsorting').val();
	if (order_type == 'ascending') {
		$('.refendable11onword').sort(
						function(a, b) {
							return ($(b).find(".price1").data('flight').toUpperCase()) <  
							($(a).find(".price1").data('flight').toUpperCase()) ? 1 : -1;  
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
		$('#airsorting').val('descending');
		$('.airsorta').show();
		$('.airsortd').hide();
	} else if (order_type == 'descending') {
		$('.refendable11onword').sort(
						function(a, b) {
							return ($(b).find(".price1").data('flight').toUpperCase()) >  
                    ($(a).find(".price1").data('flight').toUpperCase()) ? 1 : -1;  
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
		$('#airsorting').val('ascending');
		$('.airsorta').hide();
		$('.airsortd').show();
	}
	

}

function ReturnPriceSortDRTO(val = '') {
				if(val == ''){
					var order_type = $('#retpricesorting').val();
				}else{
					var order_type = 'ascending';
				}
				 if (order_type == 'ascending') {
					$('.refendable11return').sort(
					function(a, b) {
						return $(a).find('.price1').data('price')
								- $(b).find('.price1').data('price');
					}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					});
					$('#retpricesorting').val('descending');
					$('.retpricesorta').show();
					$('.retpricesortd').hide();
				 }
				   else if (order_type == 'descending') {
					   $('.refendable11return').sort(
						function(a, b) {
							return $(b).find('.price1').data('price')
									- $(a).find('.price1').data('price');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
					
					});
					$('#retpricesorting').val('ascending');
					$('.retpricesorta').hide();
					$('.retpricesortd').show();
				  }
				  
}

function ReturnDepartSortRound() {
	 var order_type = $('#retdepasorting').val();
	 if (order_type == 'ascending') {
		 $('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('deptime')
									- $(b).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retdepasorting').val('descending');
				$('.retdepasorta').show();
				$('.retdepasortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11return').sort(
						function(a, b) {
							return $(b).find('.price1').data('deptime')
									- $(a).find('.price1').data('deptime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retdepasorting').val('ascending');
				$('.retdepasorta').hide();
				$('.retdepasortd').show();
	 }
	 
	
}

function ReturnArriveSortRound() {
	 var order_type = $('#retarrivesorting').val();
	 if (order_type == 'ascending') {
		 $('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('arrtime')
									- $(b).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retarrivesorting').val('descending');
				$('.retarriveasorta').show();
				$('.retarrivesortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11return').sort(
						function(a, b) {
							return $(b).find('.price1').data('arrtime')
									- $(a).find('.price1').data('arrtime');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retarrivesorting').val('ascending');
				$('.retarriveasorta').hide();
				$('.retarrivesortd').show();
	 }
	 
	
}
function ReturnDurationSortRound() {
	 var order_type = $('#retdurasorting').val();
	 if (order_type == 'ascending') {
		$('.refendable11return').sort(
						function(a, b) {
							return $(a).find('.price1').data('duration')
									- $(b).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retdurasorting').val('descending');
				$('.retdurasorta').show();
				$('.retdurasortd').hide();
	 }else if (order_type == 'descending') {
		 $('.refendable11return').sort(
						function(a, b) {
							return $(b).find('.price1').data('duration')
									- $(a).find('.price1').data('duration');
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
				$('#retdurasorting').val('ascending');
				$('.retdurasorta').hide();
				$('.retdurasortd').show();
	 }
	 
	
}

function ReturnAirlineSortRound(){
	var order_type = $('#retairsorting').val();
	if (order_type == 'ascending') {
		$('.refendable11return').sort(
						function(a, b) {
							return ($(b).find(".price1").data('flight').toUpperCase()) <  
							($(a).find(".price1").data('flight').toUpperCase()) ? 1 : -1;  
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
		$('#retairsorting').val('descending');
		$('.retairsorta').show();
		$('.retairsortd').hide();
	} else if (order_type == 'descending') {
		$('.refendable11return').sort(
						function(a, b) {
							return ($(b).find(".price1").data('flight').toUpperCase()) >  
                    ($(a).find(".price1").data('flight').toUpperCase()) ? 1 : -1;  
						}).each(function(_, refendable11) {
					$(refendable11).parent().append(refendable11);
				});
		$('#retairsorting').val('ascending');
		$('.retairsorta').hide();
		$('.retairsortd').show();
	}
	

}
// this is for main sort on
// top....................................................................

