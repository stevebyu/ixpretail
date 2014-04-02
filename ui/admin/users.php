<script type="text/javascript">
	$.ajax({
		url:"api/users",
		method: "GET",
		success:function(data){
			$("#userTable").dataTable({
				"bDestroy": true,
		        "aaData": data,
		        "sDefaultContent": "--",
		        "sDom":'<"top"fi>rt<"bottom"p><"clear">',
		        "aDataLength": 10,
	        		"bDeferRender": true,
		        "aoColumns": [
		            { "sTitle": "Username", "mData": "username"},
		            { "sTitle": "First Name", "mData": "first_name" },
		            { "sTitle": "Last name", "mData": "last_name" },
		            { "sTitle": "Email", "mData": "email" },
		        ],
		        "oLanguage": {
				  "sSearch": "",
				  "sInfo": "_TOTAL_ users",
				  "sInfoFiltered": ""
				}
			});

			$(".dataTables_filter")
				.addClass("uk-form")
					.find(":text")
						.attr("placeholder", "Search Users...");

			$("#btnNewUser").prependTo("div.bottom").css("float","right");
			
		},
		error: function(){
			alert("Unable to load users.");
		},
		beforeSend: function(){
			$("#content").addClass("busy");
		},
		complete: function(){
			$("#content").removeClass("busy");
		}
	});

	var userModal = new $.UIkit.modal.Modal("#userModal");

	$("#userTable").on("dblclick", "tbody tr", function(){
		var table = $("#userTable").dataTable();
		var rowData = table.fnGetData( this );

		var form = $("#userForm");
		form.find("legend").html('<i class="uk-icon-edit"></i> Edit User');
		$.each( rowData, function(i,e){
			form.find("[name=" + i + "]").val( e );
		});
		form.data("id",rowData.id);

		$(this).addClass("selected").siblings(".selected").removeClass("selected", "");

		userModal.show();
		
	});

	$("#btnCancelUser").click(function(){
		var form = $("#userForm").removeData("id");

		$.each( form.find("input"), function(i,e){
			$(e).val("");
		});

		userModal.hide();	

		$("#userTable tbody tr.selected").removeClass("selected");
	});

	$("#btnNewUser").click(function(){
		var form = $("#userForm").removeData("id");
		$.each( form.find("input"), function(i,e){
				$(e).val("");
			});
		form.find("legend").html('<i class="uk-icon-user"></i> New User');

		userModal.show();
	});

	$("#btnSaveUser").click(function(){
		var form = $(this).closest("form");
		if ( form.data("id") ){
			//call update
			$.ajax({
				url:"api/users/" + form.data("id"),
				method: "PUT",
				data:form.serializeObject(),
				success:function(data){
					console.log(data);
					if(data){
						$(window).trigger("hashchange");
						$("#btnCancelUser").trigger("click");
					}
				}
			});
		}
		else {
			$.ajax({
				url:"api/users",
				method: "POST",
				data:form.serializeObject(),
				success:function(data){
					console.log(data);
					if(data){
						$(window).trigger("hashchange");
						$("#btnNewUser").trigger("click");
					}
				}
			});
		}
	});
</script>

<div class="uk-width-1-1 float">
	<table class="uk-table datatable" id="userTable" width="100%">
		<thead>
			<tr>
				<th>Username</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<div class="control-bar">
	<button type="button" class="uk-button" id="btnNewUser"><i class="uk-icon-user"></i> New</button>
	</div>
</div>
<div id="userModal" class="uk-modal" style="display: none;">
    <div class="uk-modal-dialog uk-modal-dialog-slide" style="width: 300px; margin-left: -150px;">
        <a href="" class="uk-modal-close uk-close"></a>
        <form class="uk-form" id="userForm">

	    <fieldset>

	    	<legend><i class="uk-icon-edit"></i> Edit User</legend>

	    	<div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Username" name="username"></div>

	    	<div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="First Name" name="first_name"></div>

	    	<div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Last Name" name="last_name"></div>

	        <div class="uk-form-row"><input type="text" class="uk-width-1-1" placeholder="Email" name="email"></div>

	        <div class="uk-form-row control-bar">

	         	<!--<button type="button" class="uk-button"><i class="uk-icon-asterisk"></i> Reset Password</button>-->

	         	<button type="button" class="uk-button" id="btnCancelUser"><i class="uk-icon-times"></i></button>

	         	<button type="button" class="uk-button" id="btnSaveUser"><i class="uk-icon-save"></i></button>

	         </div>

	    </fieldset>

	</form>
    </div>
</div>