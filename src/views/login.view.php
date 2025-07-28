<?php 
if (!defined('VALID_REQUEST')) 
    die(); 

use function Core\Html\printCsrfToken; 
?>

<style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            border-radius: 12px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
</style>

<div class="login-container">
    <h3 class="text-center mb-4">Login | Đăng nhập</h3>
    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>
    <form action="./login" method="post">
        <?php printCsrfToken(); ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username | Tên đăng nhập</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password | Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Thực hiện</button>
        </div>
    </form>
</div>