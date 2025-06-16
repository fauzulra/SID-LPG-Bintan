<?php



    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use Spatie\Permission\Models\Role;
  

    class UserController extends Controller
    {
        


        public function showLoginForm()
        {
            Auth::logout(); // Paksa logout
            request()->session()->invalidate(); // Hapus semua session
            request()->session()->regenerateToken(); // Buat CSRF token baru
            
            // $roles = Role::where('name', '!=', 'admin')->get();
            return view('auth.login');
        }
       public function register(Request $request)
        {
            // Validasi input termasuk role
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string',
                // 'role' => 'required|in:agen_lpg,distributor', // Validasi pilihan role
            ]);

            // Jika validasi gagal, kembalikan error
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            DB::beginTransaction();

            try {
                // Buat user
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ]);

                // Berikan role dari input
                if ($user->id == 1) {
                        $user->assignRole('admin');
                    } else {
                        $user->assignRole('distributor');
                    }

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Registrasi berhasil! Silakan login.',
                    'redirect' => route('login')
                ]);

            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat registrasi: ' . $e->getMessage(),
                ], 500);
            }
        }


        /**
         * Fungsi untuk login pengguna
         */
        public function login(Request $request)
        {
            // Validasi input login
            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            

            // Cek apakah email dan password benar
            if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
                // Login berhasil, redirect ke dashboard

                $user = Auth::user();
                 
                return redirect()->route('dashboard');
                

            } else {
                // Jika login gagal, kembali ke form login dengan pesan error
                return redirect()->back()->with('error', 'Email Atau Password Salah!');
            }

            
        }

        public function logout()
        {
            Auth::logout();
    
        request()->session()->invalidate();
    
        request()->session()->regenerateToken();
    
        return redirect('/login');
        }
    }
