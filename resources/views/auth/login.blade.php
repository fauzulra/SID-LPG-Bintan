<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>Login Page</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<link href="{{ asset('css/login.css') }}" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="{{ asset('img/bintan.png') }}">
</head>

<body>
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form id="registerForm" action="{{ route('register') }}" method="POST">
				@csrf
				<h1>Register</h1>
				<input type="text" name="name" placeholder="Username" style="margin-top: 30px;" required />
				<input type="email" name="email" placeholder="Email" required />
				<input type="password" name="password" placeholder="Password" required />
				{{-- <select name="role" required style="margin-top: 10px;">
					<option value="">Pilih Role</option>
					<option value="agen_lpg">Agen Lpg</option>
					<option value="distributor">Distributor</option>
				</select> --}}
				<button id="registerButton" style="margin-top: 30px;" type="submit">Register</button>
			</form>
		</div>
		<div class="form-container sign-in-container">
			<form action="{{ route('login') }}" method="POST">
				@csrf
				<h1>Login</h1>
				<input type="email" name="email" placeholder="Email" style="margin-top: 30px;" required />
				<input type="password" name="password" placeholder="Password" required />
				<a href="#" style="margin-top: 20px">Lupa Password?</a>
				<button style="margin-top: 10px" type="submit">Login</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h2>Sudah Punya akun?</h2>
					<p>Silahkan Login Dengan Akun <br> Yang Sudah Ada</p>
					<button class="ghost" id="signIn">Login</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h2>Belum Punya Akun?</h2>
					<p>Silahkan Daftarkan Akun <br>Terlebih Dahulu</p>
					<button class="ghost" id="signUp">Register</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Success Modal -->
	<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-header-custom text-white">
					<h5 class="modal-title">Registrasi Berhasil!</h5>
				</div>
				<div class="modal-body">
					<p id="successMessage">Anda telah berhasil registrasi. Silakan login dengan akun Anda.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Error Modal -->
	<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title">Registrasi Gagal!</h5>
				</div>
				<div class="modal-body">
					<p id="errorMessage">Terjadi kesalahan saat registrasi. Silakan coba lagi.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- JavaScript for AJAX Form Submission -->
	<script>
		document.getElementById('registerForm').addEventListener('submit', async function (e) {
			e.preventDefault();

			const form = e.target;
			const formData = new FormData(form);

			try {
				const response = await fetch(form.action, {
					method: 'POST',
					body: formData,
					headers: {
						'Accept': 'application/json',
						'X-CSRF-TOKEN': '{{ csrf_token() }}'
					}
				});

				const data = await response.json();

				if (data.success) {
					// Show success modal
					document.getElementById('successMessage').textContent = data.message;
					$('#successModal').modal('show');
					form.reset();
				} else {
					// Show error modal
					document.getElementById('errorMessage').textContent = data.message;
					$('#errorModal').modal('show');
				}
			} catch (error) {
				document.getElementById('errorMessage').textContent = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
				$('#errorModal').modal('show');
			}
		});
	</script>
	<!-- Skrip login.js -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="{{ asset('js/login.js') }}"></script>

</body>

</html>