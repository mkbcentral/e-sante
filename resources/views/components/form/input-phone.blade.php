<div>
    @props(['mask','error'])
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
        </div>
        <input {{$attributes}} type="text" class="form-control @error($error) is-invalid @enderror"" id="{{$mask}}"
               data-mask="{{$mask}}" inputmode="text" placeholder="(___) ___-___-___"
               onchange="this.dispatchEvent(new InputEvent('input'))">
    </div>
    @push('js')
        <script type="module">
            $(function () {
                $('[data-mask]').inputmask('(+243) 999-999-999')
            });

        </script>
    @endpush
</div>
