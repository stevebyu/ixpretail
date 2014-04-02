<script type="text/javascript">

		$.ajax({
				url:"api/stores",
				method: "GET",
				success:function(data){
					if(!data){return;}
					//data = JSON.parse(data);
					$("#storesTable").dataTable({
						"bDestroy": true,
				        "aaData": data,
				        "sDefaultContent": "--",
				        "sDom":'<"top"if>rt<"bottom"p><"clear">',
				        "aDataLength": 10,
  	            		"bDeferRender": true,
				        "aoColumns": [
				            { "sTitle": "Store Name", "mData": "name"},
				            { "sTitle": "Address", "mData": "address" },
				            { "sTitle": "City", "mData": "city" },
				            { "sTitle": "State", "mData": "state" },
				          	{ "sTitle": "ZIP", "mData": "zip" }
				        ],
				        "oLanguage": {
						  "sSearch": "",
						  "sInfo": "_TOTAL_ stores",
						  "sInfoFiltered": ""
						}
					}).fadeIn("fast");

					$(".dataTables_filter")
					.addClass("uk-form")
						.find(":text")
							.attr("placeholder", "Search Stores...");

					$("#btnNewStore").prependTo("div.bottom").css("float","right");
				},
				error: function(){
					alert("Unable to load stores.");
				},
				beforeSend: function(){
					$("#content").addClass("busy");
				},
				complete: function(){
					$("#content").removeClass("busy");
				}

				
		});

		var storeModal = new $.UIkit.modal.Modal("#storeModal");

		$("#storesTable").on("dblclick", "tbody tr", function(){
			var table = $("#storesTable").dataTable();
			var rowData = table.fnGetData( this );

			var form = $("#storeForm");
			form.find("legend").html('<i class="uk-icon-edit"></i> Edit Store');
			$.each( rowData, function(i,e){
				form.find("[name=" + i + "]").val( e );
			});
			form.data("id",rowData.id);

			$(this).addClass("selected").siblings(".selected").removeClass("selected", "");

			storeModal.show();
			
		});

		$("#btnCancelStore").click(function(){
			var form = $("#storeForm").removeData("id");

			$.each( form.find("input"), function(i,e){
				$(e).val("");
			});

			storeModal.hide();	

			$("#storesTable tbody tr.selected").removeClass("selected");
		});

		$("#btnNewStore").click(function(){
			var form = $("#storeForm").removeData("id");
			$.each( form.find("input"), function(i,e){
					$(e).val("");
				});
			form.find("legend").html('<i class="uk-icon-building-o"></i>  New Store');

			storeModal.show();
		});

		$("#btnSaveStore").click(function(){
			var form = $(this).closest("form");
			if ( form.data("id") ){
				//call update
				$.ajax({
					url:"api/stores/" + form.data("id"),
					method: "PUT",
					data:form.serializeObject(),
					success:function(data){
						console.log(data);
						if(data){
							$(window).trigger("hashchange");
							$("#btnCancelStore").trigger("click");
						}
					}
				});
			}
			else {
				$.ajax({
					url:"api/stores",
					method: "POST",
					data:form.serializeObject(),
					success:function(data){
						console.log(data);
						if(data){
							$(window).trigger("hashchange");
							$("#btnNewStore").trigger("click");
						}
					}
				});
			}
		});

</script>

<div class="uk-width-1-1 float">
	<table class="uk-table datatable" id="storesTable" width="100%">
		<thead>
			<tr>
				<th>Store Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>ZIP</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<div class="control-bar">
		<button type="button" class="uk-button" id="btnNewStore"><i class="uk-icon-building-o"></i> New</button>
	</div>
</div>
<div id="storeModal" class="uk-modal" style="display: none;">
    <div class="uk-modal-dialog uk-modal-dialog-slide" style="width: 300px; margin-left: -150px;">
        <a href="" class="uk-modal-close uk-close"></a>
        <form class="uk-form" id="storeForm">

	     <fieldset>
	    	<legend><i class="uk-icon-edit"></i> Edit Store</legend>
	        <div class="uk-form-row"><input type="text" placeholder="Store Name" name="name"/></div>
	        <div class="uk-form-row"><input type="text" placeholder="Store Address" name="address"/></div>
	        <div class="uk-form-row"><input type="text" placeholder="Store Address 2" name="address2"/></div>
	        <div class="uk-form-row">
	        	<input type="text" placeholder="City" name="city"/>
	        	 <select name="state">
		            <option value="AL">AL</option>
					<option value="AK">AK</option>
					<option value="AZ">AZ</option>
					<option value="AR">AR</option>
					<option value="CA">CA</option>
					<option value="CO">CO</option>
					<option value="CT">CT</option>
					<option value="DE">DE</option>
					<option value="DC">DC</option>
					<option value="FL">FL</option>
					<option value="GA">GE</option>
					<option value="HI">HI</option>
					<option value="ID">ID</option>
					<option value="IL">IL</option>
					<option value="IN">IN</option>
					<option value="IA">IA</option>
					<option value="KS">KS</option>
					<option value="KY">KY</option>
					<option value="LA">LA</option>
					<option value="ME">ME</option>
					<option value="MD">MD</option>
					<option value="MA">MA</option>
					<option value="MI">MI</option>
					<option value="MN">MN</option>
					<option value="MS">MS</option>
					<option value="MO">MO</option>
					<option value="MT">MT</option>
					<option value="NE">NE</option>
					<option value="NV">NV</option>
					<option value="NH">NH</option>
					<option value="NJ">NJ</option>
					<option value="NM">NM</option>
					<option value="NY">NY</option>
					<option value="NC">NC</option>
					<option value="ND">ND</option>
					<option value="OH">OH</option>
					<option value="OK">OK</option>
					<option value="OR">OR</option>
					<option value="PA">PA</option>
					<option value="RI">RI</option>
					<option value="SC">SC</option>
					<option value="SD">SD</option>
					<option value="TN">TN</option>
					<option value="TX">TX</option>
					<option value="UT">UT</option>
					<option value="VT">VT</option>
					<option value="VA">VA</option>
					<option value="WA">WA</option>
					<option value="WV">WV</option>
					<option value="WI">WI</option>
					<option value="WY">WY</option>
		        </select>
	        </div>
	        <div class="uk-form-row"><input type="text" placeholder="ZIP" name="zip"/></div>
			<div class="uk-form-row control-bar">

	         	<!--<button type="button" class="uk-button"><i class="uk-icon-asterisk"></i> Reset Password</button>-->

	         	<button type="button" class="uk-button" id="btnCancelStore"><i class="uk-icon-times"></i></button>

	         	<button type="button" class="uk-button" id="btnSaveStore"><i class="uk-icon-save"></i></button>

	         </div>

	    </fieldset>

	</form>
    </div>
</div>