<template>
  <div class="dropzone dropzone-default mb-8">
    <div class="dropzone-msg dz-message needsclick">
      <i class="fas fa-file-alt text-primary display-1 mb-5"></i>
      <h3 class="dropzone-msg-title">Drop files here or <a href="javascript:void(0)">click to upload</a>.</h3>
      <br />
      <span class="dropzone-msg-desc">Maximum file size is <strong>{{ maxFileSizeInMb }} MB</strong>.</span><br />
      <span class="dropzone-msg-desc">Accepted file types <strong>{{ allowedFileTypes }}</strong>.</span>
    </div>
  </div>
</template>
<script>
export default {
props: {
    uploadType: {
        type: String,
    },
    modelId: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      dropzone: '',
      allowedFileTypes: '',
      maxFileSizeInMb: '',
    };
  },
  created: function() {

      // Disable auto discover for all elements:
      Dropzone.autoDiscover = false;

      this.loadUploadTypeSettings();
  },
  methods: {
    loadUploadTypeSettings() {
        axios.get('/uploader/' + this.uploadType + '/settings')
            .then((response) => {

                this.allowedFileTypes = response.data.data.allowed_file_types;
                this.maxFileSizeInMb = response.data.data.max_file_size_in_mb;

                this.initDropzone();

            })
            .catch((error) => {});
    },
    initDropzone() {

        this.dropzone = new Dropzone(this.$el, {
            url: '/uploader',
            paramName: 'file',
            addRemoveLinks: true,
            acceptedFiles: this.allowedFileTypes,
            maxFilesize: this.maxFileSizeInMb,
        });

        this.dropzone.on('sending', (file, xhr, formData) => {
            formData.append('model_id', this.modelId);
            formData.append('upload_type', this.uploadType);
        });

        this.dropzone.on('complete', (file) => {
            window.events.$emit('dropzone-complete', file);
            this.dropzone.removeFile(file);
        });

    }
  },
};
</script>
