    // -------   Mail Send ajax

     $(document).ready(function() {
        var form = $('#myForm'); // contact form
        var submit = $('.submit-btn'); // submit button
        var alert = $('.alert-msg'); // alert div for show alert message

        // form submit event
        form.on('submit', function(e) {
            e.preventDefault(); // prevent default form submit

            $.ajax({
                url: 'mail.php', // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: form.serialize(), // serialize form data
                beforeSend: function() {
                    alert.fadeOut();
                    submit.html('Sending....'); // change submit button text
                },
                success: function(data) {
                    alert.html(data).fadeIn(); // fade in response data
                    form.trigger('reset'); // reset form
                    submit.attr("style", "display: none !important");; // reset submit button text
                },
                error: function(e) {
                    console.log(e)
                }
            });
        });
    });

      $("#ship-box").click(function(){
        if(this.checked){
            $("#renting_SurName").val($("#billing_SurName").val());
            $("#renting_OtherNames").val($("#billing_OtherNames").val());
            $("#renting_Mobile").val($("#billing_Mobile").val());
            $("#renting_OtherContact").val($("#billing_OtherContact").val());
            $("#renting_City").val($("#billing_City").val());
        }else{
            $("#renting_SurName").val('');
            $("#renting_OtherNames").val('');
            $("#renting_Mobile").val('');
            $("#renting_OtherContact").val('');
            $("#renting_City").val('');
        }
    });

    function selectPaymentMethod(){
    if($('#flutterwave').is(':checked') || $('#ipay').is(':checked') || $('#COD').is(':checked')){
        //  alert("checked");
    }else{
        alert("Please select Payment Method");
        return false;
    }

}

    $(".changeImage").click(function(){
        var Image = $(this).attr('src');
        $(".mainImage").attr("src",Image);
    });

      $(document).ready(function(){
        
        $("#SelType").change(function(){
            var idServiceType = $(this).val();
            if(idServiceType == ""){
                return false;
            }
            $.ajax({
                type:'get',
                url:'/get-service-Price',
                data:{idServiceType:idServiceType},
                success:function(resp){
                   $("#getServicePrice").html("GHS "+resp);
                $("#ServicePrice").val(arr[0]);
                    if(arr[1]==0){
                        $("#cartbutton").hide();
                        $("#Availability").text("Sold Out");
                    }else{
                        $("#cartbutton").show();
                        $("#Availability").text("Available for renting");
                    }
                    $("#ServicePrice").val(arr[0]);
                },error:function(){
                    alert("Error");
                }
            });
        });
    });

     $("#current_pwd").keyup(function(){
		var current_pwd = $(this).val();
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			type:'post',
			url:'/check-user-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				//alert(resp);
                if(resp=="false"){
					$("#chkPwd").html("<font color='red'>Current Password is Incorrect</font>");
				}else if(resp=="true"){
					$("#chkPwd").html("<font color='green'>Current Password is Correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});
    $("#passwordform").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});