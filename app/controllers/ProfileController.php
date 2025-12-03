<?php
require_once __DIR__ . '/../core/Database.php';
class ProfileController {

    public function profile() {
        require_once __DIR__ . '/../models/Setting.php';
        $useTabler = true;

        session_start();
        $settingModel = new Setting((new Database())->getConnection());
        $settings = $settingModel->all(); 
        $pageCss = "profile";
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=home");
            exit;
        }
        include __DIR__ . '/../views/layouts/header.php';
        include __DIR__ . '/../views/profile.php';
        include __DIR__ . '/../views/layouts/footer.php';
    }

    public function updateProfile() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=home");
            exit;
        }
        $db = (new Database())->getConnection();
        $userId = (int)$_SESSION['user']['id'];

        $curStmt = $db->prepare('SELECT fullname, email, phone, address, password FROM users WHERE id = ?');
        $curStmt->bind_param('i', $userId);
        $curStmt->execute();
        $current = $curStmt->get_result()->fetch_assoc() ?: ['fullname'=>'','email'=>'','phone'=>'','address'=>'','password'=>''];

        $fullname = array_key_exists('fullname', $_POST) ? trim((string)$_POST['fullname']) : $current['fullname'];
        $email    = array_key_exists('email', $_POST)    ? trim((string)$_POST['email'])    : $current['email'];
        $phone    = array_key_exists('phone', $_POST)    ? trim((string)$_POST['phone'])    : $current['phone'];
        $address  = array_key_exists('address', $_POST)  ? trim((string)$_POST['address'])  : $current['address'];
        
        $currentPassword = trim($_POST['current_password'] ?? '');
        $newPassword     = trim($_POST['new_password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');
        $requestPasswordChange = ($currentPassword !== '' || $newPassword !== '' || $confirmPassword !== '');

        $errors = [];
        if ($fullname === '' || $fullname === null) {
            $errors['fullname'] = 'Họ và tên là bắt buộc.';
        } elseif (mb_strlen($fullname) > 100) {
            $errors['fullname'] = 'Họ và tên tối đa 100 ký tự.';
        }
        if ($email !== '' && $email !== null) {
            if (mb_strlen($email) > 100) {
                $errors['email'] = 'Email tối đa 100 ký tự.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ.';
            }
        }
        if ($phone !== '' && $phone !== null) {
            if (mb_strlen($phone) > 20) {
                $errors['phone'] = 'Số điện thoại tối đa 20 ký tự.';
            } elseif (!preg_match('/^\+?[0-9\s\-]{8,15}$/', $phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ.';
            }
        }
        if ($address !== '' && $address !== null) {
            if (mb_strlen($address) > 255) {
                $errors['address'] = 'Địa chỉ tối đa 255 ký tự.';
            }
        }
        $hashedNewPassword = null;
        if ($requestPasswordChange) {
            if ($currentPassword === '') {
                $errors['current_password'] = 'Nhập mật khẩu hiện tại.';
            } elseif (!password_verify($currentPassword, $current['password'])) {
                $errors['current_password'] = 'Mật khẩu hiện tại không đúng.';
            }
            if ($newPassword === '') {
                $errors['new_password'] = 'Nhập mật khẩu mới.';
            }
            if ($confirmPassword === '') {
                $errors['confirm_password'] = 'Xác nhận mật khẩu.';
            } elseif ($newPassword !== $confirmPassword) {
                $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
            }
            if (empty($errors['new_password']) && empty($errors['confirm_password'])) {
                if ($newPassword !== '' && $newPassword === $confirmPassword && empty($errors['current_password'])) {
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                }
            }
        }

        $avatarName = null;

        $avatarsDir = __DIR__ . '/../../avatars';
        if (!is_dir($avatarsDir)) {
            @mkdir($avatarsDir, 0775, true);
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $tmp  = $_FILES['avatar']['tmp_name'];
            $type = mime_content_type($tmp);
            $ext  = '.jpg';
            if ($type === 'image/png') $ext = '.png';
            elseif ($type === 'image/jpeg') $ext = '.jpg';
            elseif ($type === 'image/webp') $ext = '.webp';
            else {
                $ext = null;
            }
            if ($ext) {
                $hash = sha1($userId . '-' . time() . '-' . bin2hex(random_bytes(8)));
                $avatarName = $hash . $ext;
                move_uploaded_file($tmp, $avatarsDir . '/' . $avatarName);
            }
        }

        if (!empty($errors)) {
            $_SESSION['profile_errors'] = $errors;
            $_SESSION['profile_old'] = [
                'fullname' => $fullname,
                'email'    => $email,
                'phone'    => $phone,
                'address'  => $address,
            ];
            header("Location: index.php?page=profile");
            exit;
        }

        $fields = 'fullname = ?, email = ?, phone = ?, address = ?';
        $types  = 'ssss';
        $params = [ $fullname, $email, $phone, $address ];
        if ($avatarName) {
            $fields .= ', avatar = ?';
            $types  .= 's';
            $params[] = $avatarName;
        }
        if ($hashedNewPassword) {
            $fields .= ', password = ?';
            $types  .= 's';
            $params[] = $hashedNewPassword;
        }
        $types .= 'i';
        $params[] = $userId;
        $sql = 'UPDATE users SET ' . $fields . ' WHERE id = ?';
        $stmt = $db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        $stmt2 = $db->prepare('SELECT id, username, fullname, email, phone, address, role, avatar FROM users WHERE id = ?');
        $stmt2->bind_param('i', $userId);
        $stmt2->execute();
        $row = $stmt2->get_result()->fetch_assoc();
        if ($row) {
            $_SESSION['user'] = $row;
        }

        header("Location: index.php?page=profile");
        exit;
    }
}
