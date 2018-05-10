<header>
    <div class="container">
        <h4 class="fl-right">
            <a href="/dashboard"><img src="{{ asset('images/logo.png')}}"></a>
        </h4>
        <i class="fa fa-bars"></i>
        <i class="fa fa-close"></i>

        <li class="settings dropdown fl-left list-unstyled">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">{{ $user->first_name." ".$user->last_name }}<span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#" data-popup="AccountInfo-Popup"><i class="fa fa-info"></i>بيانات الحساب</a></li>
                <li><a href="{{ URL::route('logout') }}"><i class="fa fa-sign-out"></i>تسحيل الخروج</a></li>
            </ul>
        </li>
        <div class="notifcation fl-left" style="margin-left:50px;margin-top:20px">

            <a href="#" class="notifcation-icon">
                <i class="fa fa-bell-o"></i>
                @if($count>0)
                    <span class="number">{{$count}}</span>
                @endif
            </a>
            <ul class="notifcation-body list-unstyled">
                @foreach($notifications as $notification)
                    <li
                            @if(!$notification->read)
                            class="unread"
                            @endif
                    ><a href="{{$notification->url}}">{{$notification->title}}</a>
                        <i data-id="{{$notification->id}}" class="fa fa-remove"></i>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</header>
