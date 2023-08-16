@extends('app2')

@section('content')
    <div class="container d-flex align-items-start justify-content-center mt-4 flex-wrap">
        <div class="col-lg-8 col-md-12">
            <div class="text-center card">
                <div class="card-header">{{ ('Thông tin người dùng') }}</div>
                <div class="card-body">
                    <p>Tên: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <p>Số ngày hành kinh trung bình: {{ $user->period_length }}</p>
                    <p class="mb-0">Độ dài trung bình của chu kỳ kinh nguyệt: {{ $user->cycle_length }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
