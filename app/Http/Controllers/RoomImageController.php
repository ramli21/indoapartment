<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $path = $request->file('gambar')->store('rooms', 'public');

        $roomId = (int) $request->input('room_id');
        if ($roomId > 0) {
            $room = Room::findOrFail($roomId);

            $existing = is_array($room->gambar) ? $room->gambar : [];
            $existing[] = $path;
            $room->gambar = $existing;
            $room->save();
        }

        return response()->json([
            'status' => 'success',
            'path' => $path,
        ]);
    }


    public function delete(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'path' => 'required|string',
        ]);

        $room = Room::findOrFail($request->room_id);

        $path = $request->input('path');
        if (is_array($room->gambar) && in_array($path, $room->gambar, true)) {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            $room->gambar = array_values(array_diff($room->gambar, [$path]));
            $room->save();
        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}

