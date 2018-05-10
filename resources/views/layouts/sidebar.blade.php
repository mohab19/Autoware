<section class="SideBar">
    <!-- Small Nav tabs -->
    <ul class="nav nav-tabs sm" role="tablist">
        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "overview")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('overview') }}" aria-controls="home" >
                    <i class="fa fa-globe"></i>نظرة عامة
                </a>
            </li>
        @endif

        @if(Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "quickaccess")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('quickaccess') }}" aria-controls="home" >
                    <i class="fa fa-globe"></i>الوصول السريع
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role) )
            <li role="presentation"
                @if($page == "client")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('clients') }}" aria-controls="profile" >
                    <i class="fa fa-users"></i>العملاء
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) )
            <li role="presentation"
                @if($page == "admins")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('admins') }}" aria-controls="profile" >
                    <i class="fa fa-user-plus"></i>المديرين
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "employee")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('employees') }}" aria-controls="messages" >
                    <i class="fa fa-user"></i>الموظفين
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "partner")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('partners') }}" aria-controls="settings" >
                    <i class="fa fa-exchange"></i>الشركاء
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "cars")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('cars') }}" aria-controls="settings" >
                    <i class="fa fa-car"></i>السيارات
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "reservations")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('reservations') }}" aria-controls="settings" >
                    <i class="fa fa-pencil"></i>الحجوزات
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "waiting")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('waiting') }}" aria-controls="settings" >
                    <i class="fa fa-clock-o"></i>الانتظار
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "recive")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('recive') }}" aria-controls="settings" >
                    <i class="fa fa-calendar"></i>الاستلام
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "expenses")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('expenses') }}" aria-controls="settings" >
                    <i class="fa fa-money"></i>مصاريف عامة
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "advertisements")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('advertisements') }}" aria-controls="settings" >
                    <i class="fa fa-microphone"></i>الاعلانات
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "reports")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('reports') }}" aria-controls="settings" >
                    <i class="fa fa-file-text-o"></i>التقارير
                </a>
            </li>
        @endif

    </ul>
    <!-- Tab panes -->
    <!-- Default Nav tabs -->

    {{-------------------------------------------------------------------------------------------------------------}}
    <ul class="nav nav-tabs default" role="tablist">
        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "overview")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('overview') }}" aria-controls="home" >
                    <i class="fa fa-globe"></i>نظرة عامة
                </a>
            </li>
        @endif

        @if(Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "quickaccess")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('quickaccess') }}" aria-controls="home" >
                    <i class="fa fa-globe"></i>الوصول السريع
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role) )
            <li role="presentation"
                @if($page == "client")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('clients') }}" aria-controls="profile" >
                    <i class="fa fa-users"></i>العملاء
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) )
            <li role="presentation"
                @if($page == "admins")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('admins') }}" aria-controls="profile" >
                    <i class="fa fa-user-plus"></i>المديرين
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "employee")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('employees') }}" aria-controls="messages" >
                    <i class="fa fa-user"></i>الموظفين
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role))
            <li role="presentation"
                @if($page == "partner")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('partners') }}" aria-controls="settings" >
                    <i class="fa fa-exchange"></i>الشركاء
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "cars")
                class="active"
                    @endif
            >
                <a href="{{ URL::route('cars') }}" aria-controls="settings" >
                    <i class="fa fa-car"></i>السيارات
                </a>
            </li>
        @endif

        @if(Gate::allows('admin',$role) )
            <li role="presentation"
                @if($page == "reservations")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('reservations') }}" aria-controls="settings" >
                    <i class="fa fa-pencil"></i>الحجوزات
                </a>
            </li>
        @endif
        @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
            <li role="presentation"
                @if($page == "waiting")
                class="active"
                    @endif
            >
                {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                <a href="{{ URL::route('waiting') }}" aria-controls="settings" >
                    <i class="fa fa-clock-o"></i>الانتظار
                </a>
            </li>
        @endif
            @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
                <li role="presentation"
                    @if($page == "recive")
                    class="active"
                        @endif
                >
                    {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                    <a href="{{ URL::route('recive') }}" aria-controls="settings" >
                        <i class="fa fa-calendar"></i>الاستلام
                    </a>
                </li>
            @endif
            @if(Gate::allows('admin',$role) || Gate::allows('employee',$role))
                <li role="presentation"
                    @if($page == "expenses")
                    class="active"
                        @endif
                >
                    {{--<a href="#Reservations" aria-controls="settings" role="tab" data-toggle="tab">--}}
                    <a href="{{ URL::route('expenses') }}" aria-controls="settings" >
                        <i class="fa fa-money"></i>مصاريف عامة
                    </a>
                </li>
            @endif
            @if(Gate::allows('admin',$role))
                <li role="presentation"
                    @if($page == "reports")
                    class="active"
                        @endif
                >
                    <a href="{{ URL::route('reports') }}" aria-controls="settings" >
                        <i class="fa fa-file-text-o"></i>التقارير
                    </a>
                </li>
            @endif
            {{--@if(Gate::allows('admin',$role))--}}
                {{--<li role="presentation"--}}
                    {{--@if($page == "settings")--}}
                    {{--class="active"--}}
                        {{--@endif--}}
                {{-->--}}
                    {{--<a href="{{ URL::route('settings') }}" aria-controls="settings" >--}}
                        {{--<i class="fa fa-gear"></i>الاعدادات--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--@endif--}}


    </ul>
    <!-- Tab panes -->
</section>