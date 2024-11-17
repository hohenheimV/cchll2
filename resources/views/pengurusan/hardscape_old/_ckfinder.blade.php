<script src="{{ asset('js/ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script src="{{ asset('js/ckfinder/ckfinder.js') }}"></script>
<script>
    CKFinder.config({
        connectorPath: window.location.hostname == 'tpbk.test' ? '/ckfinder/connector' : '/tpbk/ckfinder/connector',//'/ckfinder/connector',
        resourceType: 'Hardscape'
    });

    $(document).ready(function () {

        $(document).on("click", ".ckfinder", function(event){
            var type = $(this).data('type');
            btnCkfinders(type);
        });

        function btnCkfinders(type) {

            CKFinder.modal({
                chooseFiles: true,
                width: 800,
                height: 650,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        var file = evt.data.files.first();
                        var input = document.getElementById('input-'+type);
                        var image = document.getElementById('img-'+type);
                        input.value = file.getUrl();
                        image.src = file.getUrl();
                    });

                    finder.on('file:choose:resizedImage', function (evt) {
                        var file = evt.data.files.first();
                        var input = document.getElementById('input-'+type);
                        var image = document.getElementById('img-'+type);
                        input.value = file.getUrl();
                        image.src = file.getUrl();
                    });
                }
            });
        }
    });

</script>

