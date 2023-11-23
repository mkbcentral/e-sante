<div>
    @props(['id'])
    <textarea {{$attributes}} id="{{$id}}" data-{{$id}}="@this"  placeholder="Saisir les commentaire ici..." class="form-control" >
    </textarea>
    @push('js')
        <script type="module">
            ClassicEditor
                .create( document.querySelector( '#{{$id}}' ) )
                .then( editor => {
                   editor.model.document.on('change:data',()=>{
                       let body=$('#{{$id}}').data('{{$id}}');
                        eval(body).set('{{$id}}',$('#{{$id}}').val())
                   })
                } )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush
</div>
