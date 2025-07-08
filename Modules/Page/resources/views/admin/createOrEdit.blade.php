@extends('admin::admin.layouts.master')

@section('title', 'CMS Pages Management')

@section('page-title', 'Create CMS Page')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.pages.index') }}">Manage CMS Pages</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create CMS Page</li>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}"
                        method="POST" id="pageForm">
                        @if (isset($page))
                            @method('PUT')
                        @endif
                        @csrf
                        <div class="row">
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control alphabets-only"
                                        value="{{ $page?->title ?? old('title') }}" required>
                                    @error('title')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control select2" required>
                                        <option value="draft" {{ (($page?->status ?? old('status')) == 'draft') ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ (($page?->status ?? old('status')) == 'published') ? 'selected' : '' }}>Published</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" id="content" class="form-control content-editor">{{ $page?->content ?? old('content') }}</textarea>
                            @error('content')
                                <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End PAge Content -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
    <!-- Select2 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS for the page -->
    <link rel="stylesheet" href="{{ asset('backend/custom.css') }}">           
@endpush

@push('scripts')
    <!-- Then the jQuery Validation plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <!-- Include the CKEditor script -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <!-- Select2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Initialize CKEditor -->
    <script>
    let ckEditorInstance;

    ClassicEditor
    .create(document.querySelector('#content'))
    .then(editor => {
        ckEditorInstance = editor;

        // optional styling
        editor.ui.view.editable.element.style.minHeight = '250px';
        editor.ui.view.editable.element.style.maxHeight = '250px';
        editor.ui.view.editable.element.style.overflowY = 'auto';

        // 🔥 Trigger validation on typing
        editor.model.document.on('change:data', () => {
            const contentVal = editor.getData();
            $('#content').val(contentVal); // keep textarea updated
            $('#content').trigger('keyup'); // trigger validation manually
        });
    })
    .catch(error => {
        console.error(error);
    });
    </script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for any select elements with the class 'select2'
            $('.select2').select2();

            $.validator.addMethod(
                "alphabetsOnly",
                function (value, element) {
                    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
                },
                "Please enter letters only"
            );

            //jquery validation for the form
            $('#pageForm').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        alphabetsOnly: true
                    },
                    content: {
                        required: true,
                        minlength: 3
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a title",
                        minlength: "Title must be at least 3 characters long"
                    },
                    content: {
                        required: "Please enter content",
                        minlength: "Content must be at least 3 characters long"
                    },
                    status: {
                        required: "Please select a status"
                    }
                },
                submitHandler: function(form) {
                    // Update textarea before submit
                    if (ckEditorInstance) {
                        $('#content').val(ckEditorInstance.getData());
                    }
                    const $btn = $('#saveBtn');
                    $btn.prop('disabled', true).text('Saving...');
                    // Now submit
                    form.submit();
                },
                errorElement: 'div',
                errorClass: 'text-danger custom-error',
                errorPlacement: function(error, element) {
                    $('.validation-error').hide(); // hide blade errors
                    if (element.attr("id") === "content") {
                        error.insertAfter($('.ck-editor')); // show below CKEditor UI
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    </script>
@endpush
