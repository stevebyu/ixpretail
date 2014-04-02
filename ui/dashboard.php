<script type="text/javascript">
	
$(function(){

	$("#datacal").on("keydown", ":text", function(event) {
		// Stop at max of 3 chars.

        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if ( (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) ) || $(this).val().length == 3 ) {
                event.preventDefault(); 
            }   
        }
    });

	$("#datacal")
	.on("click", "td", function(){
		$(this).find(":text").focus();
	})
	.on("change", ":text", function(evt){
		console.log(evt);
		var ttl = 0
		$("#datacal").find(":text").each(function(){
			ttl += parseInt( $(this).val() || 0);
		});

		$(".ttl").text( ttl.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") );

		var data = $(this).data("count");
		var value = $(this).val();
		var method = "POST";
		data.count = value;

		var that = $(this);
		$.ajax({
				url: "api/counts",
				method: "POST",
				data: data,
				beforeSend: function(){
					that.closest("td").addClass("busy");
				},
				complete: function(){
					that.closest("td").removeClass("busy");
				},
				success: function(data){
					that.data("count", data);
					that.val(data.count);
					console.log("saved");
				},
				error: function(){
					alert("Unable to save data.");

				}
		});
	});


	for (i = 0; i < 3; i++){
		var li = $("<li></li>")
			.append('<a href="#">' + moment().subtract("month",i).format("MMMM") + '</a>');
		
		if (i == 0){ 
			li.addClass("uk-active");
		}

		$("#calendarTabs").append(li);
	}

	$("#calendarTabs a").click(function(evt){
		
		evt.preventDefault();

		$(this)
			.closest("li")
				.addClass("uk-active")
					.siblings()
						.removeClass("uk-active");

		var offset = $("#calendarTabs a").index( $(this) );
		loadData( moment().subtract("month", offset) );
	});


	loadData( moment() );


});

function loadData( date ){
		var date = moment(date);
		var start = date.startOf("month").format("YYYY-MM-DD");
		var end = date.endOf("month").format("YYYY-MM-DD");
		$.ajax({
			url:'api/counts',
			method: 'GET',
			data: {start: start, end: end},
			success: function(data) {
				console.log(data);
				renderCalendar( date, data );
			},
			error: function(error) {
				console.log(error);
				alert("Unable to load counts");
			}
		});
	}

	function renderCalendar(date,data){
		var ttl = 0;
		var date = moment(date);
		var endDate = moment(date).endOf('month').weekday(7);
		var dateCounter = moment(date).startOf('month').weekday(1);

		var tbody = $('<tbody></tbody>');

		var table = $("table.calendar");

		var row = $('<tr></tr>');

		var j = 0;
		while ( dateCounter <= endDate ){
			
			var cell = $('<td><label>' + dateCounter.date() + '</label></td>');
			var today = moment();
			var currCount = data[j];

			if ( !dateCounter.isSame( date, 'month' ) ){
				cell.addClass("other-month");
				cell.addClass("disabled");
			}
			else if ( dateCounter.weekday() == 0 || dateCounter.isAfter(today, 'date') ){
				cell.addClass("disabled");
			}
			else{
				var input = $('<input type="text"/>');

				if ( !dateCounter.isSame(moment(), "month") ){
					input.attr("disabled","disabled");
					cell.addClass("disabled");
				}

				if ( currCount && moment(currCount.date).isSame(dateCounter, 'date') ){
					input.val(currCount.count);
					input.data("count",currCount);
					ttl += parseInt(currCount.count);
					j++;
				}
				else {
					input.data("count",{
						date: dateCounter.format("YYYY-MM-DD"),
						count: 0
					});
				}
				cell.append( input );
			}

			if ( dateCounter.isSame(today, 'date') ){
				cell.addClass("today");
			}

			cell.appendTo( row );

			if (dateCounter.weekday() == 0){
				cell.addClass("disabled");
				row.appendTo( tbody );
				row = $('<tr></tr>');
			}			
			
			dateCounter.add("d",1);
		}

		table.find("tbody").remove();
		tbody.appendTo( table );

		$(".ttl").text( ttl.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") );

		return table;
	}

	

</script>


    			<div class="uk-width-10-10">
		    			<form id="datacal">
		    				<div class="total">Total: <span class="ttl">--</span></div>
		    				<ul id="calendarTabs" class="uk-tab">
							</ul>
				    		<table class="calendar">
				    			<thead>
				    				<tr>
				    					<th>Monday</th>
				    					<th>Tuesday</th>
				    					<th>Wednesday</th>
				    					<th>Thursday</th>
				    					<th>Friday</th>
				    					<th>Saturday</th>
				    					<th>Sunday</th>
				    				</tr>
				    			</thead>
				    			<tbody>
				    				<tr>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    				</tr>
				    				<tr>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    				</tr>
				    				<tr>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    				</tr>
				    				<tr>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    				</tr>
				    				<tr>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    					<td class="disabled"></td>
				    				</tr>
				    			</tbody>
				    		</table>
				    	
				    	</form>
			    	</div>
		    		<!--<div class="uk-width-3-10" style="padding-left: 40px;">
		    			<div class="uk-panel">
				    		<ul class="uk-tab" data-uk-tab>
							    <li class="uk-active"><a href="">Announcements</a></li>
							    <li><a href="">Newsletters</a></li>
							</ul>
							coandfa
						</div>
					</div>-->
