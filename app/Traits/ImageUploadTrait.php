<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

trait ImageUploadTrait
{
  /**
   * Upload an image to the specified directory in Laravel storage.
   *
   * @param UploadedFile $image The image file to be uploaded.
   * @param string $directory The directory within the storage to upload the image.
   * @return string|null The path of the uploaded file or null on failure.
   */
  public function uploadImage(UploadedFile $image, string $directory): ?string
  {
    try {
      // Generate a unique file name with extension
      $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

      // Store the file in the specified directory and get the path
      $filePath = $image->storeAs($directory, $fileName, 'public');

      return $filePath; // e.g., "directory/unique-id.jpg"
    } catch (\Exception $e) {
      // Log error if needed and return null
      logger()->error('Image upload failed: ' . $e->getMessage());
      return null;
    }
  }

  /**
   * Delete an image from the specified path in Laravel storage.
   *
   * @param string $filePath The path of the file to be deleted.
   * @return bool True if the file was deleted successfully, false otherwise.
   */
  /**
   * Delete an image from the specified path in Laravel storage.
   *
   * @param string $filePath The path of the file to be deleted.
   * @return bool True if the file was deleted successfully, false otherwise.
   */
  public function deleteImage(string $filePath): bool
  {
    try {
      // Ensure the file path is relative to the storage root
      $relativePath = str_replace('storage/', '', $filePath);

      // Check if the file exists before attempting to delete
      if (Storage::disk('public')->exists($relativePath)) {
        return Storage::disk('public')->delete($relativePath);
      }

      return false;
    } catch (\Exception $e) {
      // Log error if needed and return false
      logger()->error('Image deletion failed: ' . $e->getMessage());
      return false;
    }
  }

}
