@csrf
<div class="mb-3">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
      <option value="">--Pilih Role--</option>
      @foreach ($roles as $role)
        <option value="{{ $role->id }}" {{ $data->hasRole($role->name) ? 'selected' : ''}}>{{ $role->name }}</option>
      @endforeach
    </select>
</div>
<div class="mb-3">
    <label for="name" class="form-label">Nama</label>
    <input type="text" name="name" class="form-control" id="name" value="{{ isset($data) ? $data->name : ''}}" autofocus>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="email" value="{{ isset($data) ? $data->email : ''}}">
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="password">
</div>
<button class="btn btn-primary text-white">Submit</button>