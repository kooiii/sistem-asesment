<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f4f6f9;">

<div class="container">
    <div class="row justify-content-center" style="margin-top: 100px;">
        <div class="col-md-4">
            
            <div class="card shadow">
                <div class="card-body">

                    <h4 class="text-center mb-4">Login Sistem</h4>

                    {{-- Notifikasi session error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        

                        {{-- NIP --}}
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" value="{{ old('nip') }}" required>
                            {{-- Validasi error --}}
                            @error('nip')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                            {{-- Validasi error --}}
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            {{-- Show/Hide password --}}
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePassword()">
                                <label class="form-check-label" for="showPassword">
                                    Tampilkan Password
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                </div>
            </div>

            <p class="text-center mt-3 text-muted">
                Sistem Penilaian SMK Negeri 1 Sungai Tebelian
            </p>

        </div>
    </div>
</div>

{{-- Script Show/Hide Password --}}
<script>
function togglePassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</body>
</html>