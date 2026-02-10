<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Requests\UpdateAcountRequest;

class AcountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('acount.index', compact('user'));
    }

    public function store(UpdateAcountRequest $request)
    {
        $user = Auth::user();
        $validatedData = $request->validated();

        // Update data selain foto
        $user->fill(Arr::except($validatedData, ['foto']));

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.jpg';

            // Simpan file hasil crop
            $file->storeAs('uploads/avatars', $filename, 'public');

            // Hapus foto lama jika bukan default
            if ($user->foto && $user->foto !== '1.png' && \Storage::disk('public')->exists('uploads/avatars/' . $user->foto)) {
                \Storage::disk('public')->delete('uploads/avatars/' . $user->foto);
            }

            $user->foto = $filename;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
    }

    public function security()
    {
        $user = Auth::user();
        return view('acount.security', compact('user'));
    }

    public function updatePassword(\App\Http\Requests\UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->newPassword);
        $user->save();

        return redirect()->route('acount.security')->with('success', 'Password berhasil diubah!');
    }
}