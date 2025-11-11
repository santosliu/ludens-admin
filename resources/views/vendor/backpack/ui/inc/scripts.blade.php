@basset('https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js')
@basset('https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js')
@basset('https://cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib/noty.min.js')
@basset('https://cdn.jsdelivr.net/npm/sweetalert@2.1.2/dist/sweetalert.min.js')

<script>
// 設定所有 DataTables 的 CSRF token
$(document).ready(function() {
    // jQuery Ajax 全域設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // DataTables 專用設定
    $.fn.dataTable.ext.errMode = 'none'; // 避免顯示錯誤彈窗
    
    // 攔截所有 DataTables Ajax 請求
    $.fn.dataTable.ext.preXhr = function(settings, data) {
        var api = this.api();
        var ajaxSettings = api.settings()[0].jqXHR;
        
        if (ajaxSettings && ajaxSettings.setRequestHeader) {
            ajaxSettings.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }
    };
});
</script>

@if (backpack_theme_config('scripts') && count(backpack_theme_config('scripts')))
    @foreach (backpack_theme_config('scripts') as $path)
        @if(is_array($path))
            @basset(...$path)
        @else
            @basset($path)
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_scripts') && count(backpack_theme_config('mix_scripts')))
    @foreach (backpack_theme_config('mix_scripts') as $path => $manifest)
        <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

@if (backpack_theme_config('vite_scripts') && count(backpack_theme_config('vite_scripts')))
    @vite(backpack_theme_config('vite_scripts'))
@endif

@include(backpack_view('inc.alerts'))

@if(config('app.debug'))
    @include('crud::inc.ajax_error_frame')
@endif

@push('after_scripts')
    @basset(base_path('vendor/backpack/crud/src/resources/assets/js/common.js'))
@endpush
