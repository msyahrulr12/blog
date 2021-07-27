@csrf

<div class="title mb-3">
    <h6><u>Personal Data</u></h6>
</div>

<div class="mb-3">
    <label for="name">Nama</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $data->name }}">
</div>
<div class="mb-3">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ $data->email }}">
</div>
<hr>

<div class="title mb-3 mt-3">
    <h6><u>Change Password</u></h6>
</div>

<div class="mb-3">
    <label for="password">New Password</label>
    <input type="password" name="password" id="password" class="form-control">
</div>
<div class="mb-3">
    <label for="repeat_password">Repeat Password</label>
    <input type="password" name="repeat_password" id="repeat_password" class="form-control">
</div>
<button class="btn btn-primary text-white">Submit</button>