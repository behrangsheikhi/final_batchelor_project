<aside class="main-sidebar fixed">

    <!-- sidebar-->
    <section class="sidebar" style="height: auto;">
        <!-- sidebar menu-->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="user-profile treeview">
                <a href="#">
                    <img src="{{ asset('admin-asset/images/avatar/9.jpg') }}" alt="profile picture">
                    <span>
                        <span class="d-block font-weight-600 text-sm">
                            {{ auth()->user()->fullname ?? '' }} <br>
                            خوش آمدید
                        </span>
{{--                        <span class="email-id text-sm">{{ auth()->user()->full_name ?? 'کاربر عزیز' }}</span>--}}
			        </span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="mdi mdi-account mr-5"></i>پروفایل</a></li>
                    <li><a target="_blank" href="{{ route('app.home') }}"><i class="mdi mdi-web mr-5"></i>مشاهده سایت</a></li>
                    {{--                    <li><a href="javascript:void()"><i class="fa fa-money mr-5"></i>My Balance</a></li>--}}
                    <li><a href="#"><i class="mdi mdi-comment mr-5"></i>صندوق پیام</a></li>
                    <li><a href="#"><i class="mdi mdi-settings mr-5"></i>تنظیمات حساب</a></li>
                    <li><a href="{{ route('auth.logout') }}"><i class="mdi mdi-power-settings mr-5"></i>خروج</a></li>
                </ul>
            </li>

            @role('super-admin')
            <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>بخش کاربران و نقش ها</li>
            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="fa fa-users"></i>
                    مدیریت کاربران
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.user.admin-user.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>ادمین</a>
                    </li>
                    <li><a href="{{ route('admin.user.app.index') }}"><i class="mdi mdi-toggle-switch-off"></i>مشتری</a>
                    </li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="fa fa-shield"></i>
                    مدیریت دسترسی ها
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.user.role.index') }}"><i class="mdi mdi-toggle-switch-off"></i>نقش
                            ها</a></li>
                    <li><a href="{{ route('admin.user.permission.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>دسترسی ها</a></li>
                </ul>
            </li>

            @endrole

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
                        <a href="{{ route('admin.market.product.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>کالا</a
                        >
                    </li>

                    @role('super-admin')
                    <li>
                        <a href="{{ route('admin.market.store.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>انبار</a
                        >
                    </li>
                    <li>
                        <a href="{{ route('admin.market.category.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>دسته بندی کالا</a
                        >
                    </li>
                    <li>
                        <a href="{{ route('admin.market.property.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>فرم کالا</a
                        >
                    </li>
                    <li>
                        <a href="{{ route('admin.comment.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>نظرات کالا</a
                        >
                    </li>
                    <li>
                        <a href="{{ route('admin.market.brand.index') }}"
                        ><i class="mdi mdi-toggle-switch-off"></i>برندها</a
                        >
                    </li>
                    @endrole



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

                    <li><a href="{{ route('admin.market.order.newOrder') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>جدید</a>
                    </li>
                    <li><a href="{{ route('admin.market.order.sending') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>در
                            حال ارسال</a></li>
                    <li><a href="{{ route('admin.market.order.unpaid') }}"><i class="mdi mdi-toggle-switch-off"></i>پرداخت
                            نشده</a></li>
                    <li><a href="{{ route('admin.market.order.canceled') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>لغو
                            شده</a></li>
                    <li><a href="{{ route('admin.market.order.returned') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>مرجوعی</a>
                    </li>
                    <li><a href="{{ route('admin.market.order.all') }}"><i class="mdi mdi-toggle-switch-off"></i>تمام
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
                    <li><a href="{{ route('admin.market.payment.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>تمام
                            پرداخت ها</a>
                    </li>
                    <li><a href="{{ route('admin.market.payment.online') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های آنلاین</a></li>
                    <li><a href="{{ route('admin.market.payment.offline') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های آفلاین</a></li>
                    <li><a href="{{ route('admin.market.payment.cash') }}"><i class="mdi mdi-toggle-switch-off"></i>پرداخت
                            های در محل</a></li>
                </ul>
            </li>

            @role('super-admin')
            <li class="treeview">
                <a href="#" class="d-flex align-items-baseline">
                    <i class="mdi mdi-gift"></i>
                    تخفیف ها
                    <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.market.discount.coupon-index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>کوپن تخفیف</a></li>
                    <li><a href="{{ route('admin.market.discount.common-discount-index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>تخفیف عمومی</a></li>
                    <li><a href="{{ route('admin.market.discount.amazing-sale-index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>فروش شگفت انگیز</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ route('admin.market.delivery-method.index') }}">
                    <i class="mdi mdi-truck"></i>
                    <span>روش های ارسال</span>
                </a>
            </li>
            @endrole


            <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>بخش محتوا</li>
            <li class="treeview">
                <a href="#">
                    <i class="mdi mdi-book-multiple text-sm"></i>
                    <span>مقالات</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.content.category.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>دسته
                            بندی مقالات</a></li>
                    <li><a href="{{ route('admin.content.post.index') }}"><i class="mdi mdi-toggle-switch-off"></i>پست
                            ها</a></li>
                    <li><a href="{{ route('admin.comment.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>نظرات</a>
                    </li>
                </ul>
            </li>

            @role('super-admin')

            <li>
                <a href="{{ route('admin.content.menu.index') }}">
                    <i class="mdi mdi-menu"></i>
                    <span>مدیریت منو</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.content.banner.index') }}">
                    <i class="mdi mdi-image-album"></i>
                    <span>مدیریت بنرها</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.content.faq.index') }}">
                    <i class="mdi mdi-comment-question-outline"></i>
                    <span>مدیریت سوالات متداول</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.content.page.index') }}">
                    <i class="mdi mdi-page-first"></i>
                    <span>پیج ساز</span>
                </a>
            </li>
            @endrole

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
                    <li><a href="{{ route('admin.ticket.index') }}"><i class="mdi mdi-toggle-switch-off"></i>همه
                            تیکت ها</a>
                    </li>
                    <li><a href="{{ route('admin.ticket.admin.index') }}"><i class="mdi mdi-toggle-switch-off"></i>ادمین
                            تیکت</a></li>
                    <li><a href="{{ route('admin.ticket.category.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>دسته
                            بندی تیکت</a></li>
                    <li><a href="{{ route('admin.ticket.priority.index') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>اولویت
                            تیکت</a></li>
                    <li><a href="{{ route('admin.ticket.new-tickets') }}"><i class="mdi mdi-toggle-switch-off"></i>تیکت
                            های جدید</a></li>
                    <li><a href="{{ route('admin.ticket.open-tickets') }}"><i class="mdi mdi-toggle-switch-off"></i>تیکت
                            های باز</a></li>
                    <li><a href="{{ route('admin.ticket.closed-tickets') }}"><i
                                class="mdi mdi-toggle-switch-off"></i>تیکت
                            های بسته</a></li>
                </ul>
            </li>

            @role('super-admin')
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
                        <li><a href="{{ route('admin.notify.email.index') }}"><i class="mdi mdi-toggle-switch-off"></i>اطلاع
                                رسانی ایمیلی</a></li>
                        <li><a href="{{ route('admin.notify.sms.index') }}"><i class="mdi mdi-toggle-switch-off"></i>اطلاع
                                رسانی پیامکی</a></li>
                        <li><a href="#"><i class="mdi mdi-toggle-switch-off"></i>اطلاع رسانی پاپ آپ</a></li>
                    </ul>
                </li>

            <li class="header nav-small-cap"><i class="mdi mdi-drag-horizontal mr-5"></i>بخش تنظیمات</li>
            <li>
                <a href="{{ route('admin.setting.index') }}">
                    <i class="mdi mdi-truck"></i>
                    <span>تنظیمات سایت</span>
                </a>
            </li>
            @endrole

            <li>
                <a href="{{ route('auth.logout') }}">
                    <i class="mdi mdi-directions"></i>
                    <span>خروج</span>
                </a>
            </li>

        </ul>
    </section>
</aside>
