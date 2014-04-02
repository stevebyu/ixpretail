$(function(){

	$("#datacal").find(":text").keydown(function(event) {
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
	.on("change", ":text", function(){
		
		var callttl = 0
		$("#datacal").find(":text").each(function(){
			callttl += parseInt( $(this).val() || 0);
		});

		$(".callttl").text( callttl.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") );
	});

	

	function buildit(date,counts){
		var date = moment(date);
		var endDate = moment(date).endOf('month').weekday(7);
		var dateCounter = moment(date).startOf('month').weekday(1);

		var pastMonth = date.month() == dateCounter.month();

		var tbody = $('<tbody></tbody>');

		var table = $("table.calendar");

		var row = $('<tr></tr>');

		var j = 0;
		if (counts.length){

		}
		while ( dateCounter.dayOfYear() <= endDate.dayOfYear() ){
			
			var cell = $('<td><label>' + dateCounter.date() + '</label></td>');
			var currDay = moment().dayOfYear();
			var currCount = counts[j];

			if ( !dateCounter.isSame( date, 'month' ) ){
				cell.addClass("other-month");
			}
			else if ( dateCounter.weekday() != 0 && dateCounter.dayOfYear() > currDay ){
				cell.addClass("disabled");
			}
			else{
				var input = $('<input type="text"/>');
				//if ( moment(currCount.date).dayOfYear() == currDay){
				//	inpput.val(currCount.count);
				//}
				cell.append( input );
			}

			if ( dateCounter.dayOfYear == currDay ){
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

		return table;
	}

});