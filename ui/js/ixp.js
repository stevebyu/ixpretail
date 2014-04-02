$(function(){

	$("form").validate();

	$("body").on("click", "nav a", function(evt){
		
		if ( $(this).attr("href") == "logout" ){
			return;
		}

		evt.preventDefault();

		var that = $(this);

		var target = $(this).closest("nav").is(".main") ? $("#mainContent") : $("#content");

		$.ajax({
			url: $(this).attr("href"),
			method: "GET",
			beforeSend: function(){
				//target.addClass("busy");
			},
			complete: function(){
				//target.removeClass("busy");
			},
			success: function(data){
				target
					.empty()
						.append(data);

				that
					.closest("nav")
						.find("li")
							.removeClass("uk-active");
				that
					.closest("li")
						.addClass("uk-active");

			},
			error: function(data){
				alert("Unable to load page.");
			}
		});

	});

	$(".datatable").dataTable();


/*************************************************************
*			SETTINGS ACCOUNT
*************************************************************/

	$("#btnSaveAccount").click(function(){
		var form = $(this).closest("form");
			//call update
			$.ajax({
				url:"/api/users/" + user.id,
				method: "PUT",
				data:form.serializeObject(),
				success:function(data){
					console.log(data);
					if(data){
						$(window).trigger("hashchange");
					}
				}
			});
	});

/*************************************************************
*			MANAGE USERS
*************************************************************/



});

var inits = {
	locations: function(){
		$.ajax({
				url:"/api/locations",
				method: "GET",
				success:function(data){
					if(!data){return;}
					data = JSON.parse(data);
					$("#locationTable").dataTable({
						"bDestroy": true,
				        "aaData": data,
				        "sDefaultContent": "--",
				        "sDom":'<"top"fi>rt<"bottom"p><"clear">',
				        "aDataLength": 10,
  	            		"bDeferRender": true,
				        "aoColumns": [
				            { "sTitle": "Store Name", "mData": "name"},
				            { "sTitle": "DHL Account", "mData": "dhl_account" },
				            { "sTitle": "Address", "mData": "address" }
				        ],
				        "oLanguage": {
						  "sSearch": "Filter: "
						}
					});
					console.log(data);
				}
		});
	}
}


var engine = {

	_pages: null,

	init: function(){
		this._pages = $(".page, .section");

		var that = this;
		$(window).on("hashchange", function(){
			that.navigateTo( window.location.hash );
		});
	},

	_parseHash: function(hash){
		return window.location.hash.replace("#","").split("-");
	},

	_setActive: function(page){
		
		if (page){

			this._pages
				.filter("#" + page)
					.addClass("active");
		
		}

	},

	_switchPages: function(){
		var actives = this._pages.filter(".active");
		var inactives = this._pages.filter(":not(.active)");
//		actives.siblings(":not(:visible)").hide();

		var showActives = function(){
			actives
				.fadeIn("fast", function(){
					if ( typeof inits[ $(this).attr("id") ] === "function" ){
						inits[ $(this).attr("id") ]();
					}
				});
		};

		if ( actives.siblings(":visible").length ){
			inactives
				.filter(":visible")
					.fadeOut("fast", function(){

						if ( !actives.siblings(":animated").length ){
							showActives();
						}

					});
		}

		else{
			showActives();
		}

	},

	navigateTo:  function(hash){
		var tree = this._parseHash(hash);

		this._pages
			.removeClass("active");

		for (i = tree.length - 1; i >= 0; i--){
			this._setActive( tree[i] );
		}

		this._switchPages();

	}

};

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined && this.value != "") {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else if (this.value && this.value != ''){
            o[this.name] = this.value;
        }
    });
    return o;
};

var API = {

};
