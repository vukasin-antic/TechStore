(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top shadow-sm');
        } else {
            $('.nav-bar').removeClass('sticky-top shadow-sm');
        }
    });


    // Hero Header carousel
    $(".header-carousel").owlCarousel({
        items: 1,
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: false,
        loop: true,
        margin: 0,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // ProductList carousel
    $(".productList-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        dots: false,
        loop: true,
        margin: 25,
        nav : true,
        navText : [
            '<i class="fas fa-chevron-left"></i>',
            '<i class="fas fa-chevron-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:2
            },
            1200:{
                items:3
            }
        }
    });

    // ProductList categories carousel
    $(".productImg-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: false,
        loop: true,
        items: 1,
        margin: 25,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // Single Products carousel
    $(".single-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        dots: true,
        dotsData: true,
        loop: true,
        items: 1,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });


    // ProductList carousel
    var relatedCarousel = $(".related-carousel");
    if (relatedCarousel.length) {
        var count = parseInt(relatedCarousel.data('count'));
        relatedCarousel.owlCarousel({
            autoplay: false,
            smartSpeed: 1500,
            dots: false,
            loop: count > 3,
            margin: 25,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            responsiveClass: true,
            responsive: {
                0: { items: 1 },
                576: { items: 1 },
                768: { items: 2 },
                992: { items: 3 },
                1200: { items: 4 }
            }
        });
    }


   // Back to top button
   $(window).scroll(function () {
    if ($(this).scrollTop() > 300) {
        $('.back-to-top').fadeIn('slow');
    } else {
        $('.back-to-top').fadeOut('slow');
    }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });




    // MOJ JS [AJAX]

    $('.inventory-table').each(function(){
        $(this).find('tr:even').css('background-color','#f8f9fa')
    });

    var promoApplied = false;

    window.showToast = function(message, success = true) {
        var toast = document.getElementById('cartToast');
        document.getElementById('toastMessage').innerHTML = message;
        toast.classList.remove('bg-primary', 'bg-danger');
        toast.classList.add(success ? 'bg-primary' : 'bg-danger');
        var bsToast = new bootstrap.Toast(toast, { delay: 5000 });
        bsToast.show();
    }

    function updateCartTotals(cartTotal) {
        $('#cart-subtotal').text(cartTotal + ' $');
        if (promoApplied) {
            var discount = cartTotal * 0.20;
            var finalTotal = cartTotal - discount;
            $('#cart-discount').text('-' + discount.toFixed(2) + ' $');
            $('#cart-total').text(finalTotal.toFixed(2) + ' $');
        } else {
            $('#cart-total').text(cartTotal + ' $');
        }
    }

// Add to Cart
    $(document).on('click', '.btn-add-to-cart', function() {
        var quantity = parseInt($('.quantity input').val()) || 0;
        if (quantity < 1) {
            showToast('Please select at least 1 item.', false);
            return;
        }
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                product_id: $(this).data('id'),
                quantity: quantity,
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-count').text(response.cartCount);
                    showToast(response.message);
                } else {
                    showToast(response.message, false);
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    var loginUrl = $('meta[name="login-url"]').attr('content');
                    showToast('Please login to add products to cart. <a href="' + loginUrl + '" class="text-white fw-bold">Login here</a>', false);
                } else {
                    console.log(xhr.responseText);
                }
            }
        });
    });

// Update quantity manually
    $(document).on('change', '.item-quantity', function(){
        var cartItemId = $(this).data('id');
        var newQuantity = $(this).val();

        $.ajax({
            url: '/cart/update/' + cartItemId,
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                quantity: newQuantity,
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-item-' + cartItemId + ' .item-quantity').val(response.quantity);
                    $('#item-total-' + cartItemId).text(response.itemTotal + ' $');
                    $('#cart-count').text(response.cartCount);
                    updateCartTotals(response.cartTotal);
                } else {
                    showToast(response.message, false);
                }
            }
        });
    });

// Update quantity with + and - buttons
    $(document).on('click', '.btn-plus, .btn-minus', function() {
        var cartItemId = $(this).data('id');
        var change = $(this).hasClass('btn-plus') ? 1 : -1;

        if (!cartItemId) {
            var input = $(this).closest('.quantity').find('input');
            var val = parseInt(input.val()) || 1;
            if ($(this).hasClass('btn-plus')) {
                input.val(val + 1);
            } else {
                if (val > 1) input.val(val - 1);
            }
            return;
        }

        $.ajax({
            url: '/cart/update/' + cartItemId,
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                change: change,
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-item-' + cartItemId + ' .item-quantity').val(response.quantity);
                    $('#item-total-' + cartItemId).text(response.itemTotal + ' $');
                    $('#cart-count').text(response.cartCount);
                    updateCartTotals(response.cartTotal);
                } else {
                    showToast(response.message);
                }
            }
        });
    });

// Remove item
    $(document).on('click', '.btn-remove', function() {
        var cartItemId = $(this).data('id');

        $.ajax({
            url: '/cart/remove/' + cartItemId,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.success) {
                    $('#cart-item-' + cartItemId).remove();
                    $('#cart-count').text(response.cartCount);
                    updateCartTotals(response.cartTotal);
                    if (response.cartCount == 0) {
                        location.reload();
                    }
                }
            }
        });
    });

// Apply promo code
    $('#applyPromo').on('click', function() {
        var code = $('#promoCode').val();

        if (!code) {
            $('#promoMessage').text('Please enter a promo code').addClass('text-danger');
            return;
        }

        $.ajax({
            url: '/cart/promo',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                code: code,
            },
            success: function(response) {
                if (response.success) {
                    promoApplied = true;
                    $('#promoMessage').text(response.message).removeClass('text-danger').addClass('text-success');
                    $('#discount-row').removeClass('d-none');
                    $('#cart-discount').text('-' + response.discount + ' $');
                    $('#cart-total').text(response.finalTotal + ' $');
                } else {
                    promoApplied = false;
                    $('#promoMessage').text(response.message).removeClass('text-success').addClass('text-danger');
                    $('#discount-row').addClass('d-none');
                    var cartTotal = parseFloat($('#cart-subtotal').text());
                    $('#cart-total').text(cartTotal + ' $');
                }
            }
        });
    });

    // Delete image
    $(document).on('click', '.btn-delete-image', function() {
        var imageId = $(this).data('id');
        var btn = $(this);

        $.ajax({
            url: '/admin/images/' + imageId,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.success) {
                    $('#image-' + imageId).remove();
                    showToast('Image deleted successfully!');
                } else {
                    showToast(response.message, false);
                }
            }
        });
    });

    // Set primary image
    $(document).on('click', '.btn-set-primary', function() {
        var imageId = $(this).data('id');

        $.ajax({
            url: '/admin/images/' + imageId + '/primary',
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                if (response.success) {
                    // Reset ALL to non-primary — find by looking at all image divs
                    $('[id^="image-"]').each(function() {
                        var id = $(this).find('[data-id]').data('id');
                        if (!id) {
                            // try to get from disabled span
                            id = $(this).find('.disabled').data('id');
                        }
                        if (id && id !== imageId) {
                            $(this).find('.btn-primary.disabled, .btn-set-primary').replaceWith(
                                `<button type="button"
                                     class="btn btn-sm btn-outline-primary w-100 btn-set-primary"
                                     data-id="${id}">
                                <i class="fas fa-star"></i>
                            </button>`
                            );
                        }
                    });

                    // Set clicked as primary
                    $('[id="image-' + imageId + '"]').find('.btn-set-primary').replaceWith(
                        `<span class="btn btn-sm btn-primary w-100 disabled" data-id="${imageId}">
                        <i class="fas fa-star"></i> Primary
                    </span>`
                    );

                    showToast('Primary image updated!');
                } else {
                    showToast(response.message, false);
                }
            }
        });
    });

})(jQuery);
