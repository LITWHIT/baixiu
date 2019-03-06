<?php 
// 登录页面
// 简单登录业务逻辑用（用户信息校验, 页面跳转）
//   数据库连接查询user_info
// 表单状态保存（保存用户名）
// 用户状态保存（Cookie、Session）

// 登录函数
function login () {
  if (empty($_POST['email'])) {
    $GLOBALS['message'] = '请输入邮箱';
    return;
  }
  
  if (empty($_POST['password'])) {
    $GLOBALS['message'] = '请输入密码';
    return;
  }

  // 接收表单提交的数据
  $email = $_POST['email'];
  $password = $_POST['password'];

  // 用户信息校验(数据库查询,和数据库里的数据对比)
  // 建立与数据库的连接(连接通道)
  $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  // 判断是否连接成功
  if (!$connection) {
    // 连接失败，提示错误信息
    die('<h1>Connect Error (' . mysqli_connect_erron() . ')' . mysqli_connect_error() . '</h1>');
  }
  // 根据邮箱查询用户信息， limit 可以提高效率
  $result = mysqli_query($connection, sprintf("select * from users where email = '%s' limit 1", $email));
  if ($result) {
    // 查询成功，获取查询结果
    if ($user = mysqli_fetch_assoc($result)) {
      // 用户存在，对比密码
      if ($user['password'] === $password) {
        // 校验通过后，用Cookie保存用户的登录状态
        // setcookie('current_login_user', 'true');

        // 启用Session
        session_start();
        // 记住登录状态
        $_SESSION['current_login_user'] = true;
        // 密码匹配，跳转到首页
        header('Location: ./index.php');
        exit; // 结束脚本运行
      }
      // 密码不匹配
      $GLOBALS['message'] = '邮箱与密码不匹配';
      // 释放资源
      mysqli_free_result($result);
    }
  } else {
    // 查询失败
    $GLOBALS['message'] = '该邮箱未注册，请重新输入邮箱';
  }
  // 关闭与数据库之间的连接
  mysqli_close($connection);
}
// 载入配置文件
require_once '../config.php';

// 判断是否是 POST 请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // POST请求， 判断登录框是否输入完整 
  login();
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/animate/animate.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <!-- 补全form标签的属性, action=提交url地址为该文件本身 method=post提交方式-->
    <form class="login-wrap<?php echo isset($message) ? ' swing animated' : '' ?>" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时 展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 用户名或密码错误！
      </div> -->
      <?php if (isset($message)) : ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif; ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" class="form-control" placeholder="邮箱" autofocus value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <!-- form表单提交按钮的类型必须为'submit' -->
      <button class="btn btn-primary btn-block" type="submit">登 录</button>
    </form>
  </div>
</body>
</html>
