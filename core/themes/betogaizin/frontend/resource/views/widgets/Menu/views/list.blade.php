@if(!isset($_isMobile) || !$_isMobile)
    @php
        $nestable  = \BetoGaizinTheme\Helper\Nestable::getInstance();
        $type = "menu";
        $menus = get_menu_type($type);
        $position = config_get("menu", $type);

        $category = get_category_type("shop-ja:product:category");
        $position_category = config_get("category","shop-ja:product:category");
    @endphp
    <div class="lyt-side-pattern01-menu only-pc">
    <p class="side-content-btn-clock">
        <a href="javascript:void(0);" data-auto-id="set-delivery-pc" data-ratid="delivery_schedule_button_click" data-ratevent="click" data-ratparam="all" class="js-popup-trigger">
            <span class="svg-icon icon-clock-white">お届け日時選択</span>
        </a>
    </p>
    <div class="category-menu-wrap">
        <div class="title-wrap">
            <div class="title-with-item">
                <h2 class="title title-other01 title-with-border">カテゴリから探す</h2>
            </div>
        </div>
        <ul class="category-menu category-menu-level01">
            @foreach($position as $value)
                @if(isset($value['children']))
                <li class="category-menu-level01-item">
                    <a href="#" class="category-menu-link category-menu-link-trigger">
                        {!! $menus[$value['id']]->name !!}
                    </a>
                    <div class="category-menu-level02" style="bottom: -372.5px; min-height: 666px;">
                        <p class="category-menu-item-title">{!! $menus[$value['id']]->description !!}</p>
                        <ul class="category-menu">
                            @php
                                $isOne = false;
                            @endphp
                            @isset($value['children'])
                                @foreach($value['children'] as $key1 => $value1)
                                   @if($menus[$value1['id']]->name == "Category")
                                       @foreach($position_category as $cate_value)
                                            <li class="category-menu-link">
                                                <a {!! $menus[$value1['id']]->router_name !!} href="{!! router_frontend_lang($menus[$value1['id']]->router_name,['id'=>$category[$cate_value['id']]->id,'slug'=>$category[$cate_value['id']]->slug]) !!}">{!! $category[$cate_value['id']]->name !!}</a>
                                            </li>
                                       @endforeach
                                   @else
                                        <li>
                                            <a href="#">{!! $menus[$value1['id']]->name !!}</a>
                                        </li>
                                   @endif
                                @endforeach
                            @endisset
                            {{--<li class="category-menu-level02-item">--}}
                                {{--<a href="#" class="category-menu-link category-menu-link-trigger">人気ブランドショップ</a>--}}
                                {{--<div class="category-menu-level03">--}}
                                    {{--<p class="category-menu-item-title">人気ブランドショップ</p>--}}
                                    {{--<ul class="category-menu-level03-items">--}}
                                        {{--<li class="category-menu-level03-item" style="display: block;">--}}
                                            {{--<a href="#" class="category-menu-link">人気ブランドショップすべて</a>--}}
                                        {{--</li>--}}
                                        {{--<li class="category-menu-level03-item">--}}
                                            {{--<a href="#" class="category-menu-link">[楽天市場]くまもと風土</a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                        </ul>
                    </div>
                </li>
                @else
                    <li>
                        @if($menus[$value['id']]->type_link == "router" && !empty($menus[$value['id']]->router_name))
                            <a href="{!! router_frontend_lang($menus[$value['id']]->router_name,[]) !!}" class="category-menu-link">{!! $menus[$value['id']]->name !!}</a>
                        @else
                            <a href="{!! $menus[$value['id']]->router_name !!}" class="category-menu-link">{!! $menus[$value['id']]->name !!}</a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endif
