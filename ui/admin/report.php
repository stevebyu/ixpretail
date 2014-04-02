<script type="text/javascript">
	
	$("#btnGenerateReport").click(function(){
		getReport();
	});

	$("#btnDownload").click(function(){
		//getCSV()
	});

	function getReport(){
		var startDate = $("#txtStartDate").val();
		var endDate = $("#txtEndDate").val();
		$.ajax({
					url: "api/report",
					data: { start: startDate, end: endDate },
					beforeSend: function(){
						$("#indicator").addClass("busy");
					},
					complete: function(){
						$("#indicator").removeClass("busy");
					},
					success: function(data){
						console.log(data);


						$("#reportTable tbody").empty();
							var ttl = 0;
							$.each(data, function(i,e){
								var row = $("<tr></tr>");
								row.append('<td>' + e.r + '</td>' +
											'<td>' + e.store + '</td>' +
											'<td>' + e.accounttype + '</td>' +
											'<td>' + e.account + '</td>' +
											'<td>' + e.routing + '</td>' +
											'<td>' + e.franchise + '</td>' +
											'<td>' + e.period + '</td>' +
											'<td>' + e.pickups + '</td>' +
											'<td>' + parseInt(e.pay).toFixed(2) + '</td>' +
											'<td>' + e.credit + '</td>'
											);
								ttl += parseInt(e.pickups);

								$("#reportTable tbody").append(row);
							});

							$("#lblPickups").text(ttl);
							$("#lblStores").text(data.length);
							$("#lblPayments").text((ttl * 1.5).toFixed(2));

							$("#reportResults").show("fast");


						if(data.length){
							$("#btnDownload").add("#reportTable").show("fast");
							$("#btnDownload").attr("href","api/report?&start=" + startDate + "&end=" + endDate + "&format=csv");

						} else{

							$("#btnDownload").add("#reportTable").hide("fast");

						}

						

						

					},
					error: function(){
						alert("Unable to load data.");
					}
				});
	}

	function getCSV(){
		var startDate = $("#txtStartDate").val();
		var endDate = $("#txtEndDate").val();
		$.ajax({
					url: "api/report",
					data: { start: startDate, end: endDate, format:"csv" },
					success: function(data){

					},
					error: function(){
						alert("Unable to load data.");
					}
				});
	}

</script>

<div class="uk-width-2-10">

		    			<div class="uk-panel uk-panel-box">

				    		<form class="uk-form">

							    <fieldset>

							        <div class="uk-form-row uk-form-icon">

							        	<i class="uk-icon-calendar"></i><input type="text" id="txtStartDate" placeholder="Start Date" data-uk-datepicker="{format:'YYYY-MM-DD'}" class="uk-form-width-small" style="width:100%;">

							        </div>

							        <div class="uk-form-row uk-form-icon">

							        	<i class="uk-icon-calendar"></i><input type="text" id="txtEndDate" placeholder="End Date" data-uk-datepicker="{format:'YYYY-MM-DD'}" class="uk-form-width-small" style="width:100%;">

							        </div>

							        <div class="uk-form-row control-bar">

							        	<span id="indicator"></span>
							        	<button type="button" class="uk-button" id="btnGenerateReport">Generate</button>

							        </div>

							        <div id="reportResults">
							        	<h3>Results</h3>
							        	<ul>

							    			<li><span id="lblPickups">0</span><label>Pickups</label></li>

							    			<li><span id="lblStores">0</span><label>Stores</label></li>

							    			<li><span id="lblPayments">0</span><label>Payments</label></li>

							    		</ul>
							    		<div class="control-bar">
							    			<a id="btnDownload" class="uk-button">Download CSV</a>
							    		</div>
							        </div>

							    </fieldset>

							</form>

						</div>

					</div>
<div class="uk-width-8-10" style="padding-left:40px;">

						<table id="reportTable" class="uk-table">
							<thead>
								<tr>
									<th>R</th>
									<th>Store</th>
									<th>Account Type</th>
									<th>Account #</th>
									<th>Routing #</th>
									<th>Franchise</th>
									<th>Pay Period</th>
									<th>Pickups</th>
									<th>Pay</th>
									<th>Credit</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
				    </div>