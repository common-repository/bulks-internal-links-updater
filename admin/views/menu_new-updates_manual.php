<div class="update_manual_content hidden"></div>
<form class="update-manual-form">
    <div class="row">
        <div class="col col-6">
            <label class="form-label">Post</label>
            <select class="form-control" name="posts" id="posts"></select>
        </div>
        <div class="col col-6">
            <label class="form-label">Internal Link</label>
            <select class="form-control" name="post_internal_links" id="post_internal_links"></select>
        </div>
    </div>
    <div class="row">
        <div class="col col-6">
            <label class="form-label">Replacement Text</label>
            <input type="text" class="form-control" name="replacement_text" id="replacement_text">
            <span class="form-caption">Left it empty for skip update</span>
        </div>
        <div class="col col-6">
            <label class="form-label">Replacement Hyperlink</label>
            <input type="text" class="form-control" name="replacement_hyperlink" id="replacement_hyperlink">
        </div>
    </div>
    <button type="button" class="btn btn-primary form-action" id="update_manual">Update Now</button>
</form>