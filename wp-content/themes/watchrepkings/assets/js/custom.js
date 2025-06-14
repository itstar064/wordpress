jQuery(document).ready(function($) {


	 // Open cart on ATC
	 $(document.body).on('added_to_cart', function() {
        $('#mini-cart-sidebar').addClass('active');
        $('body').addClass('active');
    });

    // Close cart
    $('.close-mini-cart, .mini-cart-overlay').on('click', function() {
        $('#mini-cart-sidebar').removeClass('active');
		$('body').removeClass('active');
    });

    // Remove View Cart Button
    $(document.body).on('added_to_cart', function(event, fragments, cart_hash, button) {
        $('.added_to_cart').remove();
    });


	$("p").each(function() {
		let text = $(this).text().trim();
		
		// Normalize spaces and remove special characters
		text = text.replace(/\s+/g, " "); // Replace multiple spaces with a single space

		if (text === "By Atty. Henry Moyal") {
			$(this).addClass("by-author");
		}
	});


	
	if($('.home-banner-slide').length > 0) {
		$('.home-banner-slide').slick({
			dots: true,
			arrows: false,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 8000,
			speed: 300,
			slidesToShow: 1,
			slidesToScroll: 1,
		});
	}
	
	if($('.home-blog-slider').length > 0) {
		$('.home-blog-slider').slick({
			dots: true,
			arrows: true,
			infinite: true,
			autoplay: true,
			autoplaySpeed: 8000,
			speed: 300,
			slidesToShow: 3,
			slidesToScroll: 1,
			prevArrow: '<div class="slick-prev"><i class="fa fa-angle-left" aria-hidden="true"></i></div>',
			nextArrow: '<div class="slick-next"><i class="fa fa-angle-right" aria-hidden="true"></i></div>',
		});
	}
	
	
	if($('.single-testimonial').length > 0) {
		$(function () {
			$(".single-testimonial").slice(0, 9).show();
			$("#loadMore").on('click', function (e) {
				e.preventDefault();
				$(".single-testimonial:hidden").slice(0, 3).slideDown();
				if ($(".single-testimonial:hidden").length == 0) {
					$("#loadMore").fadeOut('slow');
				}
			});
		});
	}
	
	if($('.single-gallery-img').length > 0) {
		$(function () {
			$(".single-gallery-img").slice(0, 12).show();
			$("#loadMore").on('click', function (e) {
				e.preventDefault();
				$(".single-gallery-img:hidden").slice(0, 6).slideDown();
				if ($(".single-gallery-img:hidden").length == 0) {
					$("#loadMore").fadeOut('slow');
				}
			});
		});
	}
	
	if($('.blog-single-grid').length > 0) {
		$(function () {
			$(".blog-single-grid").slice(0, 6).show();
			$("#loadMore").on('click', function (e) {
				e.preventDefault();
				$(".blog-single-grid:hidden").slice(0, 6).slideDown();
				if ($(".blog-single-grid:hidden").length == 0) {
					$("#loadMore").fadeOut('slow');
				}
			});
		});
	}
	
	$(".brand-fltrr .brand-toggle").click(function () {
		$(this).toggleClass("active"); // Toggle active class on the clicked button
		$(this).next(".brand-content").slideToggle();
		
		$(".brand-toggle").not(this).removeClass("active"); // Remove active class from other buttons
		$(".brand-content").not($(this).next()).slideUp();
	});


	 $(document).on("click", ".comment-form-rating .stars", function (e) {
		  	
		  alert("dsf")
		  	
	  });

});

document.addEventListener('DOMContentLoaded', function() {
    if (window.hideYTActivated) return;

    let onYouTubeIframeAPIReadyCallbacks = [];

    for (let playerWrap of document.querySelectorAll(".hytPlayerWrap")) {
        let playerFrame = playerWrap.querySelector(".hytPlayerWrap iframe");
        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        let player; // Declare player outside to reuse after reload

        let onPlayerStateChange = function(event) {
            if (event.data == YT.PlayerState.ENDED) {
                playerWrap.classList.add("ended");
                playerWrap.classList.remove("playing", "paused");
                resetIframe(); // Custom function to handle reload
            } else if (event.data == YT.PlayerState.PAUSED) {
                playerWrap.classList.add("paused");
                playerWrap.classList.remove("playing", "ended");
            } else if (event.data == YT.PlayerState.PLAYING) {
                playerWrap.classList.add("playing");
                playerWrap.classList.remove("ended", "paused");
            }
        };

        function resetIframe() {
            let newIframe = playerFrame.cloneNode();  // Clone the iframe
            playerFrame.replaceWith(newIframe);       // Replace it with the new one
            playerFrame = newIframe;                  // Update reference
            initializePlayer();                       // Reinitialize the player
        }

        function initializePlayer() {
            player = new YT.Player(playerFrame, {
                events: {
                    'onStateChange': onPlayerStateChange
                }
            });
        }

        onYouTubeIframeAPIReadyCallbacks.push(initializePlayer);

        playerWrap.addEventListener("click", function() {
            if (player && player.getPlayerState) {
                let playerState = player.getPlayerState();
                if (playerState == YT.PlayerState.ENDED) {
                    player.seekTo(0);
                } else if (playerState == YT.PlayerState.PAUSED) {
                    player.playVideo();
                }
            }
        });
    }

    window.onYouTubeIframeAPIReady = function() {
        for (let callback of onYouTubeIframeAPIReadyCallbacks) {
            callback();
        }
    };

    window.hideYTActivated = true;
	
	
});
