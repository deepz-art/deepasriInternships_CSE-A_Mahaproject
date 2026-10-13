<?php
session_start();
require_once __DIR__ . '/config/database.php';
$data = db_load(); $error=''; $email='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email=trim($_POST['email']??''); $password=(string)($_POST['password']??'');
    $user=db_find_user_by_email($data,$email);
    if(!$user || !password_verify($password,$user['password'])) $error='Invalid email or password.';
    else { session_regenerate_id(true); $_SESSION['user_id']=$user['id']; $_SESSION['name']=$user['name']; $_SESSION['role']=$user['role']; header('Location: '.($user['role']==='student'?'student/dashboard.php':'company/dashboard.php')); exit; }
}
?><!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Sign In · DEEPASRI</title><link rel="stylesheet" href="css/style.css?v=blue-toggle-2"></head><body class="auth-page"><div class="auth-container"><div class="auth-brand"><a href="index.php" class="logo">DEEPASRI</a><p class="eyebrow" style="margin-top:55px">WELCOME BACK</p><h1>Your next opportunity is waiting.</h1><p>Sign in to manage your profile, applications or internship listings.</p></div><div class="auth-card"><h2>Sign in</h2><p class="muted">Use the account you created on DEEPASRI.</p><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif; ?><form method="POST" onsubmit="return validateLogin()"><label>Email address</label><input type="email" name="email" id="email" value="<?=e($email)?>" placeholder="you@example.com" required><label for="password">Password</label><div class="password-field"><input type="password" name="password" id="password" placeholder="Your password" autocomplete="current-password" required><button class="password-toggle" type="button" onclick="togglePasswordVisibility('password', this)" aria-controls="password" aria-label="Show password" aria-pressed="false">Show</button></div><button class="btn primary full" type="submit">Sign in</button></form><p class="auth-bottom">New here? <a href="register.php">Create an account</a></p></div></div><script src="js/validation.js?v=blue-toggle-2"></script></body></html>
