@extends('layouts.app')

@section('title')
    Reviews
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title"> Reviews </h3>

        @authorized('REVIEW', 'CREATE')
        <a href="{{ route('reviews.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
        @endauthorized
    </div>

    @if (session('status'))
    @endif

    @if (session('status'))
        <div class="px-3">{!! session('status') !!}</div>
    @endif

    <div class="row">
        <div class="col-12 grid-margin stretch-card table-responsive">
            <table class="table bg-white" id="list-data">
                <thead class="thead bg-primary text-white font-weight-bold">
                    <tr>
                        <th scope="col">@sortablelink('name', 'Name')</th>
                        <th scope="col">@sortablelink('email', 'Email')</th>
                        <th scope="col">@sortablelink('status', 'Status')</th>
                        <th scope="col">@sortablelink('review_category', 'Review Category')</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                @if ($reviews->count() > 0)
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <th>{{ $review->name }}</th>
                                <th>{{ $review->email }}</th>
                                <td>@authorized('REVIEW','UPDATE')<a href="javascript:(0);" class="record-status"
                                        data-id="{{ $review->id }}" data-table="reviews"
                                        data-status="{{ $review->status }}">
                                        @if ($review->status == 'active')
                                            <i class="fa fa-check-circle fa-2x text-success">
                                            @else
                                                <i class="fa fa-times-circle fa-2x text-danger">
                                        @endif
                                        @elseauthorized('REVIEW')
                                        @if ($review->status == 'active')
                                            <i class="fa fa-check-circle fa-2x text-success">
                                            @else
                                                <i class="fa fa-times-circle fa-2x text-danger">
                                        @endif
                                    </a>@endauthorized</td>
                                <th>{{ $review->review_category }}</th>
                                <td>@authorized('REVIEW','UPDATE')
                                    <a href="{{ route('reviews.edit', $review) }}" class="btn btn-primary btn-sm"
                                        title="Edit">
                                        <i class="mdi mdi-square-edit-outline"></i>
                                    </a>
                                    @endauthorized
                                    @authorized('REVIEW','DESTROY')
                                    <form class="d-inline swal-delete" action="{{ route('reviews.destroy', $review) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Delete"><i
                                                class="mdi mdi-delete"></i></button>
                                    </form>
                                    @endauthorized
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="5" style="text-align: center">No Data Available</td>
                        </tr>
                    </tbody>
            </table>
            @endif
            </table>
        </div>
        <div class="col-12 grid-margin stretch-card">
            {!! $reviews->appends(\Request::except('page'))->render() !!}
        </div>


    </div>
@endsection
