<script type='text/javascript' id='contact-form-7-js-extra'>
    /* <![CDATA[ */
    var wpcf7 = {"apiSettings":{"root":"https:\/\/demo.missterry.vn\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"}};
    /* ]]> */
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.3/mobile-detect.min.js"></script>
<script type='text/javascript' src='https://demo.missterry.vn/wp-content/plugins/contact-form-7/includes/js/scripts.js?ver=5.3.1' id='contact-form-7-js'></script>
<script type='text/javascript' src='https://demo.missterry.vn/wp-content/themes/flatsome/inc/extensions/flatsome-live-search/flatsome-live-search.js?ver=3.13.0' id='flatsome-live-search-js'></script>
<script type='text/javascript' src='https://demo.missterry.vn/wp-includes/js/hoverIntent.min.js?ver=1.8.1' id='hoverIntent-js'></script>
<script type='text/javascript' id='flatsome-js-js-extra'>
    /* <![CDATA[ */
    var flatsomeVars = {"ajaxurl":"https:\/\/demo.missterry.vn\/wp-admin\/admin-ajax.php","rtl":"","sticky_height":"68","lightbox":{"close_markup":"<button title=\"%title%\" type=\"button\" class=\"mfp-close\"><svg xmlns=\"http:\/\/www.w3.org\/2000\/svg\" width=\"28\" height=\"28\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\" class=\"feather feather-x\"><line x1=\"18\" y1=\"6\" x2=\"6\" y2=\"18\"><\/line><line x1=\"6\" y1=\"6\" x2=\"18\" y2=\"18\"><\/line><\/svg><\/button>","close_btn_inside":false},"user":{"can_edit_pages":false},"i18n":{"mainMenu":"Main Menu"},"options":{"cookie_notice_version":"1"}};
    /* ]]> */
</script>
<script type='text/javascript' src='https://demo.missterry.vn/wp-content/themes/flatsome/assets/js/flatsome.js?ver=3.13.0' id='flatsome-js-js'></script>
<script type='text/javascript' src='https://demo.missterry.vn/wp-includes/js/wp-embed.min.js?ver=5.6' id='wp-embed-js'></script>

<script src="{!! asset('theme/missterry/plugin/Modal-Popup-Plugin-jQuery-Mobilepopup/plugins/highlightjs/highlight.min.js') !!}"></script>
<script src="{!! asset('theme/missterry/plugin/Modal-Popup-Plugin-jQuery-Mobilepopup/src/mobilepopup.min.js') !!}"></script>


<script>
    jQuery(document).ready(function () {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':jQuery('meta[name="csrf-token"]').attr('content'),
            },
            error: function (jqXHR, exception) {
                // if (jqXHR.status === 0) {
                //     alert('Not connect.\n Verify Network.');
                // } else if (jqXHR.status == 404) {
                //     alert('Requested page not found. [404]');
                // } else if (jqXHR.status == 500) {
                //     alert('Internal Server Error [500].');
                // } else if (exception === 'parsererror') {
                //     alert('Requested JSON parse failed.');
                // } else if (exception === 'timeout') {
                //     alert('Time out error.');
                // } else if (exception === 'abort') {
                //     alert('Ajax request aborted.');
                // } else {
                //     alert('Uncaught Error.\n' + jqXHR.responseText);
                // }
            }
        });

    });
</script>


@stack('scriptsTop')
@stack('scripts')
@section('extra-script')
@show
<script>
    (function () {
        var md = new MobileDetect(window.navigator.userAgent);
        var platform;
        function elementInViewport(el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top    >= 0
                && rect.left   >= 0
                && rect.top <= (window.innerHeight || document.documentElement.clientHeight)
            )
        }
        if (md.tablet()) {
            console.log('tablet');
            platform = 'tablet';
        } else if (md.mobile()) {
            console.log('mobile');
            platform = 'mobile';
        } else {
            console.log('pc');
            platform = 'pc';
        }
        let images = [...document.querySelectorAll('[lazy=load]')];
        let images_scroll = [...document.querySelectorAll('[lazy=scroll]')];
        const interactSettings = {
            root: document.querySelector('body'),
            rootMargin: '0px 0px 200px 0px'
        };
        var GetNameFile = function (str) {
            return str.split('\\').pop().split('/').pop();
        }
        function loadImage(image,cb,i) {
            let src = "";
            let _platform = platform;
            if (_platform === 'mobile') {
                if (image.dataset.hasOwnProperty('mobile')) {
                    src = image.dataset.mobile;
                } else {
                    _platform = 'tablet';
                }
            }
            if (_platform === 'tablet') {
                if (image.dataset.hasOwnProperty('tablet')) {
                    src = image.dataset.tablet;
                } else {
                    _platform = 'pc';
                }
            }
            if (_platform === 'pc') {
                src = image.dataset.src
            }
            image.removeAttribute('lazy');
            image.src = src;
            console.log( image.src );
            image.onload = () => {
                image.classList.add('loaded');
                image.removeAttribute('width');
                image.removeAttribute('height');

                if(cb) cb(i);
            };
        }
        function onIntersection(imageEntites) {
            imageEntites.forEach(image => {
                if (image.isIntersecting) {
                    observer.unobserve(image.target);
                    loadImage( image.target,function () {

                    },0);
                }
            });
        }
        let observer = new IntersectionObserver(onIntersection, interactSettings);
        images.forEach(image => observer.observe(image));
        function processScroll(){

            for (let i = 0; i < images_scroll.length; i++) {
                if(!images_scroll[i].classList.contains('loaded')){
                    if(elementInViewport(images_scroll[i]))  {
                        loadImage(images_scroll[i],function (i) {
                        },i);
                    }
                }
            }
            for (let i = 0; i < images_scroll.length; i++) {
                if(images_scroll[i].classList.contains('loaded')){
                    images_scroll.splice(i, 1);
                }
            }
            if(images_scroll.length === 0){
                removeEventListener('scroll',processScroll);
            }
        }
        processScroll();
        addEventListener('scroll',processScroll);
    });
    (function () {
        var md = new MobileDetect(window.navigator.userAgent);
        var platform;
        if (md.tablet()) {
            console.log('tablet');
            platform = 'tablet';
        } else if (md.mobile()) {
            console.log('mobile');
            platform = 'mobile';
        } else {
            console.log('pc');
            platform = 'pc';
        }
        document.addEventListener("DOMContentLoaded", function() {
            let lazyImages = [].slice.call(document.querySelectorAll('[lazyload=on]'));
            let active = false;
            function CheckLoadImg(lazyImage) {
                if(lazyImage.getAttribute("lazytype") === "load") return true;
                return (
                    lazyImage.getBoundingClientRect().top <= window.innerHeight &&
                    lazyImage.getBoundingClientRect().bottom >= 0) &&
                    getComputedStyle(lazyImage).display !== "none";
            }
            const lazyLoad = function() {
                if (active === false) {
                    active = true;
                    setTimeout(function() {
                        lazyImages.forEach(function(lazyImage) {
                            if (CheckLoadImg(lazyImage)) {
                                let src = "";
                                let _platform = platform;
                                if (_platform === 'mobile') {
                                    if (lazyImage.dataset.hasOwnProperty('mobile')) {
                                        src = lazyImage.dataset.mobile;
                                    } else {
                                        _platform = 'tablet';
                                    }
                                }
                                if (_platform === 'tablet') {
                                    if (lazyImage.dataset.hasOwnProperty('tablet')) {
                                        src = lazyImage.dataset.tablet;
                                    } else {
                                        _platform = 'pc';
                                    }
                                }
                                if (_platform === 'pc') {
                                    src = lazyImage.dataset.src
                                }
                                lazyImage.src =src;

                                if(lazyImage.dataset.hasOwnProperty('lazyImage.dataset')){
                                    lazyImage.srcset = lazyImage.dataset.srcset;
                                }

                                lazyImage.classList.add('loaded');
                                lazyImages = lazyImages.filter(function(image) {
                                    return image !== lazyImage;
                                });
                                lazyImage.onload = () => {
                                    lazyImage.classList.remove('loaded');
                                    lazyImage.removeAttribute('width');
                                    lazyImage.removeAttribute('height');
                                };
                                if (lazyImages.length === 0) {
                                    document.removeEventListener("scroll", lazyLoad);
                                    window.removeEventListener("resize", lazyLoad);
                                    window.removeEventListener("orientationchange", lazyLoad);
                                }
                            }
                        });
                        active = false;
                    }, 1);
                }
            };
            lazyLoad();
            document.addEventListener("scroll", lazyLoad);
            window.addEventListener("resize", lazyLoad);
            window.addEventListener("orientationchange", lazyLoad);
        });
    })();
    // $(function () {
    //    $(document).ready(function () {
    //       $(".edit-text").each(function () {
    //           $(this).hover(
    //               function() {
    //                   $(this).html($('<textarea  style="z-index: 999999;color:#000;width:'+($(this).width())+'px;height: '+($(this).height()*1.8)+'px;">'+($(this).text())+'</textarea>'));
    //               }, function() {
    //                   var val = $( this ).find("textarea").val();
    //                   $( this ).html(val);
    //               }
    //           );
    //       });
    //    });
    // });
</script>
</body>
</html>