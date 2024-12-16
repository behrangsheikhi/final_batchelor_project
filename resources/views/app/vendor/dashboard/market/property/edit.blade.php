@extends('admin.layout.master')

@section('head-tag')
    <title>فروشگاه | فرم کالا | ویرایش</title>
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.admin') }}">خانه</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.market.property.index') }}">فرم کالا</a></li>
                        <li class="breadcrumb-item active">ویرایش فرم کالا</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.market.property.update',$attribute->id) }} "
                  id="form"
                  method="post"
                  class="border rounded p-4"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-sm text-muted">عنوان فرم</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       id="name"
                                       value="{{ old('name',$attribute->name) }}">
                            </div>
                            @error('name')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="unit" class="text-sm text-muted">واحد اندازه گیری</label>
                                <input type="text"
                                       name="unit"
                                       class="form-control"
                                       id="unit"
                                       value="{{ old('unit',$attribute->unit) }}">
                            </div>
                            @error('unit')
                            <span class="alert_required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="category_id" class="text-sm text-muted">دسته بندی </label>
                                <select name="category_id" id="category_id" class="form-control form-group-sm">
                                    <option value="">انتخاب دسته بندی</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @if(old('category_id',$attribute->category->id) == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <span class="alert_required text-danger">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                    </div>
                    <section class="">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-save"></i> ذخیره
                        </button>
                    </section>
                </div>
            </form>
        </div>
    </section>
@endsection


@section('script')
    @php $data = ['className' => "delete"] @endphp
    @include('admin.alerts.sweetalert.delete-confirm', compact('data'))
@endsection

