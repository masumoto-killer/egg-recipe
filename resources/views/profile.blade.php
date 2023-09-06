@extends('app2')

@section('content')
<div class="container d-flex align-items-start justify-content-center mt-4 flex-wrap">
    <div class="col-xl-6 col-lg-8 col-md-10">
        <div class="text-center card mb-4">
            <div class="card-header">{{ ('Thông tin người dùng') }}</div>
            <div class="card-body d-flex justify-content-center">
                <div class="col-auto lh-lg d-flex flex-column text-start">
                    <div>Tên: {{ $user->name }}</div>
                    <div>Email: {{ $user->email }}</div>
                    <div>Số ngày trung bình trong mỗi chu kỳ: {{ $user->period_length }}</div>
                    <div>Khoảng cách trung bình giữa các chu kỳ: {{ $user->cycle_length }}</div>
                </div>
            </div>
        </div>

        <div class="text-center card">
            <div class="card-header">{{ ('Cài đặt thông báo chu kỳ mới') }}</div>
            <div class="card-body d-flex justify-content-center">
                <form method="POST" action="{{ route('set-mail-noti') }}" class="d-flex flex-column">
                @csrf
                @method('PUT')
                    <div class="form-check form-switch container text-start pl-4">
                        <input class="form-check-input my-0" type="checkbox"
                        id="enableEmail" <?php if ($user->mail_date != '0') {echo 'checked';}?>>
                        <label class="form-check-label px-0" for="enableEmail">Sử dụng email:</label>
                    </div>

                    <div class="container flex-nowrap align-items-center d-flex" id="setEmail">
                        <div class="text-nowrap col-auto">Gửi thông báo trước</div>
                        <div class="input-group col-auto p-0 mx-1">
                            <input type="number" class="form-control" 
                            id="mail_date" name="mail_date" value="{{ $user->mail_date }}" min="1" max="{{ $user->cycle_length }}" required>
                            <span class="input-group-text">ngày</span>
                        </div>
                        <div class="text-nowrap col-auto">vào lúc</div>
                        <input type="time" class="form-control w-auto mx-1" id="mail_time" name="mail_time" value="{{ $user->mail_time }}" required>
                    </div>

                    <div class="col-auto mt-3">
                        <button type="submit" id="save" class="btn btn-primary btn-sm"><i class="bi bi-check-lg"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#save").prop("disabled", true);

        if($("#enableEmail").is(":checked")) {
                $("#mail_date,#mail_time").prop("disabled", false );
            } else {
                $("#mail_date,#mail_time").prop("disabled", true );
            }
        
        $("#enableEmail").click(function() {
            if($(this).is(":checked")) {
                $("#mail_date,#mail_time").prop("disabled", false );
            } else {
                $("#mail_date,#mail_time").prop("disabled", true );
            }
        });

        $("#enableEmail,#mail_date,#mail_time").on("change",function () {
            $("#save").prop("disabled", false);
        });
    });
</script>                        
@endsection
