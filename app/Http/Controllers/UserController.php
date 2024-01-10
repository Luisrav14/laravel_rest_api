<?php

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json(['status' => 'success', 'data' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(['status' => 'success', 'data' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Usuario creado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un error al crear el usuario.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string',
        ]);

        try {
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->filled('password') ? bcrypt($request->input('password')) : $user->password,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Usuario actualizado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un error al actualizar el usuario.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return response()->json(['status' => 'success', 'message' => 'Usuario eliminado exitosamente.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un error al eliminar el usuario.'], 500);
        }
    }
}
