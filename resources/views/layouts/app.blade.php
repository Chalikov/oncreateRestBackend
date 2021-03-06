<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @if (preg_match('/^delivery_areas/', \Route::currentRouteName()))
        <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?libraries=drawing,geometry&key=AIzaSyB6sFd5XBPlersArqk4kylhVXNl7SFXRfQ"></script>
    @endif
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body id="body">
<form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST">{{ csrf_field() }}</form>
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidenav">
                <ul class="nav nav-pills nav-stacked">
                    <li class="{{ Request::segment(1) === 'home' ? 'active' : null }}">
                        <a href="{{ route('home') }}">{{__('messages.dashboard.menu_title')}}</a>
                    </li>   
                    @can('create', App\HomePage::class)
                        <li class="{{ Request::segment(1) === 'homepage' ? 'active' : null }}">
                            <a href="{{ route('homepage.index') }}">{{__('messages.homepage.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\NewsItem::class)
                        <li class="{{ Request::segment(1) === 'news_items' ? 'active' : null }}">
                            <a href="{{ route('news_items.index') }}">{{__('messages.news.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', \App\Category::class)
                        <li class="{{ Request::segment(1) === 'categories' ? 'active' : null }}">
                            <a href="{{ route('categories.index') }}">{{__('messages.categories.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\Product::class)
                    <li class="{{ Request::segment(1) === 'prodcuts' ? 'active' : null }}">
                        <a href="{{ route('products.index') }}">{{__('messages.products.menu_title')}}</a>
                    </li>
                    @endcan
                    @can('create', App\Order::class)
                        <li class="{{ Request::segment(1) === 'orders' ? 'active' : null }} ">
                            @php($notifications = count(App\User::find(1)->unreadNotifications))
                                <a id="orders_btn" class="orders_button" href="{{ route('orders.index') }}">
                                    <text class="notification_dot" style="color:red;"> ● </text>
                                    {{__('Orders')}}
                                    <text class="notifications_text">(<span class="notif-count">{{$notifications}}</span>)</text> </a>
                        </li>
                    @endcan
                    @can('create', App\Customer::class)
                        <li class="{{ Request::segment(1) === 'customers' ? 'active' : null }}">
                            <a href="{{ route('customers.index') }}">{{__('messages.customers.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\Vendor::class)
                        <li class="{{ Request::segment(1) === 'vendors' ? 'active' : null }}">
                            <a href="{{ route('vendors.index') }}">{{__('messages.vendors.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\PushMessage::class)
                        <li class="{{ Request::segment(1) === 'push_messages' ? 'active' : null }}">
                            <a href="{{ route('push_messages.index') }}">{{__('messages.push_messages.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\DeliveryArea::class)
                        <li class="{{ Request::segment(1) === 'delivery_areas' ? 'active' : null }}">
                            <a href="{{ route('delivery_areas.index') }}">{{__('messages.delivery_areas.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\DeliveryBoy::class)
                        <li class="{{ Request::segment(1) === 'delivery_boys' ? 'active' : null }}">
                            <a href="{{ route('delivery_boys.index') }}">{{__('messages.delivery_boys.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\PromoCode::class)
                        <li class="{{ Request::segment(1) === 'promo_codes' ? 'active' : null }}">
                            <a href="{{ route('promo_codes.index') }}">{{__('messages.promo_codes.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\TaxGroup::class)
                        <li class="{{ Request::segment(1) === 'tax_groups' ? 'active' : null }}">
                            <a href="{{ route('tax_groups.index') }}">{{__('messages.tax_groups.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\OrderStatus::class)
                        <li class="{{ Request::segment(1) === 'order_statuses' ? 'active' : null }}">
                            <a href="{{ route('order_statuses.index') }}">{{__('messages.order_statuses.menu_title')}}</a>
                        </li>
                    @endcan
                    @if (\App\Settings::getSettings()->multiple_cities)
                        @can('create', App\City::class)
                            <li class="{{ Request::segment(1) === 'cities' ? 'active' : null }}">
                                <a href="{{ route('cities.index') }}">{{__('messages.cities.menu_title')}}</a>
                            </li>
                        @endcan
                    @endif
                    @if (\App\Settings::getSettings()->multiple_restaurants)
                        @can('create', App\Restaurant::class)
                            <li class="{{ Request::segment(1) === 'restaurants' ? 'active' : null }}">
                                <a href="{{ route('restaurants.index') }}">{{__('messages.restaurants.menu_title')}}</a>
                            </li>
                        @endcan
                    @endif
                    @can('create', App\Settings::class)
                        <li class="{{ Request::segment(1) === 'settings' ? 'active' : null }}">
                            <a href="{{ route('settings.index') }}">{{__('messages.settings.menu_title')}}</a>
                        </li>
                    @endcan
                    @can('create', App\User::class)
                        <li class="{{ Request::segment(1) === 'users' ? 'active' : null }}">
                            <a href="{{ route('users.index') }}">{{__('messages.users.menu_title')}}</a>
                        </li>
                    @endcan
                    <li class="divider">
                        <hr>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{__('auth.logout')}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <div id="app">
    </div>

    <br>
    <br>
    <br>
    <br>
    <script>
        window.locale = {
            confirm: '{{ __("messages.common.confirm") }}'
        };
    </script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src='https://code.jquery.com/jquery-2.2.0.min.js'></script>
    <script src='https://cdn.rawgit.com/admsev/jquery-play-sound/master/jquery.playSound.js'></script>

     <script>
        function notifyMe() {
            // Let's check if the browser supports notifications
            if (!("Notification" in window)) {
                alert("This browser does not support desktop notification");
            }
            // Let's check whether notification permissions have already been granted
            else if (Notification.permission === "granted") {
                // If it's okay let's create a notification
                var notification = new Notification("New order notification!",
                    {
                        requireInteraction: true,
                        body: 'Click here to view orders.',
                    });
                notification.onclick = function () {
                    window.focus();
                    notification.close();
                };
            }

            // Otherwise, we need to ask the user for permission
            else if (Notification.permission !== "denied") {
                Notification.requestPermission().then(function (permission) {
                    // If the user accepts, let's create a notification
                    if (permission === "granted") {
                        var notification = new Notification("New order notification!");
                    }
                });
            }

            // At last, if the user has denied notifications, and you
            // want to be respectful there is no need to bother them any more.
        }
    </script>
    <script type="text/javascript">
        var ordersButton   = $('.orders_button');
        var notificationDot   = $('.notification_dot');
        var notificationsText = $('.notifications_text');
        
        var notificationsCount = parseInt("<?php echo $notifications; ?>");
        if (notificationsCount <= 0) {
            notificationsText.hide();
            notificationDot.hide();
        }
         var pusher = new Pusher('dd94d57bec2274a5cd31', {
         encrypted: true,
         cluster: 'eu',
         });

        var channel = pusher.subscribe('notify');
        channel.bind('notify-event', function(message) {
        notificationsCount += 1;
            ordersButton.find('.notif-count').text(notificationsCount);
            notificationsText.show();
            notificationDot.show();
            $.playSound("{{asset('notif_sound.wav')}}");
            if(location.pathname==="/orders"){
                swal("There's a new order!","","info")
                    .then((value) => {
                        if(value) window.location.reload(true);
                    });
            } else {
                swal("There's a new order!", "Go to the orders page?", {
                    buttons: {
                        cancel: "Later",
                        defeat: "View Orders",
                    }, icon: "info",
                })
                    .then((value) => {
                        if(value)  window.location.replace("/orders");
                    });
            }
            if(document.visibilityState !== "visible") notifyMe();
        });
    </script>
</body>
</html>
