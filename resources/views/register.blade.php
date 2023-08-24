@extends('app')

@section('content')
    <div class="container d-flex align-items-start justify-content-center mt-4">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header text-center">{{ __('Đăng ký') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row gx-2 mb-4 justify-content-between">
                            <label for="name" class="col-auto col-form-label">
                                {{ __('Tên') }}</label>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="text" name="name" id="name" class="form-control" value="@php echo $_GET['name'] @endphp" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-4 justify-content-between">
                            <label for="email" class="col-auto col-form-label">
                                {{ __('Email') }}</label>
                            <div class="col-lg-9 col-md-12 col-sm-12">
                                <input type="email" name="email" id="email" class="form-control-plaintext" value="@php echo $_GET['email'] @endphp" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-4 justify-content-between">
                            <input class="form-check-input" type="radio" name="register_cycle" id="register_cycle_start" onclick="
                            document.getElementById('last_period_start').disabled = false;
                            document.getElementById('last_period_end').disabled = true;">
                            <label for="register_cycle_start" class="col-auto col-form-label">
                                {{ __('Ngày bắt đầu vỡ trứng gần nhất:') }}</label>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <input id="last_period_start" type="date" class="form-control" name="last_period_start" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4 justify-content-between">
                            <input class="form-check-input" type="radio" name="register_cycle" id="register_cycle_end" onclick="
                            document.getElementById('last_period_start').disabled = true;
                            document.getElementById('last_period_end').disabled = false;">
                            <label for="register_cycle_end" class="col-auto col-form-label">
                                {{ __('Ngày kết thúc vỡ trứng gần nhất:') }}</label>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <input id="last_period_end" type="date" class="form-control" name="last_period_end" required>
                            </div>
                        </div>

                        <div class="form-group row mb-4 justify-content-between">
                            <label for="average_cycle_length" class="col-auto col-form-label">
                                {{ __('Chu kỳ rớt trứng bình thường:') }}</label>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="input-group">
                                    <input id="average_cycle_length" type="number" class="form-control" name="average_cycle_length" value="28" required>
                                    <div class="input-group-text">ngày</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-4 justify-content-between">
                            <label for="average_period_length" class="col-auto col-form-label">
                                {{ __('Số ngày vỡ trứng bình thường:') }}</label>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="input-group">
                                    <input id="average_period_length" type="number" class="form-control" name="average_period_length" value="5" required>
                                    <div class="input-group-text">ngày</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0 justify-content-center">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Đăng ký') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.onload = function(e){ 
        window.history.pushState({}, document.title, window.location.pathname);
    }
</script>
