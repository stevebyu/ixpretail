<script type="text/javascript">
	
$(function(){

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
			data: {start: start, end: end, group: "date"},
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
				var input = $('<input type="text" disabled="disabled" />');

				if ( !dateCounter.isSame(moment(), "month") ){
					cell.addClass("disabled");
				}

				if ( currCount && moment(currCount.date).isSame(dateCounter, 'date') ){
					input.val(currCount.count);
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

<div class="uk-width-1-1">
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
