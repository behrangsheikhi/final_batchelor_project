<aside class="main-sidebar fixed">

    <!-- sidebar-->
    <section class="sidebar" style="height: auto;">
        <!-- sidebar menu-->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="user-profile treeview">
                <a href="#">
                    <img src="{{ asset('admin-asset/images/avatar/2.jpg') }}" alt="user">
                    <span>
                        <span class="d-block font-weight-600 font-size-16">
                            {{ auth()->user()->full_name ?? "کاربر عزیز" }}  خوش آمدید
                        </span>
{{--                        <span class="email-id text-sm">{{ auth()->user()->full_name ?? 'کاربر عزیز' }}</span>--}}
			        </span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-user mr-5"></i>پروفایل</a></li>
                    <li><a href="{{ route('app.home') }}"><i class="mdi mdi-web mr-5"></i>مشاهده سایت</a></li>
                    {{--                    <li><a href="javascript:void()"><i class="fa fa-money mr-5"></i>My Balance</a></li>--}}
                    <li><a href="#"><i class="fa fa-envelope-open mr-5"></i>صندوق پیام</a></li>
                    <li><a href="#"><i class="fa fa-cog mr-5"></i>تنظیمات حساب</a></li>
                    <li><a href="{{ route('vendor.logout') }}"><i class="fa fa-power-off mr-5"></i>خروج</a></li>
                </ul>
            </li>


            <li class="header nav-small-cap">
                <i class="mdi mdi-drag-horizontal mr-5"></i>بخش فروش
            </li>


            <li class="treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span>ویترین</span>
                    <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>کالا</a
                        >
                    </li>
                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>انبار</a
                        >
                    </li>


                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>دسته بندی کالا</a
                        >
                    </li>
                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>فرم کالا</a
                        >
                    </li>
                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>نظرات کالا</a
                        >
                    </li>
                    <li>
                        <a href="#"
                        ><i class="mdi mdi-toggle-switch-off"></i>برندها</a
                        >
                    </li>
                    {{--                      <li>--}}
                    {{--                        <a href="{{ route('admin.market.product.guaranty.index') }}"--}}
                    {{--                        ><i class="mdi mdi-toggle-switch-off"></i>گارانتی</a--}}
                    {{--                        >--}}
                    {{--                    </li>--}}


                </ul>
            </li>

            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-shopping"></i>
                    سفارشات
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>جدید</a>
                    </li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>در
                            حال ارسال</a></li>
                    <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>پرداخت
                            نشده</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>لغو
                            شده</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>مرجوعی</a>
                    </li>
                    <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>تمام
                            سفارشات</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-credit-card-multiple"></i>
                    پرداخت ها
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>تمام
                            پرداخت ها</a>
                    </li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های آنلاین</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های آفلاین</a></li>
                    <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های در محل</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-gift"></i>
                    تخفیف ها
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>کوپن تخفیف</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>تخفیف عمومی</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>فروش شگفت انگیز</a></li>
                </ul>
            </li>


            <li>
                <a href="#">
                    <i class="mdi mdi-truck"></i>
                    <span>روش های ارسال</span>
                </a>
            </li>


            <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>بخش تیکت ها</li>
            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-comment-question-outline"></i>
                    تیکت ها
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#}"><i class="mdi mdi-toggle-switch-off"></i>همه
                            تیکت ها</a>
                    </li>
                    <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>ادمین
                            تیکت</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>دسته
                            بندی تیکت</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>اولویت
                            تیکت</a></li>
                    <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>تیکت
                            های جدید</a></li>
                    <li><a href="{{ route('admin.ticket.open-tickets') }}"><i class="mdi mdi-toggle-switch-off"></i>تیکت
                            های باز</a></li>
                    <li><a href="#"><i
                                class="mdi mdi-toggle-switch-off"></i>تیکت
                            های بسته</a></li>
                </ul>
            </li>

            <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>بخش اطلاع رسانی ها</li>
            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-message-alert"></i>
                    اطلاع رسانی ها
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="#">
                            <i class="mdi mdi-toggle-switch-off"></i>همه</a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="mdi mdi-toggle-switch-off"></i>جدید</a>
                    </li>

                </ul>
            </li>

            <li>
                <a href="{{ route('vendor.logout') }}">
                    <i class="mdi mdi-directions"></i>
                    <span>خروج</span>
                </a>
            </li>

        </ul>
    </section>
</aside>
