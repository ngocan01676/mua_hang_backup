
    <title>Demo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="57x57" href="/theme/betogaizin/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/theme/betogaizin/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/theme/betogaizin/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/theme/betogaizin/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/theme/betogaizin/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/theme/betogaizin/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/theme/betogaizin/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/theme/betogaizin/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/theme/betogaizin/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/theme/betogaizin/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/theme/betogaizin/betogaizin/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/theme/betogaizin/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/theme/betogaizin/favicon-16x16.png">
    <link rel="manifest" href="/theme/betogaizin/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/theme/betogaizin/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="/theme/betogaizin/desktop/css/normalize.css">
    <link rel="stylesheet" href="/theme/betogaizin/desktop/css/style.css">
    <style>
        .category-menu-level02 , .category-menu-level03{
            display: none;
        }

        .is-active .category-menu-level02{
            display: block;
        }
        .is-active > .category-menu-level03{
            display: block !important;
        }
    </style>
    <link rel="stylesheet" href="{!! asset('/theme/betogaizin/plugins/EasyAutocomplete/easy-autocomplete.min.css') !!}">
    <style data-vue-ssr-id="bc665e54:0 68ee8c94:0 ea3b7714:0 fd547dac:0 6635373b:0 6bff294a:0 09b0fbd0:0 893e5ac8:0 1c4ef2a3:0 2aa3358a:0 7355a148:0 7e99d7e5:0 59ae5254:0 c3fecebe:0">
        /*! normalize.css v7.0.0 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,footer,header,nav,section{display:block}h1{font-size:2em;margin:.67em 0}figcaption,figure,main{display:block}figure{margin:1em 40px}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent;-webkit-text-decoration-skip:objects}abbr[title]{border-bottom:none;text-decoration:underline;-webkit-text-decoration:underline dotted;text-decoration:underline dotted}b,strong{font-weight:inherit;font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}dfn{font-style:italic}mark{background-color:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}audio,video{display:inline-block}audio:not([controls]){display:none;height:0}img{border-style:none}svg:not(:root){overflow:hidden}button,input,optgroup,select,textarea{font-family:sans-serif;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{display:inline-block;vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-cancel-button,[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details,menu{display:block}summary{display:list-item}canvas{display:inline-block}[hidden],template{display:none}
        .ps{overflow:hidden!important;overflow-anchor:none;-ms-overflow-style:none;touch-action:auto;-ms-touch-action:auto}.ps__rail-x{height:15px;bottom:0}.ps__rail-x,.ps__rail-y{display:none;opacity:0;transition:background-color .2s linear,opacity .2s linear;-webkit-transition:background-color .2s linear,opacity .2s linear;position:absolute}.ps__rail-y{width:15px;right:0}.ps--active-x>.ps__rail-x,.ps--active-y>.ps__rail-y{display:block;background-color:transparent}.ps--focus>.ps__rail-x,.ps--focus>.ps__rail-y,.ps--scrolling-x>.ps__rail-x,.ps--scrolling-y>.ps__rail-y,.ps:hover>.ps__rail-x,.ps:hover>.ps__rail-y{opacity:.6}.ps .ps__rail-x.ps--clicking,.ps .ps__rail-x:focus,.ps .ps__rail-x:hover,.ps .ps__rail-y.ps--clicking,.ps .ps__rail-y:focus,.ps .ps__rail-y:hover{background-color:#eee;opacity:.9}.ps__thumb-x{transition:background-color .2s linear,height .2s ease-in-out;-webkit-transition:background-color .2s linear,height .2s ease-in-out;height:6px;bottom:2px}.ps__thumb-x,.ps__thumb-y{background-color:#aaa;border-radius:6px;position:absolute}.ps__thumb-y{transition:background-color .2s linear,width .2s ease-in-out;-webkit-transition:background-color .2s linear,width .2s ease-in-out;width:6px;right:2px}.ps__rail-x.ps--clicking .ps__thumb-x,.ps__rail-x:focus>.ps__thumb-x,.ps__rail-x:hover>.ps__thumb-x{background-color:#999;height:11px}.ps__rail-y.ps--clicking .ps__thumb-y,.ps__rail-y:focus>.ps__thumb-y,.ps__rail-y:hover>.ps__thumb-y{background-color:#999;width:11px}@supports (-ms-overflow-style:none){.ps{overflow:auto!important}}@media (-ms-high-contrast:none),screen and (-ms-high-contrast:active){.ps{overflow:auto!important}}
        .slick-slider{box-sizing:border-box;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-touch-callout:none;-khtml-user-select:none;touch-action:pan-y;-webkit-tap-highlight-color:transparent}.slick-list,.slick-slider{position:relative;display:block}.slick-list{overflow:hidden;margin:0;padding:0}.slick-list:focus{outline:none}.slick-list.dragging{cursor:pointer;cursor:hand}.slick-slider .slick-list,.slick-slider .slick-track{transform:translateZ(0)}.slick-track{position:relative;top:0;left:0;display:block;margin-left:auto;margin-right:auto}.slick-track:after,.slick-track:before{display:table;content:""}.slick-track:after{clear:both}.slick-loading .slick-track{visibility:hidden}.slick-slide{display:none;float:left;height:100%;min-height:1px}[dir=rtl] .slick-slide{float:right}.slick-slide img{display:block}.slick-slide.slick-loading img{display:none}.slick-slide.dragging img{pointer-events:none}.slick-initialized .slick-slide{display:block}.slick-loading .slick-slide{visibility:hidden}.slick-vertical .slick-slide{display:block;height:auto;border:1px solid transparent}.slick-arrow.slick-hidden{display:none}
        .nuxt-progress{position:fixed;top:0;left:0;right:0;height:2px;width:0;opacity:1;transition:width .1s,opacity .4s;background-color:#3b8070;z-index:999999}.nuxt-progress.nuxt-progress-notransition{transition:none}.nuxt-progress-failed{background-color:red}
        .header-fixed{transition:none}
        .sggstFix{cursor:pointer;width:100%;margin-top:3px;border-radius:4px}span.sggstKeyword{width:100%!important}
        .header-utility-link li+li[data-v-defa9620]{border-left:none;padding-left:2px;box-sizing:border-box}.header-utility-link li[data-v-defa9620]{font-size:11px}.header-utility-link[data-v-defa9620],.header-utility-link.is-logout[data-v-defa9620]{width:196px}.header-utility-link-item[data-v-defa9620]{letter-spacing:-.6px;width:65px}.header-utility-link li .svg-icon[data-v-defa9620]{padding:30px 0 0}.max-374[data-v-defa9620]{display:none}@media (max-width:374px){.max-374[data-v-defa9620]{display:block}.min-375[data-v-defa9620]{display:none}}
        .search-modal[data-v-67a4658c]{display:block;position:fixed;width:100%;width:100vw;height:100%;padding:0;font-size:16px;top:0;left:0;z-index:5;background:#fff;overflow-y:scroll}.search-head[data-v-67a4658c]{display:table;width:97%;padding:10px 0 0 10px}.search-head--left[data-v-67a4658c]{display:table-cell}.search-head--left .form-parts-search input[data-v-67a4658c]{line-height:normal}.sp-keyword-delete-btn[data-v-67a4658c]{position:absolute;right:36px;top:0;width:36px;height:36px}.sp-keyword-delete-btn p .line[data-v-67a4658c]{position:absolute;display:block;width:14px;height:1px;background:#777}.sp-keyword-delete-btn p .line[data-v-67a4658c]:first-of-type{top:-2px;right:10px;transform:translateY(20px) rotate(-45deg)}.sp-keyword-delete-btn p .line[data-v-67a4658c]:nth-of-type(2){top:-2px;right:10px;transform:translateY(20px) rotate(45deg)}.search-head--right[data-v-67a4658c]{display:table-cell;font-size:12px;width:78px;color:#bf0000;vertical-align:middle;text-align:center}.search-content--title[data-v-67a4658c]{cursor:auto;font-size:12px;color:#848484}.search-wrapper[data-v-67a4658c]{padding:10px 0 0 10px}
        .margin-fix{margin:0 -10px}
        .loggedOutDisclaimer[data-v-35ade1f0]{background:#e8f7fc;padding:10px;color:#0071b9;margin-bottom:15px}.loggedOutDisclaimer a[data-v-35ade1f0]{text-decoration:underline}
        @media (min-width:768px){.introduction-top-page .banner[data-v-12143966]{max-width:925px;margin:0 auto}.introduction-top-page .feature[data-v-12143966]{text-align:left;padding:48px 48px 32px;background:url("/theme/betogaizin/banner/52ec82c638b7cee997a6.jpg") no-repeat;background-size:cover;height:360px;box-sizing:border-box;margin:15px 0}.introduction-top-page .feature-wrap[data-v-12143966]{display:flex}.introduction-top-page .feature-top[data-v-12143966]{background-repeat:no-repeat;background-size:cover;min-width:250px}.introduction-top-page .feature-title[data-v-12143966]{color:#000000;font-size:28px;padding-bottom:16px;font-weight:700}.introduction-top-page .feature-subTitle[data-v-12143966]{color:#828282;font-size:12px;padding-bottom:20px}.introduction-top-page .feature-subTitle a[data-v-12143966]{color:#828282!important;text-decoration:underline}.introduction-top-page .feature-btn[data-v-12143966]{border:1px solid #0a0;margin:0 auto;border-radius:4px;color:#0a0;background:#fff;text-align:center;width:350px;height:70px;line-height:70px;font-size:16px}.introduction-top-page .feature-btn .icon-new-user[data-v-12143966]{color:#0a0}.introduction-top-page .feature-btn .svg-icon[data-v-12143966]{padding-left:20px}.introduction-top-page .feature-btn .svg-icon[data-v-12143966]:after{background:url(img/new_user.svg) no-repeat!important;width:20px!important;height:20px!important}.introduction-top-page .feature-btn a[data-v-12143966]{width:100%;display:block}.introduction-top-page .feature-items[data-v-12143966]{padding-left:56px;width:100%}.introduction-top-page .feature-items-inner[data-v-12143966]{display:flex;width:100%;flex-wrap:wrap}.introduction-top-page .feature-item[data-v-12143966]{width:50%;display:flex;padding-bottom:32px}.introduction-top-page .feature-item img[data-v-12143966]{max-width:72px;max-height:72px}.introduction-top-page .feature-item-text[data-v-12143966]{color:#000000;display:flex;align-items:flex-start;padding:0 16px;font-size:16px;font-weight:700;flex-direction:column;justify-content:center;width:160px}.introduction-top-page .feature-item-text .text-detail[data-v-12143966]{width:100%}}@media (max-width:767px){.introduction-top-page[data-v-12143966]{margin:0 -10px}.introduction-top-page .title[data-v-12143966]{background:#e8f7fc;padding:10px;color:#0071b9}.introduction-top-page .banner[data-v-12143966]{margin:0 10px 15px}.introduction-top-page .banner[data-v-12143966]:first-child{margin-top:15px}.introduction-top-page .feature[data-v-12143966]{text-align:center;border-radius:4px}.introduction-top-page .feature-wrap[data-v-12143966]{padding-top:15px}.introduction-top-page .feature-top[data-v-12143966]{background-image:url(//sm.r10s.jp/contents/static/common/top/img/logout/bg.png);background-repeat:no-repeat;background-size:cover;height:275px}.introduction-top-page .feature-title[data-v-12143966]{color:#000000;font-size:19px;padding-bottom:10px;font-weight:700}.introduction-top-page .feature-subTitle[data-v-12143966]{color:#828282;font-size:12px;padding-bottom:20px}.introduction-top-page .feature-subTitle a[data-v-12143966]{color:#828282!important;text-decoration:underline}.introduction-top-page .feature-btn[data-v-12143966]{border:1px solid #0a0;width:200px;margin:0 auto;height:45px;border-radius:4px;line-height:45px;font-size:14px;font-weight:700;color:#0a0;background:#fff}.introduction-top-page .feature-btn .icon-new-user[data-v-12143966]{color:#0a0}.introduction-top-page .feature-btn .svg-icon[data-v-12143966]{padding-left:20px}.introduction-top-page .feature-btn .svg-icon[data-v-12143966]:after{background:url(img/new_user.svg) no-repeat!important;width:20px!important;height:20px!important}.introduction-top-page .feature-btn a[data-v-12143966]{width:100%;display:block}.introduction-top-page .feature-items[data-v-12143966]{margin:-60px 10px 0;padding:16px;background:#fff;box-shadow:0 1.25px 6px rgba(0,0,0,.2)}.introduction-top-page .feature-items-inner[data-v-12143966]{display:flex;width:100%;flex-wrap:wrap}.introduction-top-page .feature-item[data-v-12143966]{width:50%;padding:16px;box-sizing:border-box}.introduction-top-page .feature-item img[data-v-12143966]{width:64px;height:64px}.introduction-top-page .feature-item-text[data-v-12143966]{color:#000000;font-size:12px;padding-top:8px}.introduction-top-page .feature-item[data-v-12143966]:first-child{border-right:1px solid #ebebeb;border-bottom:1px solid #ebebeb}.introduction-top-page .feature-item[data-v-12143966]:nth-child(2){border-bottom:1px solid #ebebeb}.introduction-top-page .feature-item[data-v-12143966]:nth-child(3){border-right:1px solid #ebebeb}}
        .category-title[data-v-0bf912cd]{color:#333;font-size:16px;padding:28px 0 20px;text-align:center;font-weight:700}.category-inner[data-v-0bf912cd]{display:flex}.category-item[data-v-0bf912cd]{width:100%;border-bottom:1px solid #f2f2f2;position:relative}.category-item[data-v-0bf912cd]:after{content:"";position:absolute;width:8px;height:8px;border-top:1px solid #828282;border-right:1px solid #828282;transform:rotate(45deg) translateY(-50%);right:28px;top:50%}.category-item-inner[data-v-0bf912cd]{display:flex;align-items:center;width:100%}.category-img[data-v-0bf912cd]{width:50%}.category-text[data-v-0bf912cd]{font-size:13px;padding:0 50px 0 16px;text-align:left;color:#828282;box-sizing:border-box;width:50%}.category-btn[data-v-0bf912cd]{color:#0a0;border:1px solid #0a0;box-sizing:border-box;border-radius:4px;height:45px;font-size:14px;line-height:45px;text-align:center;margin:33px 20px}.category-btn a[data-v-0bf912cd]{width:100%;display:block}
        mr-20[data-v-4aea0aac]{margin-right:20px}
        @media only screen and (min-device-width:768px) and (max-device-width:1024px) and (orientation:portrait){.popup-wrap[data-v-06f90f1e]{min-width:100vw}.popup-width-middle[data-v-06f90f1e]{height:95%}.popup-content[data-v-06f90f1e]{height:85%}}@media only screen and (min-device-width:768px) and (max-device-width:1024px) and (orientation:landscape){.popup-wrap[data-v-06f90f1e]{min-width:100vw}.popup-width-middle[data-v-06f90f1e]{height:95%}.popup-content[data-v-06f90f1e]{height:80%}}
    </style>
    <style>
        .easy-autocomplete-container ul li{
            background: #ffffff;
            border: 1px solid #dedede;
        }
        .easy-autocomplete-container ul li .eac-icon{
            width: 50px;
        }
        .easy-autocomplete input{
            padding: 11px 47px 11px 11px;
            font-size: 20px;
        }
        .eac-icon-right .eac-item{
            font-size: 15px;

        }
    </style>
    <style>
        body, html {
            font-family: "Helvetica Neue", Helvetica, Arial, 文泉驛正黑, "WenQuanYi Zen Hei", "Hiragino Sans GB", "儷黑 Pro", "LiHei Pro", "Heiti TC", 微軟正黑體, "Microsoft JhengHei UI", "Microsoft JhengHei", sans-serif;
            color: rgba(0, 0, 0, 0.8);
            line-height: 1.2;
        }
        .lyt-contents-narrow{
            max-width: 100%;
        }
        .product-cart-header p:nth-child(1) {
            width: -webkit-calc(100% - 559px);
            width: calc(100% - 600px);
        }
        .product-cart-header p:nth-child(3) {
            width: 100px;
            border-right: 1px solid #C6C6C6;
        }
        .product-cart-header p:nth-child(3) {
            width: 139px;
            border-right: 1px solid #C6C6C6;
        }
        .product-cart-header p:nth-child(4) {
            width: 118px;
            border-right: 1px solid #C6C6C6;
        }
        .product-cart-header p:nth-child(6) {
            width: 112px;
        }
        .product-cart-row .product-cart-row-top{
            width: calc(100% - 490px);

        }
        .product-cart-row .product-cart-item3{
            width: 118px;
        }
        .load{
            background: #dedede;
        }

    </style>
