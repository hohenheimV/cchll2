@component('mail::message')
{{-- Salam Pembuka --}}
# eLANDSKAP - Tetapan Semula Kata Laluan

{{-- Pengenalan --}}
Anda menerima emel ini kerana kami telah menerima permintaan untuk menetapkan semula kata laluan bagi akaun anda.

{{-- Butang Tindakan --}}
@component('mail::button', ['url' => $actionUrl])
Tetapkan Kata Laluan
@endcomponent

{{-- Penutup --}}
Jika anda tidak membuat permintaan ini, anda boleh abaikan emel ini. Tiada tindakan lanjut diperlukan.

Sekiranya anda memerlukan bantuan lanjut, sila hubungi pentadbir sistem atau pasukan sokongan kami.

{{-- Ucapan Akhir --}}
Salam hormat,<br>
**Pasukan eLANDSKAP**

{{-- Nota Tambahan --}}
@slot('subcopy')
Jika anda menghadapi masalah untuk menekan butang **"Tetapkan Kata Laluan"**, salin dan tampal pautan di bawah ke dalam pelayar web anda:

[{{ $displayableActionUrl }}]({{ $actionUrl }})
@endslot
@endcomponent
