@csrf
<div class="mb-3">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
      <option value="">--Pilih Role--</option>
      @foreach ($roles as $role)
        <option value="{{ $role->id }}">{{ $role->name }}</option>
      @endforeach
    </select>
</div>
<div class="mb-3">
    <div class="form-check col-sm-12">
      <input class="form-check-input" type="checkbox" name="crud" id="crud">
      <label class="form-check-label" for="crud">
        Permission CRUD? (index, create, edit, show, delete)
      </label>
    </div>
</div>
<div class="mb-3">
    <label for="name" class="form-label">Nama Permission</label>
    <input type="text" name="name" class="form-control" id="name" value="{{ isset($data) ? $data->name : ''}}" autofocus>
</div>
<button class="btn btn-primary text-white">Submit</button>