<div class="modal fade animated rotateInDownLeft custo-rotateInDownLeft" id="bannerImageModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">صور البنر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">


                    <div class="box-body">

                        <div class="col-md-12">
                            <form method="post" action="{{ route('dashboard.banners.uploadImage') }}"
                                  enctype="multipart/form-data" class="dropzone" id="demo-upload">
                                @csrf
                                <input type="hidden" name='banner_id' id='banner_id' >

                            </form>
                            <div class="row image_preview">

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> {{__('dash.close')}}</button>
                        </div>
                    </div>

            </div>

        </div>
    </div>
</div>


@push('script')
    <script>

        $("body").on('change', '.type', function () {
            if ($(this).val() == 'evaluative'){

            $('.type-col').removeClass('col-md-6');
            $('.type-col').addClass('col-md-4');
            $('.price-col').removeClass('col-md-6');
            $('.price-col').addClass('col-md-4');
            $('.start_from').show();


        }else{
                $('.type-col').removeClass('col-md-4');
                $('.type-col').addClass('col-md-6');
                $('.price-col').removeClass('col-md-4');
                $('.price-col').addClass('col-md-6');
                $('.start_from').hide();

            }

        })


        $(function() {
            // access Dropzone here

            var dropzone = new Dropzone('#demo-upload', {
                url: "{{ route('dashboard.banners.uploadImage') }}",
                maxFilesize: 1,
                paramName: 'file',
                addRemoveLinks: true,
                autoProcessQueue: true,
                parallelUploads: 1,
                dictRemoveFile: '{{__('dash.Remove file')}}',
                params: {
                    _token: '{{csrf_token()}}',
                    banner_id: $("#banner_id").val(),
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                success: function (file, response) {
                    file.id = response.id;
                    console.log(response);
                },
                removedfile: function (file) {
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: '{{route('dashboard.banners.deleteImage')}}',
                        data: {'_token': ' {{ csrf_token() }}', id: file.id},
                        success: function (data) {
                            console.log('success: ' + data);
                        }
                    })
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },


            });

        });


    </script>
    @endpush
