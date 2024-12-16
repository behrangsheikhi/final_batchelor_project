<!doctype html>
<html lang="en">
<head>
    @include('app.layouts.head-tag')
    @yield('head-tag')
</head>
<body>

@include('app.layouts.header')
<main id="main-body-one-col" class="main-body">
    @yield('content')
</main>

@include('app.layouts.footer')
@include('app.layouts.script')
@yield('script')


@include('admin.alerts.sweetalert.success')
@include('admin.alerts.sweetalert.error')
@include('admin.alerts.sweetalert.delete-confirm')
@include('admin.alerts.toast.index')

<script type="text/javascript">

    function showToastrMessage(message, type) {
        toastr.options.timeOut = 5000;
        toastr.options.positionClass = "toast-top-right";
        toastr.options.progressBar = true;
        switch (type) {
            case "success":
                toastr.success(message);
                break;
            case "error":
                toastr.error(message);
                break;
            case "warning":
                toastr.warning(message);
                break;
            default:
                toastr.info(message);
        }
    }

    function removeFromCart(id) {
        const url = $("#" + id).data("url-remove");
        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    console.log(response)
                    console.log(response)
                    $("#" + id).closest('.cart-item').remove();
                    showToastrMessage(response.message, response.alertType); // Display toast message
                    if (response.totalPrice !== undefined) {
                        updateCartTotal(response.totalPrice); // Update the cart total price if totalPrice is defined
                    }
                } else {
                    alert('hi3')
                    console.log(response)
                    showToastrMessage(response.message, response.alertType); // Display error message
                }
            },
            error: function () {
                showToastrMessage("مشکلی در ارتباط با سرور وجود دارد.", "error"); // Display error message
            }
        });
    }

    $(document).ready(function () {
        $(document).on('click', '.product-add-to-cart button', function (event) {
            event.preventDefault();
            const url = $(this).data('url');
            const element = $(this);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                success: function (response) {
                    if (response.status) {
                        // Ensure `cartCount` is valid before updating
                        if (typeof response.cartCount === 'number' && !isNaN(response.cartCount)) {
                            let cartCount = response.cartCount;
                            let persianCartCount = toFarsiNumber(cartCount);
                            const cartCountElement = $('#cart-items-count');

                            // Update the text of the cart count
                            cartCountElement.text(persianCartCount);

                            // Add or remove the 'cart-qty' class based on the cart count
                            if (cartCount > 0) {
                                cartCountElement.addClass('cart-qty');
                            } else {
                                cartCountElement.removeClass('cart-qty');
                            }

                            // Update the cart content in the header dropdown
                            $('#cart-items-list').html(response.cartContent);
                        }

                        // Update icon or display state to show item was added/removed
                        if (response.added) {
                            element.children().first().addClass('text-danger');
                            element.attr('data-original-title', 'حذف از سبد خرید');
                        } else {
                            element.children().first().removeClass('text-danger');
                            element.attr('data-original-title', 'افزودن به سبد خرید');
                        }

                        // Show a notification
                        showToastrMessage(response.message, response.alertType);
                    } else {
                        showToastrMessage(response.message, response.alertType);
                    }
                },


                error: function (jqXHR, textStatus, errorThrown) {
                    showToastrMessage('مشکلی پیش آمده است. لطفا اتصال اینترنت خود را بررسی و دوباره امتحان کنید.');
                }
            });
        });


    });

</script>
</body>
</html>
