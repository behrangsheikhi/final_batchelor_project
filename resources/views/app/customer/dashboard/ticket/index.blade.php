@extends('app.customer.dashboard.layouts.master')

@section('head-tag')
    <title>مدیریت تیکت</title>
@endsection

@section('content')

    <section class="row">
        <div class="col-sm-6 mb-4">
            <a role="button"
               href="{{ route('customer.dashboard.customer-ticket.create') }}"
               type="button"
               class="btn btn-primary btn-sm">
                <i class="fa fa-plus-circle"></i> ایجاد تیکت جدید
            </a>
        </div><!-- /.col -->
        <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table id="example"
                           class="display table table-striped table-bordered table-responsive-md table-hover"
                           style="width:100%">
                        <style>
                            th {
                                text-align: right !important;
                            }
                        </style>
                        <thead>
                        <tr class="font-weight-bold text-right" style="font-size: 0.75rem;">
                            <th scope="col">تاریخ</th>
                            <th scope="col">موضوع</th>
                            <th scope="col">وضعیت پاسخ</th>
                            <th scope="col">دسته</th>
                            <th scope="row">فایل</th>
                            <th scope="col">تیکت مرجع</th>
                            <th scope="col">وضعیت</th>
                            <th class="text-center" scope="col"><i class="fa fa-cogs"></i>
                                عملیات
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr style="font-size: 0.65rem;font-weight: 600;">
                                <th>{{ convertEnglishToPersian(persianDate($ticket->created_at)) }}</th>
                                <td>{{ $ticket->subject }}</td>
                                <td class="text-{{ $ticket->children ? 'success' : 'danger' }}">
                                    @if($ticket->children && count($ticket->children) > 0)
                                        @php $firstChild = $ticket->children->first(); @endphp
                                        <span
                                            title="{{ strip_tags(convertEnglishToPersian($firstChild['description'])) }}">
                                            {{ \Illuminate\Support\Str::limit(strip_tags(convertEnglishToPersian($firstChild['description'])),50) }}
                                        </span>
                                    @else
                                        <span class="text-danger fw-bolder">در انتظار پاسخ</span>
                                    @endif
                                </td>
                                <td>{{ $ticket->category->name }}</td>
                                <td class="text-{{ $ticket->file ? 'success' : 'danger' }} font-weight-bold">
                                    @if($ticket->file()->count() > 0)
                                        <a target="_blank" href="{{ asset($ticket->file->file_path) }}" title="دانود فایل ضمیمه"
                                           class="btn btn-sm btn-success"><i class="fa fa-file-download"></i></a>
                                    @else
                                        ندارد
                                    @endif
                                </td>
                                <td>{{ $ticket->parent->subject ?? '-' }}</td>
                                <td>{{ $ticket->status === 1 ? 'باز' : 'بسته' }}</td>
                                <td class="text-center">
                                    <a title="نمایش تیکت"
                                       href="{{ route('customer.dashboard.customer-ticket.show',$ticket->id) }}"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>


        </section>
    </section>
@endsection

@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection
