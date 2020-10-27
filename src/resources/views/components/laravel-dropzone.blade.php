@php

    $laravelDropzoneId = isset($dz_id) ? $dz_id : 'laravelDropzone' . Str::random(8);
    // $acceptedFileTypes = config()->has('upload.'.$params['upload_type'].'.allowed_file_types') ? config('upload.'.$params['upload_type'].'.allowed_file_types') : config('upload.allowed_file_types');
    // $maxFileSizeLimit = config()->has('upload.'.$params['upload_type'].'.max_file_size_limit') ? config('upload.'.$params['upload_type'].'.max_file_size_limit') : config('upload.max_file_size_limit');

@endphp

<div class="dropzone dropzone-multi" id="{{ $laravelDropzoneId }}">
    <div class="dropzone-panel mb-lg-0 mb-2">
        <a class="dropzone-select btn btn-light-primary font-weight-bold btn-sm">Attach files</a>
    </div>
    <div class="dropzone-items">
        <div class="dropzone-item" style="display:none">
            <div class="dropzone-file">
                <div class="dropzone-filename" title="some_image_file_name.jpg">
                    <span data-dz-name="">some_image_file_name.jpg</span>
                    <strong>(
                    <span data-dz-size="">340kb</span>)</strong>
                </div>
                <div class="dropzone-error" data-dz-errormessage=""></div>
            </div>
            <div class="dropzone-progress">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress=""></div>
                </div>
            </div>
            <div class="dropzone-toolbar">
                <span class="dropzone-delete" data-dz-remove="">
                    <i class="flaticon2-cross"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div style="display:none" id="{{ $laravelDropzoneId }}-uploaded-files"></div>

<script type="application/javascript">

    document.addEventListener('DOMContentLoaded', function(event) {

        var uploadedDocumentMap = {}

        // set the dropzone container id
        var id = '#{{ $laravelDropzoneId }}';

        // set the preview element template
        var previewNode = $(id + " .dropzone-item");
        previewNode.id = "";
        var previewTemplate = previewNode.parent('.dropzone-items').html();
        previewNode.remove();

        var {{ $laravelDropzoneId }} = new Dropzone(id, { // Make the whole body a dropzone
            url: '{{ route('uploader.store') }}', // Set the url for your upload script location
            paramName: 'file', // The name that will be used to transfer the file
            parallelUploads: 20,
            maxFilesize: 1, // Max filesize in MB
            previewTemplate: previewTemplate,
            previewsContainer: id + " .dropzone-items", // Define the container to display the previews
            clickable: id + " .dropzone-select" // Define the element that should be used as click trigger to select files.
        });

        {{ $laravelDropzoneId }}.on('addedfile', function(file) {
            // Hookup the start button
            $(document).find( id + ' .dropzone-item').css('display', '');
        });

        // Update the total progress bar
        {{ $laravelDropzoneId }}.on('totaluploadprogress', function(progress) {
            $( id + ' .progress-bar').css('width', progress + '%');
        });

        {{ $laravelDropzoneId }}.on('sending', function(file) {
            // Show the total progress bar when upload starts
            $( id + ' .progress-bar').css('opacity', '1');
        });

        // Hide the total progress bar when nothing's uploading anymore
        {{ $laravelDropzoneId }}.on('complete', function(progress) {
            var thisProgressBar = id + ' .dz-complete';
            setTimeout(function(){
                $( thisProgressBar + ' .progress-bar, ' + thisProgressBar + ' .progress').css('opacity', '0');
            }, 300)
        });

        // TODO
        {{ $laravelDropzoneId }}.on('success', function(file, response) {

            uploadedDocumentMap[file.name] = response.token;

            $('#{{ $laravelDropzoneId }}-uploaded-files').append('<input type="hidden" name="laravel_dropzone_files[]" value="' + response.token + '">')

        });

        // TODO
        {{ $laravelDropzoneId }}.on('removedfile', function(file) {

            file.previewElement.remove()

            var token = ''
            if (typeof file.file_name !== 'undefined') {
                token = file.file_name
            } else {
                token = uploadedDocumentMap[file.name]
            }

            var req = new XMLHttpRequest();
            req.open('POST', '{{ route('uploader.destroy') }}');
            req.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            req.send(JSON.stringify({ token: token }));

            // $('#{{ $laravelDropzoneId }}-uploaded-files'').find('input[name="laravel_dropzone_files[]"][value="' + token + '"]').remove()

        });

        // function onSuccess(file, response) {

        //     uploadedDocumentMap[file.name] = response.token

        //     var laravelDropzoneFileField = document.createElement('input');
        //     laravelDropzoneFileField.setAttribute('type', 'hidden');
        //     laravelDropzoneFileField.setAttribute('name', 'laravel_dropzone_files[]');
        //     laravelDropzoneFileField.setAttribute('value', response.token );

        //     document.getElementById('{{ $laravelDropzoneId }}-uploaded-files').appendChild(laravelDropzoneFileField);

        // }

        // var uploadedDocumentMap = {}

        // // Disable auto discover for all elements:
        // Dropzone.autoDiscover = false;

        // Dropzone.options.{{ $laravelDropzoneId }} = {
        //     url: '{{ route('uploader.store') }}',
        //     addRemoveLinks: true,
        //     clickable: true,
        //     paramName: 'file', // The name that will be used to transfer the file
        //     maxFilesize: 2, // MB
        //     success: function (file, response) {

        //         onSuccess(file, response);

        //     },
        //     removedfile: function (file) {

        //         file.previewElement.remove()

        //         var token = ''
        //         if (typeof file.file_name !== 'undefined') {
        //             token = file.file_name
        //         } else {
        //             token = uploadedDocumentMap[file.name]
        //         }

        //         var req = new XMLHttpRequest();
        //         req.open('POST', '{{ route('uploader.destroy') }}');
        //         req.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        //         req.send(JSON.stringify({ token: token }));

        //         // $('form').find('input[name="document[]"][value="' + name + '"]').remove()
        //     },
        // };

        // var {{ $laravelDropzoneId }} = new Dropzone('div#{{ $laravelDropzoneId }}');

    });

</script>
