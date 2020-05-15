/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});
$(document).ready(function () {
    //change price with changes size
    $("#selSize").change(function () {
        var idSize=$(this).val();
        if (idSize == "") {
            return false;
        }
        $.ajax({
            type:'get',
            url:'/get-product-price',
            data:{idSize:idSize},
            success:function (resp) {
                var arr=resp.split('#');
                $("#getPrice").html("BDT "+arr[0]);
                $("#price").val(arr[0]);
                if (arr[1]==0){
                    $("#cartButton").hide();
                    $("#Availability").text("Out Of Stock");
                }else{
                    $("#cartButton").show();
                    $("#Availability").text("In Stock");
                }
            },error:function () {
                alert("Error");
            }
        })
    })
});

//change main image with Alternate Image
$(document).ready(function () {
    $(".changeImage").click(function () {
        var image= $(this).attr('src');
       $(".mainImage").attr("src",image);
    });
});

// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();

// Setup thumbnails example
var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

$('.thumbnails').on('click', 'a', function(e) {
    var $this = $(this);

    e.preventDefault();

    // Use EasyZoom's `swap` method
    api1.swap($this.data('standard'), $this.attr('href'));
});

// Setup toggles example
var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

$('.toggle').on('click', function() {
    var $this = $(this);

    if ($this.data("active") === true) {
        $this.text("Switch on").data("active", false);
        api2.teardown();
    } else {
        $this.text("Switch off").data("active", true);
        api2._init();
    }
});

$().ready(function () {
    $("#registerForm").validate({
        rules:{
            name:{
                required:true,
                minlength:2,
                accept:"[a-zA-Z]+"
            },
            email:{
                required:true,
                email: true,
                remote:"/check-email"
            },
            password:{
                required:true,
                minlength:6,
            }
        },
        message:{
            name: {
                required:"Please Enter Your Name",
                minlength:"Your Name Must be at least 2 Characters Long",
                accept:"Your Name Must contain letters Only"
            },
            email:{
                required:"Please Enter Your Email",
                email:"Please Enter Valid Email",
                remote: "Email Already Exits"
            },
            password: {
                required:"Please Provide Your password",
                minlength:"Your Password must be at least 6 characters long"
            }
        }
    });
    //login form validation
    $("#loginForm").validate({
        rules:{
            email:{
                required:true,
                email: true,
            },
            password:{
                required:true,
            }
        },
        message:{

            email:{
                required:"Please Enter Your Email",
                email:"Please Enter Valid Email",
            },
            password: {
                required:"Please Provide Your password",
            }
        }
    });
    //strong password set
    $('#myPassword').passtrength({
        minChars: 4,
        passwordToggle: true,
        tooltip: true,
        eyeImg:"/images/frontend_image/eye.svg"
    });
    //check user current password
    // $('#current_pwd').keyup(function () {
    //     var current_pwd=$(this).val();
    //     $.ajax({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         type:'get',
    //         url: '/check-user-pwd',
    //         data: {current_pwd:current_pwd},
    //         success:function (resp) {
    //             if (resp =='false') {
    //                 $("#chkPwd").html("<font color='red'>Current Password Is Incorrect</font>")
    //             }else if (resp=='true') {
    //                 $("#chkPwd").html("<font color='green'>Current Password Is Correct</font>")
    //             }
    //         },error:function () {
    //             alert('Error');
    //         }
    //     })
    // })
    $("#passwordForm").validate({
        rules:{
            current_pwd:{
                required: true,
                minlength:6,
                maxlength:20
            },
            new_password:{
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
});
$(document).ready(function () {
    $("#current_pwd").keyup(function () {
        var current_pwd= $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url:'/check-user-pwd',
            data:{current_pwd:current_pwd},
            success:function (resp) {
                if (resp=='false') {
                    $("#chkPwd").html("<font color='red'>Current Password Is Incorrect</font>");
                }else if (resp=='true') {
                    $("#chkPwd").html("<font color='green'>Current Password Is Correct</font>");
                }
            },error:function () {
                alert("Error");
            }
        })

    })
});

