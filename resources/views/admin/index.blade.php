@extends('admin.layout.master')

@section('head-tag')
    <title>پنل مدیریت</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto w-p50">
                <h3 class="page-title">فروشگاه</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">مشاهده و ارزیابی سایت</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="right-title w-170">
				<span class="subheader_daterange font-weight-600" id="dashboard_daterangepicker">
					<span class="subheader_daterange-label">
						<span class="subheader_daterange-title">امروز</span>
						<span class="subheader_daterange-date text-primary">15 فروردین</span>
					</span>
					<a href="#" class="btn btn-sm btn-primary">
						<i class="fa fa-angle-down"></i>
					</a>
				</span>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box box-body">
                    <h6 class="mb-0">
                        <span class="text-uppercase">تعداد سفارشات</span>
                    </h6>
                    <br>
                    <small>سفارشات امروز</small>
                    <p class="font-size-14">51,642</p>
                    <div class="progress progress-xxs mt-0 mb-10">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 35%; height: 4px;"
                             aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-size-12"><i class="ion-arrow-graph-up-right text-success mr-1"></i> 20 درصد بیشتر از ماه قبل
                    </div>
                    <a class="btn btn-sm btn-info my-2 text-white">مشاهده</a>

                </div>
            </div>
            <!-- /.col -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box box-body">
                    <h6 class="mb-0">
                        <span class="text-uppercase">مالیات(ماهانه)</span>
                    </h6>
                    <br>
                    <small>کسر مالیات(ماهانه)</small>
                    <p class="font-size-12">{{ number_format(54465465) }} تومان </p>

                    <div class="progress progress-xxs mt-0 mb-10">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%; height: 4px;"
                             aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-size-12"><i class="ion-arrow-graph-up-right text-success mr-1"></i> 234 بیشتر از سال قبل
                    </div>
                    <a class="btn btn-sm btn-info my-2 text-white">مشاهده</a>

                </div>
            </div>
            <!-- /.col -->

            <div class="col-xl-3 col-md-6 col-12">
                <div class="box box-body">
                    <h6 class="mb-0">
                        <span class="text-uppercase">وضعیت فروش هفتگی</span>
                    </h6>
                    <br>
                    <small>فروش هفتگی</small>
                    <p class="font-size-12">{{ number_format(78678574) }} تومان </p>

                    <div class="progress progress-xxs mt-0 mb-10">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 55%; height: 4px;"
                             aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="font-size-12"><i class="ion-arrow-graph-down-right text-danger mr-1"></i> 10% کمتر از هفته قبل
                    </div>
                    <a class="btn btn-sm btn-info my-2 text-white">مشاهده</a>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box box-body">
                    <h6 class="mb-0">
                        <span class="text-uppercase">فروش سالانه</span>
                    </h6>
                    <br>
                    <small>درآمد سالانه</small>
                    <p class="font-size-12">{{ number_format(546746874867) }} تومان </p>

                    <div class="progress progress-xxs mt-0 mb-10">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 52%; height: 4px;"
                             aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="flexbox font-size-12">
                        <span><i class="ion-arrow-graph-down-right text-success mr-1"></i> %37 بیشتر از سال قبل</span>
                    </div>
                    <a class="btn btn-sm btn-info my-2 text-white">مشاهده</a>

                </div>
            </div>
            <!-- /.col -->

        </div>

        <div class="row">

            <div class="col-12 col-lg-7 connectedSortable ui-sortable">
                <!-- AREA CHART -->
                <div class="box">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h4 class="box-title">اطلاعات و آمار کلی فروشگاه</h4>

                        <ul class="box-controls pull-right">
                            <li><a class="box-btn-close" href="#"></a></li>
                            <li><a class="box-btn-slide" href="#"></a></li>
                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                        </ul>
                    </div>
                    <div class="box-body chart-responsive">
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-12">
                                <ul class="list-unstyled">
                                    <li class="bb-1 py-10">
                                        <p class="mb-0">ترافیک</p>
                                        <div class="font-size-20 mb-5">4854,22k</div>
                                        <div class="font-size-18 text-success">
                                            <i class="fa fa-arrow-up pr-5"></i><span>+18%</span>
                                        </div>
                                    </li>

                                    <li class="bb-1 py-10">
                                        <p class="mb-0">سفارشات</p>
                                        <div class="font-size-20 mb-5">854,512k</div>
                                        <div class="font-size-18 text-success">
                                            <i class="fa fa-arrow-up pr-5"></i><span>+9%</span>
                                        </div>
                                    </li>

                                    <li class="py-10">
                                        <p class="mb-0">درآمد</p>
                                        <div class="font-size-20 mb-5">4875,84k</div>
                                        <div class="font-size-18 text-danger">
                                            <i class="fa fa-arrow-down pr-5"></i><span>-8%</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-10 col-md-9 col-12">
                                <div class="chart" id="revenue-chart"
                                     style="height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                    <svg height="300" version="1.1" width="396.677" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink"
                                         style="overflow: hidden; position: relative; left: -0.53125px; top: -0.635437px;">
                                        <desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with
                                            Raphaël 2.2.0
                                        </desc>
                                        <defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs>
                                        <text x="25.854166984558105" y="261.6666660308838" text-anchor="end"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0
                                            </tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                              d="M38.354166984558105,261.6666660308838H371.677" stroke-width="0.5"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <text x="25.854166984558105" y="202.49999952316284" text-anchor="end"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal">
                                            <tspan dy="3.9999890327453613"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">5
                                            </tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                              d="M38.354166984558105,202.49999952316284H371.677" stroke-width="0.5"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <text x="25.854166984558105" y="143.3333330154419" text-anchor="end"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal">
                                            <tspan dy="3.9999942779541016"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">10
                                            </tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                              d="M38.354166984558105,143.3333330154419H371.677" stroke-width="0.5"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <text x="25.854166984558105" y="84.16666650772095" text-anchor="end"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal">
                                            <tspan dy="3.999999523162842"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">15
                                            </tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa"
                                              d="M38.354166984558105,84.16666650772095H371.677" stroke-width="0.5"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <text x="25.854166984558105" y="25" text-anchor="end" font-family="sans-serif"
                                              font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">20
                                            </tspan>
                                        </text>
                                        <path fill="none" stroke="#aaaaaa" d="M38.354166984558105,25H371.677"
                                              stroke-width="0.5"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <text x="371.677" y="274.1666660308838" text-anchor="middle"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal" transform="matrix(1,0,0,1,0,6.6667)">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2017-07
                                            </tspan>
                                        </text>
                                        <text x="259.3158147514145" y="274.1666660308838" text-anchor="middle"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal" transform="matrix(1,0,0,1,0,6.6667)">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2017-05
                                            </tspan>
                                        </text>
                                        <text x="147.03137894630476" y="274.1666660308838" text-anchor="middle"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal" transform="matrix(1,0,0,1,0,6.6667)">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2017-03
                                            </tspan>
                                        </text>
                                        <text x="38.354166984558105" y="274.1666660308838" text-anchor="middle"
                                              font-family="sans-serif" font-size="12px" stroke="none" fill="#888888"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: sans-serif; font-size: 12px; font-weight: normal;"
                                              font-weight="normal" transform="matrix(1,0,0,1,0,6.6667)">
                                            <tspan dy="3.9999990463256836"
                                                   style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">2017-01
                                            </tspan>
                                        </text>
                                        <path fill="#efd091" stroke="none"
                                              d="M38.354166984558105,155.1666663169861C52.62956347105873,166.9999996185303,81.18035644405997,211.82627068454937,95.45575293056059,202.49999952316284C108.34965943449663,194.07627073223307,134.1374724423687,85.57161350041312,147.03137894630476,84.16666650772095C161.28758807193643,82.61328017502707,189.80000632319977,178.64729965559357,204.05621544883144,190.66666622161864C217.8711152744772,202.31396625868194,245.50091492576874,175.92349686231768,259.3158147514145,178.83333292007444C273.5912112379151,181.84016351308978,302.1420042109164,214.33333282470704,316.417400697417,214.33333282470704C330.23230052306275,214.33333282470704,357.8621001743543,187.7083328962326,371.677,178.83333292007444L371.677,261.6666660308838L38.354166984558105,261.6666660308838Z"
                                              fill-opacity="1"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                                        <path fill="none" stroke="#ffbc34"
                                              d="M38.354166984558105,155.1666663169861C52.62956347105873,166.9999996185303,81.18035644405997,211.82627068454937,95.45575293056059,202.49999952316284C108.34965943449663,194.07627073223307,134.1374724423687,85.57161350041312,147.03137894630476,84.16666650772095C161.28758807193643,82.61328017502707,189.80000632319977,178.64729965559357,204.05621544883144,190.66666622161864C217.8711152744772,202.31396625868194,245.50091492576874,175.92349686231768,259.3158147514145,178.83333292007444C273.5912112379151,181.84016351308978,302.1420042109164,214.33333282470704,316.417400697417,214.33333282470704C330.23230052306275,214.33333282470704,357.8621001743543,187.7083328962326,371.677,178.83333292007444"
                                              stroke-width="1"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <circle cx="38.354166984558105" cy="155.1666663169861" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="95.45575293056059" cy="202.49999952316284" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="147.03137894630476" cy="84.16666650772095" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="204.05621544883144" cy="190.66666622161864" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="259.3158147514145" cy="178.83333292007444" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="316.417400697417" cy="214.33333282470704" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="371.677" cy="178.83333292007444" r="4" fill="#ffbc34"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <path fill="#bdb5ed" stroke="none"
                                              d="M38.354166984558105,202.49999952316284C52.62956347105873,211.37499949932098,81.18035644405997,242.66313500848867,95.45575293056059,237.99999942779542C108.34965943449663,233.78813503233053,134.1374724423687,165.5950526258381,147.03137894630476,166.99999961853027C161.28758807193643,168.55338595122413,189.80000632319977,245.32607026708018,204.05621544883144,249.8333327293396C217.8711152744772,254.20107024323832,245.50091492576874,202.49999952316284,259.3158147514145,202.49999952316284C273.5912112379151,202.49999952316284,302.1420042109164,249.8333327293396,316.417400697417,249.8333327293396C330.23230052306275,249.8333327293396,357.8621001743543,214.33333282470704,371.677,202.49999952316284L371.677,261.6666660308838L38.354166984558105,261.6666660308838Z"
                                              fill-opacity="1"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 1;"></path>
                                        <path fill="none" stroke="#7460ee"
                                              d="M38.354166984558105,202.49999952316284C52.62956347105873,211.37499949932098,81.18035644405997,242.66313500848867,95.45575293056059,237.99999942779542C108.34965943449663,233.78813503233053,134.1374724423687,165.5950526258381,147.03137894630476,166.99999961853027C161.28758807193643,168.55338595122413,189.80000632319977,245.32607026708018,204.05621544883144,249.8333327293396C217.8711152744772,254.20107024323832,245.50091492576874,202.49999952316284,259.3158147514145,202.49999952316284C273.5912112379151,202.49999952316284,302.1420042109164,249.8333327293396,316.417400697417,249.8333327293396C330.23230052306275,249.8333327293396,357.8621001743543,214.33333282470704,371.677,202.49999952316284"
                                              stroke-width="1"
                                              style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path>
                                        <circle cx="38.354166984558105" cy="202.49999952316284" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="95.45575293056059" cy="237.99999942779542" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="147.03137894630476" cy="166.99999961853027" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="204.05621544883144" cy="249.8333327293396" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="259.3158147514145" cy="202.49999952316284" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="316.417400697417" cy="249.8333327293396" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                        <circle cx="371.677" cy="202.49999952316284" r="4" fill="#7460ee"
                                                stroke="#ffffff" stroke-width="1"
                                                style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle>
                                    </svg>
                                    <div class="morris-hover morris-default-style" style="display: none;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>

            <div class="col-12 col-lg-5 connectedSortable ui-sortable">
                <div class="box">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h4 class="box-title">10 محصول پرفروش</h4>
                        <ul class="box-controls pull-right">
                            <li><a class="box-btn-close" href="#"></a></li>
                            <li><a class="box-btn-slide" href="#"></a></li>
                            <li><a class="box-btn-fullscreen" href="#"></a></li>
                        </ul>
                    </div>
                    <div class="box-body">
                        <div class="flexbox align-items-center">
                            <div>
                                <div id="e_chart_3" class="w-200"
                                     style="height: 200px; -webkit-tap-highlight-color: transparent; user-select: none; position: relative; background: transparent;"
                                     _echarts_instance_="ec_1697780912397">
                                    <div
                                        style="position: relative; overflow: hidden; width: 200px; height: 200px; padding: 0px; margin: 0px; border-width: 0px;">
                                        <canvas width="300" height="300" data-zr-dom-id="zr_0"
                                                style="position: absolute; left: 0px; top: 0px; width: 200px; height: 200px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                    </div>
                                    <div></div>
                                </div>
                            </div>
                            <div>
                                <ul class="list-inline">
                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-primary"></span>
                                        <span>iPhone X</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-secondary"></span>
                                        <span>Mi tv4 55"</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-success"></span>
                                        <span>S9 plus</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-info"></span>
                                        <span>Pixal 2</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-warning"></span>
                                        <span>Macbook Air</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-danger"></span>
                                        <span>iPhone 8 plus</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-purple"></span>
                                        <span>Mi Note 7</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-pink"></span>
                                        <span>Lg G9</span>
                                    </li>

                                    <li class="mb-5">
                                        <span class="badge badge-dot badge-lg mr-1 badge-yellow"></span>
                                        <span>iMac 21"</span>
                                    </li>

                                    <li>
                                        <span class="badge badge-dot badge-lg mr-1 badge-brown"></span>
                                        <span>Google Home</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>

            <div class="col-12 col-lg-4 connectedSortable ui-sortable">
                <div class="box">
                    <div class="bg-img box-inverse"
                         style="background-image: url(../{{ asset('admin-asset/images/gallery/thumb/14.jpg') }});"
                         data-overlay="5">
                        <div class="box-header no-border ui-sortable-handle" style="cursor: move;">
                            <h4>Data Stats</h4>
                            <ul class="box-controls pull-right">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" href="#"
                                       class="btn btn-rounded btn-outline btn-white px-10">Stats</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                                        <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                                        <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="box-body">
                            <div class="flexbox flex-justified text-center mt-50">
                                <div class="b-1 rounded py-20">
                                    <p class="mb-0 fa-3x">30%</p>
                                    <p class="mb-0 font-weight-300">DIRECT SALE</p>
                                </div>
                                <div class="b-1 rounded py-20">
                                    <p class="mb-0 fa-3x">40%</p>
                                    <p class="mb-0 font-weight-300">WHOLE SALE</p>
                                </div>
                                <div class="b-1 rounded py-20">
                                    <p class="mb-0 fa-3x">50%</p>
                                    <p class="mb-0 font-weight-300">RETAIL SALE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="text-center py-15 bb-1 bb-dashed">
                            <h4>Monthly Income</h4>
                            <ul class="flexbox flex-justified text-center my-20">
                                <li class="px-10">
                                    <h6 class="mb-0 text-bold">8952</h6>
                                    <small>Abu Dhabi</small>
                                </li>

                                <li class="br-1 bl-1 px-10">
                                    <h6 class="mb-0 text-bold">7458</h6>
                                    <small>Miami</small>
                                </li>

                                <li class="px-10">
                                    <h6 class="mb-0 text-bold">3254</h6>
                                    <small>London</small>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center py-10 bb-1 bb-dashed">
                            <h4>Taxes info</h4>
                            <ul class="flexbox flex-justified text-center my-20">
                                <li class=" px-10">
                                    <h6 class="mb-0 text-bold">8952</h6>
                                    <small>Abu Dhabi</small>
                                </li>

                                <li class="br-1 bl-1 px-10">
                                    <h6 class="mb-0 text-bold">7458</h6>
                                    <small>Miami</small>
                                </li>

                                <li class="px-10">
                                    <h6 class="mb-0 text-bold">3254</h6>
                                    <small>London</small>
                                </li>
                            </ul>
                        </div>
                        <div class="text-center py-10 mt-2">
                            <h4>Partners Sale</h4>
                            <ul class="flexbox flex-justified text-center my-20">
                                <li class="px-10">
                                    <h6 class="mb-0 text-bold">8952</h6>
                                    <small>Abu Dhabi</small>
                                </li>

                                <li class="br-1 bl-1 px-10">
                                    <h6 class="mb-0 text-bold">7458</h6>
                                    <small>Miami</small>
                                </li>

                                <li class="px-10">
                                    <h6 class="mb-0 text-bold">3254</h6>
                                    <small>London</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12 connectedSortable ui-sortable">
                <div class="box">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h4 class="box-title">سفارشات اخیر</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <div id="invoice-list_wrapper"
                                 class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6"></div>
                                    <div class="col-sm-12 col-md-6"></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="invoice-list" class="table table-hover no-wrap dataTable no-footer"
                                               data-page-size="10" role="grid" aria-describedby="invoice-list_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="#Invoice: activate to sort column descending"
                                                    style="width: 48.1042px;">#Invoice
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Description: activate to sort column ascending"
                                                    style="width: 66.1979px;">Description
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Amount: activate to sort column ascending"
                                                    style="width: 47.0625px;">Amount
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Status: activate to sort column ascending"
                                                    style="width: 41.5px;">Status
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Issue: activate to sort column ascending"
                                                    style="width: 30.0521px;">Issue
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="invoice-list"
                                                    rowspan="1" colspan="1"
                                                    aria-label="View: activate to sort column ascending"
                                                    style="width: 29.7396px;">View
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            <tr role="row" class="odd">
                                                <td class="sorting_1">#5010</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$548</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Jan</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td class="sorting_1">#5010</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$548</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Jan</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">#5011</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$548</td>
                                                <td><span class="label label-success">Paid</span></td>
                                                <td>15-Sep</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td class="sorting_1">#5011</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$548</td>
                                                <td><span class="label label-success">Paid</span></td>
                                                <td>15-Sep</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">#5012</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$9658</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Jun</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td class="sorting_1">#5012</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$9658</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Jun</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">#5013</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$4587</td>
                                                <td><span class="label label-success">Paid</span></td>
                                                <td>15-May</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td class="sorting_1">#5013</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$4587</td>
                                                <td><span class="label label-success">Paid</span></td>
                                                <td>15-May</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="odd">
                                                <td class="sorting_1">#5014</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$856</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Mar</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <tr role="row" class="even">
                                                <td class="sorting_1">#5015</td>
                                                <td>Lorem Ipsum</td>
                                                <td>$956</td>
                                                <td><span class="label label-danger">Unpaid</span></td>
                                                <td>15-Aug</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-5">
                                        <div class="dataTables_info" id="invoice-list_info" role="status"
                                             aria-live="polite">Showing 1 to 10 of 11 entries
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        <div class="dataTables_paginate paging_simple_numbers"
                                             id="invoice-list_paginate">
                                            <ul class="pagination">
                                                <li class="paginate_button page-item previous disabled"
                                                    id="invoice-list_previous"><a href="#" aria-controls="invoice-list"
                                                                                  data-dt-idx="0" tabindex="0"
                                                                                  class="page-link">Previous</a></li>
                                                <li class="paginate_button page-item active"><a href="#"
                                                                                                aria-controls="invoice-list"
                                                                                                data-dt-idx="1"
                                                                                                tabindex="0"
                                                                                                class="page-link">1</a>
                                                </li>
                                                <li class="paginate_button page-item "><a href="#"
                                                                                          aria-controls="invoice-list"
                                                                                          data-dt-idx="2" tabindex="0"
                                                                                          class="page-link">2</a></li>
                                                <li class="paginate_button page-item next" id="invoice-list_next"><a
                                                        href="#" aria-controls="invoice-list" data-dt-idx="3"
                                                        tabindex="0" class="page-link">Next</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
            </div>

            <div class="col-lg-6 col-12 connectedSortable ui-sortable">
                <div class="box">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h4 class="box-title">Recent Reviews</h4>
                        <div class="box-controls pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-default">Sort by Newest</button>
                                <button type="button" class="btn btn-xs btn-default dropdown-toggle"
                                        data-toggle="dropdown">
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Sort by Newest</a>
                                    <a class="dropdown-item" href="#">Sort by Highest Rating</a>
                                    <a class="dropdown-item" href="#">Sort by Highest Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="media-list media-list-divided">
                            <div class="media p-0">
                                <div class="media-body m-0">
                                    <div class="flexbox">
                                        <div>
                                            <h4 class="mb-0">For T-shirt</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star-half"></a>
                                        </div>
                                    </div>
                                    <p>By<strong><a href="javascript:void(0)"
                                                    class="inline-block capitalize-font  mb-5">Johen Doe</a></strong>
                                        <span class="float-right">11 day ago</span></p>
                                    <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit.</p>
                                    <div class="media-block-actions my-5">
                                        <nav class="nav nav-dot-separated no-gutters">
                                            <div class="nav-item">
                                                <a class="nav-link text-success" href="#"><i
                                                        class="fa fa-thumbs-up"></i> (17)</a>
                                            </div>
                                            <div class="nav-item">
                                                <a class="nav-link text-danger" href="#"><i
                                                        class="fa fa-thumbs-down"></i> (22)</a>
                                            </div>
                                        </nav>

                                        <nav class="nav no-gutters gap-2 font-size-16 media-hover-show">
                                            <a class="nav-link text-success" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Approve"><i class="ion-checkmark"></i></a>
                                            <a class="nav-link text-danger" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Delete"><i class="ion-close"></i></a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="media p-0">
                                <div class="media-body m-0">
                                    <div class="flexbox mt-10">
                                        <div>
                                            <h4 class="mb-0">For Shirt</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star-half"></a>
                                        </div>
                                    </div>
                                    <p>By<strong><a href="javascript:void(0)"
                                                    class="inline-block capitalize-font  mb-5">Johen Doe</a></strong>
                                        <span class="float-right">11 day ago</span></p>
                                    <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit.</p>
                                    <div class="media-block-actions my-5">
                                        <nav class="nav nav-dot-separated no-gutters">
                                            <div class="nav-item">
                                                <a class="nav-link text-success" href="#"><i
                                                        class="fa fa-thumbs-up"></i> (17)</a>
                                            </div>
                                            <div class="nav-item">
                                                <a class="nav-link text-danger" href="#"><i
                                                        class="fa fa-thumbs-down"></i> (22)</a>
                                            </div>
                                        </nav>

                                        <nav class="nav no-gutters gap-2 font-size-16 media-hover-show">
                                            <a class="nav-link text-success" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Approve"><i class="ion-checkmark"></i></a>
                                            <a class="nav-link text-danger" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Delete"><i class="ion-close"></i></a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="media p-0">
                                <div class="media-body m-0">
                                    <div class="flexbox mt-10">
                                        <div>
                                            <h4 class="mb-0">For Dress</h4>
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star"></a>
                                            <a href="javascript:void(0);" class="fa fa-star-half"></a>
                                        </div>
                                    </div>
                                    <p>By<strong><a href="javascript:void(0)"
                                                    class="inline-block capitalize-font  mb-5">Johen Doe</a></strong>
                                        <span class="float-right">11 day ago</span></p>
                                    <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur,
                                        adipisci velit.</p>
                                    <div class="media-block-actions my-5">
                                        <nav class="nav nav-dot-separated no-gutters">
                                            <div class="nav-item">
                                                <a class="nav-link text-success" href="#"><i
                                                        class="fa fa-thumbs-up"></i> (17)</a>
                                            </div>
                                            <div class="nav-item">
                                                <a class="nav-link text-danger" href="#"><i
                                                        class="fa fa-thumbs-down"></i> (22)</a>
                                            </div>
                                        </nav>

                                        <nav class="nav no-gutters gap-2 font-size-16 media-hover-show">
                                            <a class="nav-link text-success" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Approve"><i class="ion-checkmark"></i></a>
                                            <a class="nav-link text-danger" href="#" data-toggle="tooltip" title=""
                                               data-original-title="Delete"><i class="ion-close"></i></a>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-6 col-lg-6 connectedSortable ui-sortable">
                <div class="box">
                    <div class="box-header with-border ui-sortable-handle" style="cursor: move;">
                        <h5 class="box-title">Resent Notifications</h5>
                    </div>
                    <div class="box-body p-15">
                        <div class="media-list media-list-hover">
                            <a class="media media-single" href="#">
                                <h4 class="w-50 text-gray font-weight-500">10:10</h4>
                                <div class="media-body pl-15 bl-5 rounded border-primary">
                                    <p>Morbi quis ex eu arcu auctor sagittis.</p>
                                    <span class="text-fade">by Johne</span>
                                </div>
                            </a>

                            <a class="media media-single" href="#">
                                <h4 class="w-50 text-gray font-weight-500">08:40</h4>
                                <div class="media-body pl-15 bl-5 rounded border-success">
                                    <p>Proin iaculis eros non odio ornare efficitur.</p>
                                    <span class="text-fade">by Amla</span>
                                </div>
                            </a>

                            <a class="media media-single" href="#">
                                <h4 class="w-50 text-gray font-weight-500">07:10</h4>
                                <div class="media-body pl-15 bl-5 rounded border-info">
                                    <p>In mattis mi ut posuere consectetur.</p>
                                    <span class="text-fade">by Josef</span>
                                </div>
                            </a>

                            <a class="media media-single" href="#">
                                <h4 class="w-50 text-gray font-weight-500">01:15</h4>
                                <div class="media-body pl-15 bl-5 rounded border-danger">
                                    <p>Morbi quis ex eu arcu auctor sagittis.</p>
                                    <span class="text-fade">by Rima</span>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

@endsection
@section('script')
    <script type="text/javascript">
        // Use the JavaScript variable to show welcome toast
        if (welcomeToast) {
            showToastrMessage(welcomeToast.message, welcomeToast.type);
        }
    </script>
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
    @include('admin.alerts.sweetalert.success')
    @include('admin.alerts.sweetalert.error')
@endsection
