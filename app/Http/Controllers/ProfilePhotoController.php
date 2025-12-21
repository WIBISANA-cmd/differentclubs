<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilePhotoController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'avatar' => ['required', 'image', 'max:2048'],
            'crop.x' => ['nullable', 'numeric', 'min:0'],
            'crop.y' => ['nullable', 'numeric', 'min:0'],
            'crop.width' => ['nullable', 'numeric', 'min:1'],
            'crop.height' => ['nullable', 'numeric', 'min:1'],
        ]);

        $file = $validated['avatar'];
        $imageData = file_get_contents($file->getRealPath());
        $source = imagecreatefromstring($imageData);

        if ($source === false) {
            return back()->withErrors(['avatar' => 'Tidak dapat memproses gambar.']);
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if (isset($validated['crop']['width'], $validated['crop']['height'])) {
            $cropX = (int) ($validated['crop']['x'] ?? 0);
            $cropY = (int) ($validated['crop']['y'] ?? 0);
            $cropW = (int) $validated['crop']['width'];
            $cropH = (int) $validated['crop']['height'];
            $source = imagecrop($source, [
                'x' => max(0, $cropX),
                'y' => max(0, $cropY),
                'width' => min($cropW, $width),
                'height' => min($cropH, $height),
            ]) ?: $source;
        }

        // Resize to a reasonable square thumbnail
        $size = 400;
        $source = imagescale($source, $size, $size, IMG_BILINEAR_FIXED) ?: $source;

        $filename = 'avatar_' . Str::uuid() . '.png';
        $path = 'avatars/' . $user->id . '/' . $filename;
        ob_start();
        imagepng($source);
        $pngData = ob_get_clean();
        imagedestroy($source);

        Storage::disk('public')->put($path, $pngData);

        // Remove old avatar if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->forceFill([
            // Store the relative path so Storage::url can resolve it correctly
            'profile_photo_path' => $path,
        ])->save();

        return back()->with('status', 'Avatar updated.');
    }
}
