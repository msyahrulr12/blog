@csrf
<div class="mb-3">
    <label for="name" class="form-label">Nama Role</label>
    <input type="text" name="name" class="form-control" id="name" value="{{ isset($data) ? $data->name : ''}}" autofocus>
</div>
<button class="btn btn-primary text-white">Submit</button>