<div class="row">

  {{-- ============================================================
       EXPORT
  ============================================================ --}}
  <div class="col-md-6">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-download"></i> Export Brands</h3>
      </div>
      <div class="box-body">
        <p class="text-muted">
          Select a site and (optionally) specific brands. The result is a ZIP where every brand
          gets its own folder with <code>brand.json</code>, <code>seo.json</code>,
          <code>faq.json</code>, <code>text_blocks.json</code> and <code>states.json</code>.
          Edit the files, then re-import the same ZIP.
        </p>

        @if($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ admin_url('brand_exim/export') }}">
          @csrf

          <div class="form-group">
            <label>Site <span class="text-red">*</span></label>
            <select name="site_id" id="export_site_id" class="form-control" required>
              <option value="">— select site —</option>
              @foreach($sites as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group" id="export_brands_wrap" style="display:none">
            <label>Brands <span class="text-muted">(leave empty to export ALL brands of the site)</span></label>
            <select name="brand_ids[]" id="export_brand_ids" class="form-control" multiple style="height:160px">
            </select>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fa fa-download"></i> Download ZIP
          </button>
        </form>
      </div>
    </div>
  </div>

  {{-- ============================================================
       IMPORT
  ============================================================ --}}
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-upload"></i> Import Brands</h3>
      </div>
      <div class="box-body">
        <p class="text-muted">
          Upload a ZIP previously exported from this tool (or one you built manually with the same
          folder/file structure). Brands are matched by <strong>slug</strong> within the selected
          site. Unknown slugs are skipped — no new brands are created.
        </p>

        <form method="POST" action="{{ admin_url('brand_exim/import') }}" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label>Target Site <span class="text-red">*</span></label>
            <select name="site_id" class="form-control" required>
              <option value="">— select site —</option>
              @foreach($sites as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label>ZIP File <span class="text-red">*</span></label>
            <input type="file" name="zip_file" class="form-control" accept=".zip" required>
          </div>

          <div class="form-group">
            <label>
              <input type="checkbox" name="dry_run" value="1">
              &nbsp;Dry run (validate only, make no DB changes)
            </label>
          </div>

          <button type="submit" class="btn btn-success">
            <i class="fa fa-upload"></i> Import
          </button>
        </form>
      </div>
    </div>
  </div>

</div>

{{-- ============================================================
     IMPORT RESULT
============================================================ --}}
@if(!empty($session))
<div class="row">
  <div class="col-md-12">
    <div class="box {{ $session['dry_run'] ? 'box-warning' : 'box-success' }}">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fa fa-list-alt"></i>
          Import result — site: <strong>{{ $session['site'] }}</strong>
          @if($session['dry_run'])<span class="label label-warning">DRY RUN — no changes written</span>@endif
        </h3>
      </div>
      <div class="box-body">

        @if(!empty($session['updated']))
          <h4 class="text-green"><i class="fa fa-check"></i> Updated ({{ count($session['updated']) }})</h4>
          <ul>
            @foreach($session['updated'] as $slug)<li><code>{{ $slug }}</code></li>@endforeach
          </ul>
        @endif

        @if(!empty($session['skipped']))
          <h4 class="text-orange"><i class="fa fa-minus-circle"></i> Skipped ({{ count($session['skipped']) }})</h4>
          <ul>
            @foreach($session['skipped'] as $msg)<li>{{ $msg }}</li>@endforeach
          </ul>
        @endif

        @if(!empty($session['errors']))
          <h4 class="text-red"><i class="fa fa-exclamation-triangle"></i> Errors ({{ count($session['errors']) }})</h4>
          <ul>
            @foreach($session['errors'] as $msg)<li>{{ $msg }}</li>@endforeach
          </ul>
        @endif

      </div>
    </div>
  </div>
</div>
@endif

{{-- Dynamic brand list for export site selector --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var siteSelect   = document.getElementById('export_site_id');
    var brandsWrap   = document.getElementById('export_brands_wrap');
    var brandsSelect = document.getElementById('export_brand_ids');

    siteSelect.addEventListener('change', function () {
        var siteId = this.value;
        brandsSelect.innerHTML = '';
        if (!siteId) { brandsWrap.style.display = 'none'; return; }

        fetch('{{ admin_url("brand_exim/brands") }}?site_id=' + siteId)
            .then(function(r){ return r.json(); })
            .then(function(data){
                data.forEach(function(b){
                    var opt = document.createElement('option');
                    opt.value = b.id;
                    opt.textContent = b.name + ' (' + b.domain + ')';
                    brandsSelect.appendChild(opt);
                });
                brandsWrap.style.display = 'block';
            });
    });
});
</script>
