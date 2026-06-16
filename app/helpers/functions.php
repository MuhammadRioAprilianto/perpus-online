<?php

/**
 * Application helper functions.
 *
 * Provides utility functions used across the application for
 * redirection, input sanitization, session flash messages,
 * authentication checks, and formatting.
 */

// Require the icons component so renderIcon() is available globally
require_once APP_ROOT . '/views/components/icons.php';

// 1. Fungsi untuk memanggil aset statis lokal (CSS, JS, dan Gambar Cover)
// Fungsi ini memastikan gambar milikmu dipanggil dengan path yang benar dari folder public/
function asset($path) {
    return BASEURL . '/' . ltrim($path, '/');
}

// 2. Fungsi untuk format tanggal menjadi lebih rapi (contoh: 10 Jun 2026 14:30)
function formatTanggal($tanggal) {
    if (!$tanggal) return '-';
    return date('d M Y H:i', strtotime($tanggal));
}

// 3. Fungsi untuk mengecek sisa waktu peminjaman sebelum batal otomatis (15 menit)
// Sangat berguna untuk ditampilkan di antarmuka User (UI)
function sisaWaktuBatal($request_time) {
    $waktu_request = strtotime($request_time);
    $waktu_sekarang = time();
    $selisih_detik = $waktu_sekarang - $waktu_request;
    $batas_detik = 15 * 60; // 15 menit

    if ($selisih_detik >= $batas_detik) {
        return 0; // Waktu sudah habis
    }
    
    return floor(($batas_detik - $selisih_detik) / 60); // Mengembalikan sisa menit
}

/**
 * Redirect the client to a specified URL path.
 *
 * @param string $path The relative URL path to redirect to.
 * @return void
 */
function redirect(string $path): void
{
    header('Location: ' . BASE_URL . $path);
    exit;
}

/**
 * Sanitize user input to prevent XSS attacks.
 *
 * @param string $data The raw input string to sanitize.
 * @return string The sanitized string safe for HTML output.
 */
function sanitize(string $data): string
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Set a flash message in the session for one-time display.
 *
 * @param string $type    The message type (success, error, warning, info).
 * @param string $message The message content to display.
 * @return void
 */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type'    => $type,
        'message' => $message,
    ];
}

/**
 * Retrieve and clear the current flash message from the session.
 *
 * @return array|null The flash message array or null if none exists.
 */
function getFlash(): ?array
{
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Check whether a user is currently logged in.
 *
 * @return bool True if a user session exists.
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Check whether the currently logged-in user has admin privileges.
 *
 * @return bool True if the user role is admin.
 */
function isAdmin(): bool
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Get the currently authenticated user's ID.
 *
 * @return int|null The user ID or null if not logged in.
 */
function getCurrentUserId(): ?int
{
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get the currently authenticated user's username.
 *
 * @return string|null The username or null if not logged in.
 */
function getCurrentUsername(): ?string
{
    return $_SESSION['username'] ?? null;
}

/**
 * Format a numeric value as Indonesian Rupiah currency.
 *
 * @param float $amount The monetary amount to format.
 * @return string The formatted currency string (e.g., "Rp 25.000").
 */
function formatCurrency(float $amount): string
{
    return 'Rp ' . number_format($amount, 0, ',', '.');
}

/**
 * Generate a unique order number with date-based prefix.
 *
 * @return string The generated order number (e.g., "PSN-20260517-A3F8").
 */
function generateOrderNumber(): string
{
    return 'PSN-' . date('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(2)), 0, 4));
}

/**
 * Retrieve a previously submitted form value for repopulation.
 *
 * @param string $key     The form field name.
 * @param string $default The default value if not found.
 * @return string The previously submitted value or the default.
 */
function old(string $key, string $default = ''): string
{
    return $_SESSION['old_input'][$key] ?? $default;
}

/**
 * Store form input values in the session for repopulation after validation failure.
 *
 * @param array $data The associative array of form field values.
 * @return void
 */
function setOldInput(array $data): void
{
    $_SESSION['old_input'] = $data;
}

/**
 * Clear previously stored old input values from the session.
 *
 * @return void
 */
function clearOldInput(): void
{
    unset($_SESSION['old_input']);
}

/**
 * Require the user to be logged in; redirect to login page otherwise.
 *
 * @return void
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        setFlash('error', 'Please login to continue.');
        redirect('/login');
    }
}

/**
 * Require the user to have admin role; redirect to home otherwise.
 *
 * @return void
 */
function requireAdmin(): void
{
    requireLogin();
    if (!isAdmin()) {
        setFlash('error', 'Access denied. Admin privileges required.');
        redirect('/');
    }
}

/**
 * Handle file upload with validation for images.
 *
 * @param array  $file      The $_FILES array entry for the uploaded file.
 * @param string $uploadDir The target directory for the uploaded file.
 * @return string|false The saved filename on success, or false on failure.
 */
function handleImageUpload(array $file, string $uploadDir)
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return false;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!in_array($mimeType, ALLOWED_IMAGE_TYPES, true)) {
        return false;
    }

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $extension = match ($mimeType) {
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        default      => 'jpg',
    };

    $filename = uniqid('img_', true) . '.' . $extension;
    $destination = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }

    return false;
}

/**
 * Render a view file with optional data extraction.
 *
 * @param string $view The view file path relative to the views directory.
 * @param array  $data The associative array of variables to pass to the view.
 * @return void
 */
function renderView(string $view, array $data = []): void
{
    extract($data);
    $viewPath = APP_ROOT . '/views/' . $view . '.php';

    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        http_response_code(404);
        require APP_ROOT . '/views/404.php';
    }
}

/**
 * Truncate a text string to a specified length with ellipsis.
 *
 * @param string $text   The text to truncate.
 * @param int    $length The maximum character length.
 * @return string The truncated text with ellipsis if exceeded.
 */
function truncateText(string $text, int $length = 100): string
{
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '...';
}

/**
 * Generate a CSRF token and store it in the session.
 *
 * @return string The generated CSRF token.
 */
function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Render a hidden CSRF token input field for forms.
 *
 * @return string The HTML input element containing the CSRF token.
 */
function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . csrfToken() . '">';
}

/**
 * Validate the submitted CSRF token against the session token.
 *
 * @return bool True if the token is valid.
 */
function validateCsrf(): bool
{
    $token = $_POST['csrf_token'] ?? '';
    if (empty($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        return false;
    }
    unset($_SESSION['csrf_token']);
    return true;
}

/**
 * Resolve the web-accessible URL for a menu item image.
 *
 * Returns the full URL to the menu image if the filename is provided
 * and the file physically exists on the server. Falls back to the
 * committed default.png asset when the image is missing or empty.
 *
 * @param string|null $imageName The stored image filename from the database.
 * @return string The absolute URL to the menu image or the default fallback.
 */
function getMenuImageUrl(?string $imageName): string
{
    if (!empty($imageName) && file_exists(MENU_UPLOAD_DIR . $imageName)) {
        return MENU_UPLOAD_URL . $imageName;
    }

    return MENU_UPLOAD_URL . 'default.png';
}

/**
 * Read and consume file-based notifications for the current customer.
 *
 * Reads the JSON notification file for the given user ID, returns
 * the notification messages, and deletes the file so that each
 * notification is displayed exactly once.
 *
 * @param int $userId The customer user ID.
 * @return array List of notification message strings.
 */
function getCustomerNotifications(int $userId): array
{
    $file = PUBLIC_ROOT . '/uploads/.notifications/' . $userId . '.json';
    if (!file_exists($file)) {
        return [];
    }

    $data = json_decode(file_get_contents($file), true);
    unlink($file);

    if (!is_array($data)) {
        return [];
    }

    return array_column($data, 'message');
}
