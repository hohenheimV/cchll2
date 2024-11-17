{{-- Show success message --}}
@if (Session::has('successMessage'))
{!! '<div class="container-fluid mb-1">'.Html::notification_alert('success',session('successMessage')).'</div>' !!}
@endif
{{-- Show fail message --}}
@if (Session::has('errorMessage'))
{!! '<div class="container-fluid mb-1">'.Html::notification_alert('danger',session('errorMessage')).'</div>' !!}
@endif
{{-- Show fail message --}}
@if (Session::has('warningMessage'))
{!! '<div class="container-fluid mb-1">'.Html::notification_alert('warning',session('warningMessage')).'</div>' !!}
@endif
{{-- Show fail message --}}
@if (Session::has('infoMessage'))
{!! '<div class="container-fluid mb-1">'.Html::notification_alert('info',session('infoMessage')).'</div>' !!}
@endif
